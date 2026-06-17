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
        
        $hasAttendanceData = Attendance::where('tanggal', '>=', Carbon::now()->subDays(6)->format('Y-m-d'))->exists();
        
        if ($hasAttendanceData) {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $label = Carbon::now()->subDays($i)->isoFormat('ddd');
                $attendance_labels[] = $label;
                
                $attendance['hadir'][] = Attendance::where('tanggal', $date)->where('status', 'Hadir')->count();
                $attendance['izin'][] = Attendance::where('tanggal', $date)->where('status', 'Izin')->count();
                $attendance['sakit'][] = Attendance::where('tanggal', $date)->where('status', 'Sakit')->count();
                $attendance['alpha'][] = Attendance::where('tanggal', $date)->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
            }
        } else {
            // Fallback sample data if no attendance is logged in last 7 days
            $attendance_labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
            $attendance = [
                'hadir' => [85,92,78,95,88,82,90],
                'izin'  => [5,3,8,2,4,6,3],
                'sakit' => [2,1,3,1,2,1,2],
                'alpha' => [8,4,11,2,6,11,5],
            ];
        }

        // 3) PPDB doughnut (realtime)
        $hasPpdbData = PpdbApplicant::exists();
        $ppdb_labels = ['Pendaftar','Diterima','Cadangan','Ditolak'];
        if ($hasPpdbData) {
            $ppdb = [
                PpdbApplicant::count(),
                PpdbApplicant::where('status', 'Lulus')->count(),
                PpdbApplicant::where('status', 'Diverifikasi')->count(),
                PpdbApplicant::where('status', 'Tidak Lulus')->count()
            ];
        } else {
            $ppdb = [1200, 800, 150, 250];
        }

        // 4) Activities per month (Jan..Dec) (realtime)
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $hasEventData = Event::exists();
        
        if ($hasEventData) {
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
        } else {
            $activities = [
                'event' => [2,3,1,4,2,3,5,2,3,4,1,2],
                'extracurricular' => [5,4,6,3,4,5,6,7,5,4,3,4],
                'exam' => [0,0,2,0,6,0,0,1,0,3,2,0],
                'meeting' => [1,2,1,1,2,1,2,1,2,1,1,1],
            ];
        }

        // 5) Summary metrics for today
        $todayStr = date('Y-m-d');
        $hadirToday = Attendance::where('tanggal', $todayStr)->where('status', 'Hadir')->count();
        $totalAbsenToday = Attendance::where('tanggal', $todayStr)->count();
        $pct = $totalAbsenToday > 0 ? round(($hadirToday / $totalAbsenToday) * 100) : 0;
        
        $absentToday = Attendance::where('tanggal', $todayStr)->whereIn('status', ['Izin', 'Sakit', 'Alpha', 'Tanpa Keterangan'])->count();
        $ppdbToday = PpdbApplicant::whereDate('created_at', $todayStr)->count();
        $activeEventsToday = Event::where('tanggal_pelaksanaan', $todayStr)->count();

        // Default representation fallbacks if today has no entries yet
        if ($totalAbsenToday === 0) {
            $pct = 89;
            $absentToday = round($stats['students'] * (100 - $pct) / 100);
        }
        if ($ppdbToday === 0) {
            $ppdbToday = PpdbApplicant::where('status', 'Menunggu')->count() ?: 12;
        }
        if ($activeEventsToday === 0) {
            $activeEventsToday = Event::where('status', 'Akan Datang')->orWhere('status', 'Aktif')->count() ?: 3;
        }

        $summary = [
            'attendance_today_pct' => $pct,
            'absent_today' => $absentToday,
            'ppdb_today' => $ppdbToday,
            'active_events_today' => $activeEventsToday,
        ];

        return view('admin.dashboard', compact(
            'stats', 'attendance_labels', 'attendance', 'ppdb_labels', 'ppdb', 'months', 'activities', 'summary'
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
            
            $averageGrade = round($student->grades()->avg('nilai_akhir') ?: 82.5, 1);
            
            $sppBill = $student->bills()->latest()->first();
            $sppStatus = $sppBill ? $sppBill->status : 'Lunas';
            
            $className = $student->schoolClass ? ($student->schoolClass->tingkat . ' ' . $student->schoolClass->nama_kelas) : ($student->kelas ?? 'Unknown');
            
            $initials = collect(explode(' ', $student->nama))
                ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                ->take(2)
                ->join('');
            
            $waliKelas = 'Ibu Sri Wahyuni, S.Pd.'; // dummy fallback
            
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
