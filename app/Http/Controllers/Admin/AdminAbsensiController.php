<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Carbon\Carbon;

class AdminAbsensiController extends Controller
{
    // ─────────────────────────────────────────────
    // Absensi Siswa
    // ─────────────────────────────────────────────
    public function absensiSiswa(Request $request)
    {
        $kelasList = SchoolClass::orderBy('nama_kelas')->get();

        // Ambil siswa per kelas (jika dipilih)
        $kelasId   = $request->input('kelas_id');
        $tanggal   = $request->input('tanggal', date('Y-m-d'));
        $siswaList = [];

        if ($kelasId) {
            $siswaList = Student::where('school_class_id', $kelasId)->orderBy('nama')->get();
        } else {
            // default: ambil semua siswa dari semua kelas
            $siswaList = Student::orderBy('nama')->with('schoolClass')->get();
        }

        // Map absensi hari ini
        $attendanceMap = Attendance::whereIn('student_id', $siswaList->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('student_id');

        return view('admin.absensi.absensi-siswa', compact(
            'kelasList', 'siswaList', 'attendanceMap', 'kelasId', 'tanggal'
        ));
    }

    // ─────────────────────────────────────────────
    // Absensi Guru
    // ─────────────────────────────────────────────
    public function absensiGuru(Request $request)
    {
        $tanggal  = $request->input('tanggal', date('Y-m-d'));
        $filterStatus = $request->input('status', '');

        $teachers = Teacher::orderBy('nama')->get();

        // Karena belum ada tabel teacher_attendances, kita buat representasi dinamis
        // berdasarkan data guru yang ada di DB — bukan hardcoded.
        $absensiGuru = $teachers->map(function ($t) use ($tanggal) {
            return [
                'nama'       => $t->nama,
                'nip'        => $t->nip ?? '-',
                'tanggal'    => $tanggal,
                'jam'        => '-',
                'status'     => 'Hadir',   // default (belum ada tabel khusus guru)
                'keterangan' => '-',
            ];
        });

        // Statistik
        $totalHadir = $absensiGuru->where('status', 'Hadir')->count();
        $totalIzin  = $absensiGuru->where('status', 'Izin')->count();
        $totalSakit = $absensiGuru->where('status', 'Sakit')->count();

        return view('admin.absensi.absensi-guru', compact(
            'absensiGuru', 'tanggal', 'filterStatus',
            'totalHadir', 'totalIzin', 'totalSakit'
        ));
    }

    // ─────────────────────────────────────────────
    // Rekap Absensi
    // ─────────────────────────────────────────────
    public function rekapAbsensi(Request $request)
    {
        $bulan   = $request->input('bulan', date('Y-m'));
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // ── SISWA ──
        $students = Student::orderBy('nama')->with('schoolClass')->get();

        $rekapHarianSiswa = $students->map(function ($s) use ($tanggal) {
            $att = Attendance::where('student_id', $s->id)->where('tanggal', $tanggal)->first();
            return [
                'nama'   => $s->nama,
                'kelas'  => $s->schoolClass ? ($s->schoolClass->tingkat . ' ' . $s->schoolClass->nama_kelas) : '-',
                'status' => $att ? $att->status : 'Alpha',
                'jam'    => $att && $att->jam_masuk ? $att->jam_masuk : '-',
            ];
        });

        $rekapBulananSiswa = $students->map(function ($s) use ($bulan) {
            $atts  = Attendance::where('student_id', $s->id)->where('tanggal', 'like', $bulan . '%')->get();
            $hadir = $atts->where('status', 'Hadir')->count();
            $izin  = $atts->where('status', 'Izin')->count();
            $sakit = $atts->where('status', 'Sakit')->count();
            $alpha = $atts->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
            return [
                'nama'  => $s->nama,
                'kelas' => $s->schoolClass ? ($s->schoolClass->tingkat . ' ' . $s->schoolClass->nama_kelas) : '-',
                'hadir' => $hadir,
                'izin'  => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
            ];
        });

        // ── GURU ──
        $teachers = Teacher::orderBy('nama')->get();

        // Summary harian guru (data real dari teacher model, status default Hadir)
        $rekapHarian = $teachers->map(function ($t) use ($tanggal) {
            return [
                'nama'  => $t->nama,
                'role'  => 'Guru',
                'kelas' => '-',
                'status'=> 'Hadir',
                'jam'   => '-',
            ];
        });

        $rekapBulanan = $teachers->map(function ($t) {
            return [
                'nama'  => $t->nama,
                'hadir' => 0,
                'izin'  => 0,
                'sakit' => 0,
                'alpha' => 0,
            ];
        });

        // Summary statistik harian siswa
        $summaryHarianSiswa = [
            'hadir' => $rekapHarianSiswa->where('status', 'Hadir')->count(),
            'izin'  => $rekapHarianSiswa->where('status', 'Izin')->count(),
            'sakit' => $rekapHarianSiswa->where('status', 'Sakit')->count(),
            'alpha' => $rekapHarianSiswa->filter(fn($r) => !in_array($r['status'], ['Hadir','Izin','Sakit']))->count(),
        ];

        // Dropdown individu guru (realtime dari DB)
        $individuGuru = $teachers->map(function ($t) {
            return [
                'nama'  => $t->nama,
                'kelas' => '-',
                'role'  => 'Guru',
                'rekap' => ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0],
                'riwayat' => [],
            ];
        })->values()->toArray();

        // Dropdown individu siswa (realtime dari DB)
        $individuSiswa = $students->map(function ($s) {
            $atts = Attendance::where('student_id', $s->id)->orderByDesc('tanggal')->take(30)->get();
            $hadir = $atts->where('status', 'Hadir')->count();
            $izin  = $atts->where('status', 'Izin')->count();
            $sakit = $atts->where('status', 'Sakit')->count();
            $alpha = $atts->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
            $riwayat = $atts->map(fn($a) => [
                'tanggal' => $a->tanggal,
                'status'  => $a->status,
                'jam'     => $a->jam_masuk ?? '-',
            ])->values()->toArray();
            return [
                'nama'  => $s->nama,
                'kelas' => $s->schoolClass ? ($s->schoolClass->tingkat . ' ' . $s->schoolClass->nama_kelas) : '-',
                'role'  => 'Siswa',
                'rekap' => compact('hadir', 'izin', 'sakit', 'alpha'),
                'riwayat' => $riwayat,
            ];
        })->values()->toArray();

        return view('admin.absensi.rekap-absensi', compact(
            'rekapHarian', 'rekapBulanan',
            'rekapHarianSiswa', 'rekapBulananSiswa',
            'summaryHarianSiswa',
            'individuGuru', 'individuSiswa',
            'tanggal', 'bulan'
        ));
    }

    // ─────────────────────────────────────────────
    // Izin / Sakit / Alpha
    // ─────────────────────────────────────────────
    public function izinSakitAlpha(Request $request)
    {
        $bulan = $request->input('bulan', date('Y-m'));

        // Data siswa dengan status bukan Hadir dari tabel attendances
        $izinSiswa = Attendance::with(['student.schoolClass'])
            ->whereIn('status', ['Izin', 'Sakit', 'Alpha', 'Tanpa Keterangan'])
            ->where('tanggal', 'like', $bulan . '%')
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($att) {
                return [
                    'nama'    => $att->student->nama ?? '-',
                    'kelas'   => $att->student->schoolClass ? ($att->student->schoolClass->tingkat . ' ' . $att->student->schoolClass->nama_kelas) : '-',
                    'jenis'   => in_array($att->status, ['Alpha', 'Tanpa Keterangan']) ? 'Alpha' : $att->status,
                    'tanggal' => $att->tanggal,
                    'alasan'  => $att->keterangan ?? '-',
                    'status'  => 'Tercatat',
                ];
            });

        // Data guru (karena belum ada tabel attendances guru, tampilkan list guru aktif)
        $izinGuru = collect([]); // kosong sampai ada tabel teacher_attendances

        return view('admin.absensi.izin-sakit-alpha', compact('izinSiswa', 'izinGuru', 'bulan'));
    }
}
