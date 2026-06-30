<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;

class AdminAkademikController extends Controller
{
    // ─────────────────────────────────────────────
    // Penilaian
    // ─────────────────────────────────────────────
    public function penilaian(Request $request)
    {
        $kelasList = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get()->map(function($c) {
            return $c->tingkat . ' ' . $c->nama_kelas;
        });
        $mapelList = Subject::orderBy('nama')->pluck('nama');

        // Query dengan eager load
        $query = Grade::with(['student.schoolClass', 'subject'])->orderBy('id', 'desc');

        // Filter kelas
        if ($request->filled('kelas')) {
            $query->whereHas('student.schoolClass', function($q) use ($request) {
                $parts = explode(' ', $request->kelas, 2);
                $tingkat = $parts[0] ?? '';
                $namaKelas = $parts[1] ?? '';
                $q->where('tingkat', $tingkat)->where('nama_kelas', $namaKelas);
            });
        }

        // Filter mapel
        if ($request->filled('mapel')) {
            $query->whereHas('subject', fn($q) =>
                $q->where('nama', $request->mapel)
            );
        }

        $grades = $query->get()->map(function ($g) {
            $tugas  = $g->nilai_uh  ?? 0;
            $uts    = $g->nilai_uts ?? 0;
            $uas    = $g->nilai_uas ?? 0;
            $rata   = $g->nilai_akhir ?? round(($tugas + $uts + $uas) / 3);
            return [
                'id'     => $g->id,
                'nama'   => $g->student->nama ?? '-',
                'nisn'   => $g->student->nisn ?? '-',
                'kelas'  => $g->student->schoolClass ? ($g->student->schoolClass->tingkat . ' ' . $g->student->schoolClass->nama_kelas) : '-',
                'mapel'  => $g->subject->nama ?? '-',
                'tugas'  => $tugas,
                'uts'    => $uts,
                'uas'    => $uas,
                'rata'   => $rata,
                'status' => $rata >= 75 ? 'Lulus' : 'Remedial',
            ];
        });

        $totalLulus    = $grades->where('status', 'Lulus')->count();
        $totalRemedial = $grades->where('status', 'Remedial')->count();
        $rataRata      = $grades->count() > 0 ? round($grades->avg('rata'), 1) : 0;

        return view('admin.akademik.penilaian', compact(
            'grades', 'kelasList', 'mapelList',
            'totalLulus', 'totalRemedial', 'rataRata'
        ));
    }

    // ─────────────────────────────────────────────
    // Rapor
    // ─────────────────────────────────────────────
    public function rapor(Request $request)
    {
        $kelasList = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get()->map(function($c) {
            return $c->tingkat . ' ' . $c->nama_kelas;
        });

        // Ambil semua siswa yang punya grades, grouped by kelas
        $students = Student::with(['schoolClass', 'grades.subject'])
            ->whereHas('grades')
            ->orderBy('nama')
            ->get();

        // Format untuk JavaScript (Alpine.js)
        $dataSiswa = $students->map(function ($s) {
            $nilaiList = $s->grades->map(function ($g) {
                $tugas = $g->nilai_uh  ?? 0;
                $uts   = $g->nilai_uts ?? 0;
                $uas   = $g->nilai_uas ?? 0;
                $rata  = $g->nilai_akhir ?? round(($tugas + $uts + $uas) / 3);
                return [
                    'mapel' => $g->subject->nama ?? '-',
                    'tugas' => $tugas,
                    'uts'   => $uts,
                    'uas'   => $uas,
                    'rata'  => $rata,
                ];
            })->values()->toArray();

            return [
                'nama'  => $s->nama,
                'nisn'  => $s->nisn ?? '-',
                'kelas' => $s->schoolClass ? ($s->schoolClass->tingkat . ' ' . $s->schoolClass->nama_kelas) : '-',
                'nilai' => $nilaiList,
            ];
        })->values();

        return view('admin.akademik.rapor', compact('kelasList', 'dataSiswa'));
    }
}
