<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\Attendance;
use App\Models\PpdbApplicant;
use App\Models\Event;
use App\Models\ParentProfile;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1) Stats cards (realtime)
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'classes'  => SchoolClass::count(),
            'users'    => User::count(),
        ];

        // 2) Attendance - last 7 days (Mon..Sun)
        $attendance_labels = [];
        $attendance = [
            'hadir' => [],
            'izin'  => [],
            'sakit' => [],
            'alpha' => [],
        ];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->isoFormat('ddd');
            $attendance_labels[] = $label;
            
            $attendance['hadir'][] = Attendance::where('tanggal', $date)->where('status', 'Hadir')->count();
            $attendance['izin'][] = Attendance::where('tanggal', $date)->where('status', 'Izin')->count();
            $attendance['sakit'][] = Attendance::where('tanggal', $date)->where('status', 'Sakit')->count();
            $attendance['alpha'][] = Attendance::where('tanggal', $date)->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
        }

        // 3) PPDB doughnut (realtime)
        $ppdb_labels = ['Pendaftar','Diterima','Cadangan','Ditolak'];
        $ppdb = [
            PpdbApplicant::count(),
            PpdbApplicant::where('status', 'Lulus')->count(),
            PpdbApplicant::where('status', 'Diverifikasi')->count(),
            PpdbApplicant::where('status', 'Tidak Lulus')->count()
        ];

        // 4) Activities per month (Jan..Dec) (realtime)
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $activities = [
            'event' => [],
            'extracurricular' => [],
            'exam' => [],
            'meeting' => [],
        ];
        for ($m = 1; $m <= 12; $m++) {
            $monthStr = str_pad($m, 2, '0', STR_PAD_LEFT);
            $activities['event'][] = Event::where('tipe_info', 'Event')->where('tanggal_pelaksanaan', 'like', "%-$monthStr-%")->count();
            $activities['extracurricular'][] = Event::where('tipe_info', 'Agenda')->where('tanggal_pelaksanaan', 'like', "%-$monthStr-%")->count();
            $activities['exam'][] = Event::where('tipe_info', 'Dokumentasi')->where('tanggal_pelaksanaan', 'like', "%-$monthStr-%")->count();
            $activities['meeting'][] = Event::where('tipe_info', 'Pengumuman')->where('tanggal_pelaksanaan', 'like', "%-$monthStr-%")->count();
        }

        // 5) Summary metrics for today
        $todayStr = date('Y-m-d');
        $hadirToday = Attendance::where('tanggal', $todayStr)->where('status', 'Hadir')->count();
        $totalAbsenToday = Attendance::where('tanggal', $todayStr)->count();
        $pct = $totalAbsenToday > 0 ? round(($hadirToday / $totalAbsenToday) * 100) : 0;
        
        $absentToday = Attendance::where('tanggal', $todayStr)->whereIn('status', ['Izin', 'Sakit', 'Alpha', 'Tanpa Keterangan'])->count();
        $ppdbToday = PpdbApplicant::whereDate('created_at', $todayStr)->count();
        $activeEventsToday = Event::where('tanggal_pelaksanaan', $todayStr)->count();

        $summary = [
            'attendance_today_pct' => $pct,
            'absent_today' => $absentToday,
            'ppdb_today' => $ppdbToday,
            'active_events_today' => $activeEventsToday,
        ];

        // 6) Laporan Hari Ini
        $recentPpdb = PpdbApplicant::latest()->take(3)->get()->map(function($p) {
            return [
                'type' => 'ppdb',
                'title' => $p->nama . ' mendaftar PPDB',
                'desc' => 'Pendaftaran jalur ' . ($p->jalur ?? 'Umum'),
                'time' => $p->created_at->diffForHumans(),
                'status' => $p->status,
                'created_at' => $p->created_at
            ];
        });

        $recentEvents = Event::latest()->take(3)->get()->map(function($e) {
            return [
                'type' => 'event',
                'title' => $e->judul,
                'desc' => $e->tipe_info . ' baru ditambahkan',
                'time' => $e->created_at->diffForHumans(),
                'status' => 'Info',
                'created_at' => $e->created_at
            ];
        });

        $laporanHariIni = collect($recentPpdb)->merge($recentEvents)->sortByDesc('created_at')->take(5)->values()->toArray();

        // 7) Aktivitas Sekolah (Jadwal Hari Ini)
        $hariIndo = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalSekolah = \App\Models\Schedule::where('hari', $hariIndo)
            ->with(['subject.teacher', 'schoolClass'])
            ->orderBy('jam_mulai')
            ->take(5)
            ->get();

        // 8) Notifikasi Sistem
        $notifikasiSistem = [];
        
        $classesLowAttendance = SchoolClass::with('students')->get()->filter(function($c) use ($todayStr) {
            $studentIds = $c->students->pluck('id');
            if ($studentIds->isEmpty()) return false;
            $hadir = Attendance::whereIn('student_id', $studentIds)->where('tanggal', $todayStr)->where('status', 'Hadir')->count();
            $total = Attendance::whereIn('student_id', $studentIds)->where('tanggal', $todayStr)->count();
            if ($total == 0) return false;
            return ($hadir / $total) < 0.75;
        });

        foreach($classesLowAttendance as $c) {
            $notifikasiSistem[] = [
                'type' => 'warning',
                'icon' => 'alert-triangle',
                'title' => 'Kehadiran Rendah',
                'desc' => 'Kelas ' . $c->nama_kelas . ' memiliki tingkat kehadiran di bawah 75% hari ini.'
            ];
        }

        $pendingPpdb = PpdbApplicant::where('status', 'Menunggu')->count();
        if ($pendingPpdb > 0) {
            $notifikasiSistem[] = [
                'type' => 'info',
                'icon' => 'info',
                'title' => 'Verifikasi PPDB',
                'desc' => 'Ada ' . $pendingPpdb . ' pendaftar PPDB yang menunggu verifikasi.'
            ];
        }

        $notifikasiSistem[] = [
            'type' => 'success',
            'icon' => 'check-circle',
            'title' => 'Sistem Aktif',
            'desc' => 'Semua modul sekolah dan layanan GoEdu berjalan normal.'
        ];

        return view('admin.dashboard', compact(
            'stats', 'attendance_labels', 'attendance', 'ppdb_labels', 'ppdb', 'months', 'activities', 'summary',
            'laporanHariIni', 'jadwalSekolah', 'notifikasiSistem'
        ));
    }

    public function orangtua()
    {
        $user = auth()->user();
        $parent = $user ? $user->parent : null;
        $students = collect();
        if ($parent) {
            $parentProfiles = ParentProfile::where('user_id', $user->id)->with('student.schoolClass')->get();
            $students = $parentProfiles->map(function($pp) {
                return $pp->student;
            })->filter();
        }
        
        if ($students->isEmpty()) {
            $students = Student::with('schoolClass')->take(2)->get();
        }
        
        $childrenData = [];
        foreach ($students as $student) {
            if (!$student) continue;
            
            $hadirCount = Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count();
            $totalAbsen = Attendance::where('student_id', $student->id)->count();
            $attendancePct = $totalAbsen > 0 ? round(($hadirCount / $totalAbsen) * 100) : 100;
            
            $averageGrade = round($student->grades()->avg('nilai_akhir') ?: 0, 1);
            
            $sppBill = $student->bills()->latest()->first();
            $sppStatus = $sppBill ? $sppBill->status : 'Lunas';
            
            $className = $student->schoolClass ? ($student->schoolClass->tingkat . ' ' . $student->schoolClass->nama_kelas) : ($student->kelas ?? 'Unknown');
            
            $initials = collect(explode(' ', $student->nama))
                ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                ->take(2)
                ->join('');
            
            $waliKelas = '-';
            if ($student->schoolClass && $student->schoolClass->teacher) {
                $waliKelas = $student->schoolClass->teacher->nama;
            }
            
            $childrenData[] = [
                'id' => $student->id,
                'nama' => $student->nama,
                'nisn' => $student->nisn ?? 'N/A',
                'inisial' => $initials,
                'kelas' => $className,
                'kehadiran' => $attendancePct . '%',
                'rata_rata' => $averageGrade,
                'spp' => $sppStatus,
                'wali_kelas' => $waliKelas,
            ];
        }
        
        return view('orangtua.dashboard', compact('childrenData'));
    }
}
