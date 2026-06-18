<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\PpdbApplicant;
use App\Models\Event;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_siswa' => Student::count(),
            'total_guru' => Teacher::count(),
            'spp_pemasukan' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->sum('nominal'),
            'ppdb_pendaftar' => PpdbApplicant::count(),
            'total_kegiatan' => Event::count(),
        ];

        return view('admin.laporan.index', compact('stats'));
    }

    public function absensi(Request $request)
    {
        $mode = $request->input('mode', 'harian');
        $role = $request->input('role', 'siswa');
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $bulan = $request->input('bulan', date('Y-m'));

        $summary = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        $rekapHarian = [];
        $rekapBulanan = [];

        if ($role === 'siswa') {
            $students = Student::orderBy('nama')->get();

            if ($mode === 'harian') {
                foreach ($students as $student) {
                    $attendance = Attendance::where('student_id', $student->id)
                        ->where('tanggal', $tanggal)
                        ->first();

                    $status = $attendance ? $attendance->status : 'Alpha'; // default to Alpha if no attendance record
                    
                    if (strtolower($status) === 'hadir') $summary['hadir']++;
                    elseif (strtolower($status) === 'izin') $summary['izin']++;
                    elseif (strtolower($status) === 'sakit') $summary['sakit']++;
                    else $summary['alpha']++;

                    $rekapHarian[] = [
                        'nama' => $student->nama,
                        'hadir' => strtolower($status) === 'hadir',
                        'izin' => strtolower($status) === 'izin',
                        'sakit' => strtolower($status) === 'sakit',
                        'alpha' => strtolower($status) === 'alpha' || strtolower($status) === 'tanpa keterangan',
                    ];
                }
            } else {
                // Bulanan
                $yearMonth = Carbon::parse($bulan);
                foreach ($students as $student) {
                    $attendances = Attendance::where('student_id', $student->id)
                        ->where('tanggal', 'like', $bulan . '%')
                        ->get();

                    $hadir = $attendances->where('status', 'Hadir')->count();
                    $izin = $attendances->where('status', 'Izin')->count();
                    $sakit = $attendances->where('status', 'Sakit')->count();
                    $alpha = $attendances->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();

                    $summary['hadir'] += $hadir;
                    $summary['izin'] += $izin;
                    $summary['sakit'] += $sakit;
                    $summary['alpha'] += $alpha;

                    $rekapBulanan[] = [
                        'nama' => $student->nama,
                        'hadir' => $hadir,
                        'izin' => $izin,
                        'sakit' => $sakit,
                        'alpha' => $alpha,
                    ];
                }
            }
        } else {
            $teachers = Teacher::orderBy('nama')->get();
            if ($mode === 'harian') {
                foreach ($teachers as $teacher) {
                    $attendance = \App\Models\TeacherAttendance::where('teacher_id', $teacher->id)
                        ->where('tanggal', $tanggal)
                        ->first();

                    $status = $attendance ? $attendance->status : 'Alpha';
                    
                    if (strtolower($status) === 'hadir') $summary['hadir']++;
                    elseif (strtolower($status) === 'izin') $summary['izin']++;
                    elseif (strtolower($status) === 'sakit') $summary['sakit']++;
                    else $summary['alpha']++;

                    $rekapHarian[] = [
                        'nama' => $teacher->nama,
                        'hadir' => strtolower($status) === 'hadir',
                        'izin' => strtolower($status) === 'izin',
                        'sakit' => strtolower($status) === 'sakit',
                        'alpha' => strtolower($status) === 'alpha' || strtolower($status) === 'tanpa keterangan',
                    ];
                }
            } else {
                foreach ($teachers as $teacher) {
                    $attendances = \App\Models\TeacherAttendance::where('teacher_id', $teacher->id)
                        ->where('tanggal', 'like', $bulan . '%')
                        ->get();

                    $hadir = $attendances->where('status', 'Hadir')->count();
                    $izin = $attendances->where('status', 'Izin')->count();
                    $sakit = $attendances->where('status', 'Sakit')->count();
                    $alpha = $attendances->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();

                    $summary['hadir'] += $hadir;
                    $summary['izin'] += $izin;
                    $summary['sakit'] += $sakit;
                    $summary['alpha'] += $alpha;

                    $rekapBulanan[] = [
                        'nama' => $teacher->nama,
                        'hadir' => $hadir,
                        'izin' => $izin,
                        'sakit' => $sakit,
                        'alpha' => $alpha,
                    ];
                }
            }
        }

        return view('admin.laporan.absensi', compact('mode', 'role', 'tanggal', 'bulan', 'summary', 'rekapHarian', 'rekapBulanan'));
    }

    public function akademik(Request $request)
    {
        $semester = $request->input('semester', 'Ganjil');
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        $kelasList = $classes->map(function($c) {
            return $c->tingkat . ' ' . $c->nama_kelas;
        })->toArray();

        // Default active class
        $kelasAktif = $request->input('kelas', count($kelasList) > 0 ? $kelasList[0] : 'X RPL 1');

        // Find the active class model
        $parts = explode(' ', $kelasAktif, 2);
        $tingkat = $parts[0] ?? '';
        $namaKelas = $parts[1] ?? '';
        $activeClass = SchoolClass::where('tingkat', $tingkat)->where('nama_kelas', $namaKelas)->first();

        $students = [];
        $mapelList = [];
        $laporan = [];
        $classAverage = 0;
        $highestGrade = 0;
        $remedialCount = 0;

        if ($activeClass) {
            $students = Student::where('school_class_id', $activeClass->id)->orderBy('nama')->get();
            $mapelList = Subject::pluck('nama')->toArray(); // Get all subjects for report columns

            $totalGrades = 0;
            $gradeCount = 0;

            foreach ($students as $student) {
                $studentGrades = [];
                $sum = 0;
                $count = 0;

                foreach ($mapelList as $mapelName) {
                    $subject = Subject::where('nama', $mapelName)->first();
                    $grade = null;
                    if ($subject) {
                        $grade = Grade::where('student_id', $student->id)
                            ->where('subject_id', $subject->id)
                            ->first();
                    }

                    $nilai = $grade ? $grade->nilai_akhir : 0; // use 0 if no grade
                    $studentGrades[$mapelName] = $nilai;
                    
                    $sum += $nilai;
                    $count++;

                    if ($nilai > $highestGrade) {
                        $highestGrade = $nilai;
                    }
                    if ($nilai < 75) {
                        $remedialCount++;
                    }

                    $totalGrades += $nilai;
                    $gradeCount++;
                }

                $laporan[] = [
                    'nama' => $student->nama,
                    'kelas' => $kelasAktif,
                    'nilai' => $studentGrades
                ];
            }

            if ($gradeCount > 0) {
                $classAverage = round($totalGrades / $gradeCount, 1);
            }
        }

        return view('admin.laporan.akademik', compact('semester', 'kelasAktif', 'kelasList', 'mapelList', 'laporan', 'classAverage', 'highestGrade', 'remedialCount'));
    }

    public function keuangan(Request $request)
    {
        $selectedBulanNum = $request->input('bulan', date('m'));
        $selectedTahun = $request->input('tahun', date('Y'));

        // Indonesian Month mapping
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $bulanName = $months[$selectedBulanNum] ?? $months[date('m')];

        $yearMonth = $selectedTahun . '-' . $selectedBulanNum;

        // Query transactions
        $pemasukan = Transaction::where('jenis', 'Masuk')
            ->where('status', 'Terverifikasi')
            ->where('tanggal', 'like', $yearMonth . '%')
            ->get()
            ->map(function($t) {
                return [
                    'tanggal' => $t->tanggal,
                    'sumber' => $t->keterangan, // e.g. PPDB, SPP
                    'keterangan' => 'Pembayaran terverifikasi',
                    'jumlah' => $t->nominal
                ];
            })->toArray();

        $pengeluaran = Transaction::where('jenis', 'Keluar')
            ->where('tanggal', 'like', $yearMonth . '%')
            ->get()
            ->map(function($t) {
                return [
                    'tanggal' => $t->tanggal,
                    'kategori' => $t->keterangan,
                    'keterangan' => 'Pengeluaran operasional',
                    'jumlah' => $t->nominal
                ];
            })->toArray();

        $totalMasuk = collect($pemasukan)->sum('jumlah');
        $totalKeluar = collect($pengeluaran)->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.laporan.keuangan', compact('pemasukan', 'pengeluaran', 'totalMasuk', 'totalKeluar', 'saldo', 'bulanName', 'selectedBulanNum', 'selectedTahun', 'months'));
    }

    public function ppdb(Request $request)
    {
        $jurusan = $request->input('jurusan');
        $jalur = $request->input('jalur');
        $status = $request->input('status');

        $query = PpdbApplicant::query();

        if ($jurusan) $query->where('jurusan', $jurusan);
        if ($jalur) $query->where('jalur', $jalur);
        if ($status) $query->where('status', $status);

        $ppdb = $query->latest()->get()->map(function($app) {
            return [
                'no_daftar' => $app->no_daftar ?? ('PPDB-' . str_pad($app->id, 3, '0', STR_PAD_LEFT)),
                'nama' => $app->nama,
                'jurusan' => $app->jurusan ?? 'Umum',
                'jalur' => $app->jalur ?? 'Zonasi',
                'tanggal' => $app->created_at->toDateString(),
                'status' => $app->status ?? 'Menunggu',
            ];
        });

        $totalPendaftar = PpdbApplicant::count();
        $lulus = PpdbApplicant::where('status', 'Lulus')->count();
        $diverifikasi = PpdbApplicant::where('status', 'Diverifikasi')->count();
        $menunggu = PpdbApplicant::where('status', 'Menunggu')->count();

        // Get distinct values for filters
        $jurusanList = PpdbApplicant::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();
        $jalurList = PpdbApplicant::select('jalur')->distinct()->pluck('jalur')->filter()->values();

        return view('admin.laporan.ppdb', compact('ppdb', 'totalPendaftar', 'lulus', 'diverifikasi', 'menunggu', 'jurusanList', 'jalurList', 'jurusan', 'jalur', 'status'));
    }

    public function kegiatan(Request $request)
    {
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $bulan = $request->input('bulan', date('Y-m'));

        $query = Event::query();

        if ($jenis) $query->where('jenis', $jenis);
        if ($status) $query->where('status', $status);
        if ($bulan) $query->where('tanggal_pelaksanaan', 'like', $bulan . '%');

        $kegiatan = $query->latest()->get()->map(function($e) {
            return [
                'nama' => $e->judul,
                'jenis' => $e->jenis ?? 'Umum',
                'kategori' => $e->tipe_info,
                'tanggal' => $e->tanggal_pelaksanaan,
                'penanggung_jawab' => $e->tipe_info === 'Event' ? 'Kesiswaan' : 'Sarpras',
                'status' => $e->status ?? 'Terjadwal',
            ];
        });

        $total = Event::count();
        $selesai = Event::where('status', 'Selesai')->count();
        $terjadwal = Event::where('status', 'Akan Datang')->orWhere('status', 'Aktif')->count();
        $dibatalkan = Event::where('status', 'Arsip')->orWhere('status', 'Draft')->count();

        // Distinct filters
        $jenisList = Event::select('jenis')->distinct()->pluck('jenis')->filter()->values();
        $statusList = Event::select('status')->distinct()->pluck('status')->filter()->values();

        return view('admin.laporan.kegiatan', compact('kegiatan', 'total', 'selesai', 'terjadwal', 'dibatalkan', 'jenisList', 'statusList', 'jenis', 'status', 'bulan'));
    }
}
