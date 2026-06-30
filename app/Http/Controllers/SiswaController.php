<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Event;
use App\Models\Grade;

use App\Models\LearningMaterial;

class SiswaController extends Controller
{
    // Mock user session fetching
    private function getStudent() {
        return Auth::user()->student ?? Student::first(); 
    }

    public function index()
    {
        $student = $this->getStudent();
        $user = Auth::user();
        
        // Student info for display
        $class = \App\Models\SchoolClass::find($student->school_class_id);
        $namaKelas = $class ? $class->tingkat . ' ' . $class->nama_kelas : ($student->kelas ?? '-');
        $studentInfo = [
            'nama' => $student->nama ?? $user->name,
            'kelas' => $namaKelas,
            'nis' => $student->nis ?? '-',
            'foto' => $student->foto ? asset('storage/'.$student->foto) : 'https://ui-avatars.com/api/?name='.urlencode($student->nama ?? $user->name).'&background=0D8ABC&color=fff',
        ];

        // Today's schedule
        $hariIni = now()->locale('id')->isoFormat('dddd');
        
        $jadwal_hari_ini = Schedule::where('school_class_id', $student->school_class_id)
            ->where('hari', $hariIni)
            ->with('subject.teacher')
            ->orderBy('jam_mulai')
            ->get()->map(function($j) {
                return ['jam' => $j->jam_mulai . ' - ' . $j->jam_selesai, 'mapel' => $j->subject->nama_pelajaran ?? $j->subject->nama ?? 'Unknown', 'guru' => $j->subject->teacher->nama ?? '-'];
            });

        // Attendance stats
        $hadirCount = Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count();
        $sakitCount = Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count();
        $izinCount  = Attendance::where('student_id', $student->id)->where('status', 'Izin')->count();
        $alphaCount = Attendance::where('student_id', $student->id)->where('status', 'Alpha')->count();
        
        $totalAbsen = $hadirCount + $sakitCount + $izinCount + $alphaCount;
        $persenHadir = $totalAbsen > 0 ? round(($hadirCount / $totalAbsen) * 100) : 0;
        $persenIzin = $totalAbsen > 0 ? round(($izinCount / $totalAbsen) * 100) : 0;
        $persenSakit = $totalAbsen > 0 ? round(($sakitCount / $totalAbsen) * 100) : 0;
        $persenAlpha = $totalAbsen > 0 ? round(($alphaCount / $totalAbsen) * 100) : 0;

        $kehadiran = [
            'hadir' => $persenHadir,
            'sakit' => $sakitCount,
            'izin'  => $izinCount,
            'alpha' => $alphaCount,
            'persen_izin' => $persenIzin,
            'persen_sakit' => $persenSakit,
            'persen_alpha' => $persenAlpha,
            'total' => $totalAbsen,
        ];

        // Active assignments (only those not yet submitted by this student)
        $allAssignments = Assignment::where('school_class_id', $student->school_class_id)
            ->with('subject')
            ->get();
        
        $tugas_aktif = $allAssignments->map(function($t) use($student) {
                $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
                return [
                    'id' => $t->id,
                    'mapel' => $t->subject->nama_pelajaran ?? $t->subject->nama ?? 'Unknown',
                    'judul' => $t->judul,
                    'deadline' => $t->deadline,
                    'status' => $sa ? $sa->status : 'Belum'
                ];
            });
        
        // Count only unfinished assignments
        $tugasBelum = $tugas_aktif->filter(function($t) {
            return $t['status'] === 'Belum' || $t['status'] === 'Proses';
        })->count();

        // Announcements - get all count and latest 3
        $totalPengumuman = Event::where('tipe_info', 'Pengumuman')->count();
        $pengumuman = Event::where('tipe_info', 'Pengumuman')->latest()->take(3)->get()->map(function($e) {
            return [
                'judul' => $e->judul, 
                'tanggal' => $e->tanggal_pelaksanaan, 
                'isi' => $e->deskripsi ? substr($e->deskripsi, 0, 80) . (strlen($e->deskripsi) > 80 ? '...' : '') : 'Tidak ada deskripsi.',
                'waktu_lalu' => $e->created_at ? $e->created_at->diffForHumans() : '-',
            ];
        });

        // Nilai rata-rata for quick stat
        $nilaiList = Grade::where('student_id', $student->id)->get();
        $nilaiAkhirList = $nilaiList->map(function($g) {
            $scores = array_filter([$g->nilai_uh, $g->nilai_uts, $g->nilai_uas], function($v) { return $v !== null; });
            return count($scores) > 0 ? round(array_sum($scores) / count($scores)) : null;
        })->filter();
        $rataRataNilai = $nilaiAkhirList->count() > 0 ? round($nilaiAkhirList->avg(), 1) : 0;

        // Upcoming events (non-pengumuman)
        $upcomingEvents = Event::whereIn('tipe_info', ['Event', 'Agenda'])
            ->where('tanggal_pelaksanaan', '>=', now()->toDateString())
            ->orderBy('tanggal_pelaksanaan')
            ->take(3)
            ->get();

        return view('siswa.dashboard.index', compact(
            'studentInfo', 'jadwal_hari_ini', 'kehadiran', 'tugas_aktif', 'tugasBelum',
            'pengumuman', 'totalPengumuman', 'rataRataNilai', 'upcomingEvents'
        ));
    }

    public function akademikJadwal()
    {
        $student = $this->getStudent();
        $schedules = Schedule::where('school_class_id', $student->school_class_id)->with('subject.teacher')->get();
        $jadwal = [];
        foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari) {
            $jadwal[$hari] = $schedules->where('hari', $hari)->map(function($j){
                return ['jam' => $j->jam_mulai . ' - ' . $j->jam_selesai, 'mapel' => $j->subject->nama_pelajaran ?? $j->subject->nama ?? 'Unknown', 'guru' => $j->subject->teacher->nama ?? '-'];
            })->values()->toArray();
        }
        return view('siswa.akademik.jadwal', compact('jadwal'));
    }

    public function akademikTugas()
    {
        $student = $this->getStudent();
        
        $tugas = Assignment::where('school_class_id', $student->school_class_id)->with('subject')->get()->map(function($t) use($student) {
                $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
                return [
                    'mapel' => $t->subject->nama_pelajaran ?? $t->subject->nama ?? 'Unknown',
                    'judul' => $t->judul,
                    'deadline' => $t->deadline,
                    'status' => $sa ? $sa->status : 'Belum',
                    'deskripsi' => $t->deskripsi
                ];
            });
        return view('siswa.akademik.tugas', compact('tugas'));
    }

    public function akademikNilai()
    {
        $student = $this->getStudent();
        $nilai = Grade::where('student_id', $student->id)->with('subject')->get()->map(function($g){
            // Calculate nilai_akhir dynamically from UH+UTS+UAS
            $scores = array_filter([$g->nilai_uh, $g->nilai_uts, $g->nilai_uas], function($v) { return $v !== null; });
            $akhir = count($scores) > 0 ? round(array_sum($scores) / count($scores)) : null;
            return [
                'mapel' => $g->subject->nama ?? 'Unknown',
                'uh' => $g->nilai_uh,
                'uts' => $g->nilai_uts,
                'uas' => $g->nilai_uas,
                'akhir' => $akhir
            ];
        });

        // Dynamic summary cards
        $nilaiAkhirList = $nilai->pluck('akhir')->filter()->values();
        $rataRata = $nilaiAkhirList->count() > 0 ? round($nilaiAkhirList->avg(), 1) : 0;
        $totalMapel = $nilai->count();

        // Calculate class ranking based on average grades
        $peringkat = '-';
        $totalSiswaKelas = 0;
        if ($student->school_class_id) {
            $classmates = Student::where('school_class_id', $student->school_class_id)->get();
            $totalSiswaKelas = $classmates->count();
            
            $rankings = [];
            foreach ($classmates as $cm) {
                $cmGrades = Grade::where('student_id', $cm->id)->get();
                $cmScores = $cmGrades->map(function($g) {
                    $s = array_filter([$g->nilai_uh, $g->nilai_uts, $g->nilai_uas], function($v) { return $v !== null; });
                    return count($s) > 0 ? array_sum($s) / count($s) : 0;
                });
                $rankings[$cm->id] = $cmScores->count() > 0 ? $cmScores->avg() : 0;
            }
            arsort($rankings);
            $rank = 1;
            foreach ($rankings as $studentId => $avg) {
                if ($studentId == $student->id) {
                    $peringkat = $rank;
                    break;
                }
                $rank++;
            }
        }

        // Determine trend
        $trend = $rataRata >= 75 ? 'Meningkat' : ($rataRata > 0 ? 'Perlu Ditingkatkan' : 'Belum Ada Data');

        return view('siswa.akademik.nilai', compact('nilai', 'rataRata', 'totalMapel', 'peringkat', 'totalSiswaKelas', 'trend'));
    }

    public function kehadiranRiwayat()
    {
        $student = $this->getStudent();
        $riwayat = Attendance::where('student_id', $student->id)->orderByDesc('tanggal')->get();
        return view('siswa.kehadiran.riwayat', compact('riwayat'));
    }

    public function kehadiranIzin()
    {
        $student = $this->getStudent();
        
        $riwayat_izin = Attendance::where('student_id', $student->id)
            ->whereIn('status', ['Izin', 'Sakit'])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function($a) {
                return [
                    'tanggal_pengajuan' => date('d M Y', strtotime($a->created_at ?? $a->tanggal)),
                    'kategori' => $a->status,
                    'mulai_tanggal' => date('d M Y', strtotime($a->tanggal)),
                    'sampai_tanggal' => date('d M Y', strtotime($a->tanggal)),
                    'keterangan' => $a->keterangan ?? '-',
                    'bukti' => '-',
                    'status' => 'Disetujui',
                ];
            });
            
        return view('siswa.kehadiran.izin', compact('riwayat_izin'));
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Izin,Sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ]);

        $student = $this->getStudent();

        $mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
        $selesai = \Carbon\Carbon::parse($request->tanggal_selesai);
        $diffDays = $mulai->diffInDays($selesai);
        
        for ($i = 0; $i <= $diffDays; $i++) {
            $tgl = $mulai->copy()->addDays($i)->format('Y-m-d');
            \App\Models\Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal' => $tgl,
                ],
                [
                    'status' => $request->jenis,
                    'keterangan' => $request->keterangan,
                ]
            );
        }

        return redirect()->back()->with('success', 'Pengajuan izin/sakit berhasil dikirim.');
    }

    public function kehadiranRekap()
    {
        $student = $this->getStudent();
        
        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('tanggal', 'desc')
            ->get();
            
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $grouped = $attendances->groupBy(function($item) {
            return substr($item->tanggal, 0, 7); // Format: YYYY-MM
        });
        
        $rekap = [];
        foreach ($grouped as $key => $items) {
            $parts = explode('-', $key);
            if (count($parts) < 2) continue;
            
            $year = $parts[0];
            $monthNum = $parts[1];
            $monthName = ($months[$monthNum] ?? 'Bulan') . ' ' . $year;
            
            $hadir = $items->where('status', 'Hadir')->count();
            $sakit = $items->where('status', 'Sakit')->count();
            $izin = $items->where('status', 'Izin')->count();
            $alpha = $items->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
            $terlambat = $items->where('status', 'Terlambat')->count();
            
            $rekap[] = [
                'bulan' => $monthName,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpha' => $alpha,
                'terlambat' => $terlambat
            ];
        }
        
        if (empty($rekap)) {
            $rekap[] = [
                'bulan' => 'Oktober ' . date('Y'),
                'hadir' => 0,
                'sakit' => 0,
                'izin' => 0,
                'alpha' => 0,
                'terlambat' => 0
            ];
        }
        
        return view('siswa.kehadiran.rekap', compact('rekap'));
    }

    public function kegiatanEvent()
    {
        $events = Event::where('tipe_info', 'Event')->get();
        return view('siswa.kegiatan.event', compact('events'));
    }

    public function kegiatanAgenda()
    {
        $agenda = Event::where('tipe_info', 'Agenda')->get()->map(function($e){
            return ['tanggal' => $e->tanggal_pelaksanaan, 'kegiatan' => $e->judul, 'waktu' => $e->waktu_pelaksanaan, 'tempat' => $e->lokasi];
        });
        return view('siswa.kegiatan.agenda', compact('agenda'));
    }

    public function kegiatanDokumentasi()
    {
        $dokumentasi = Event::where('tipe_info', 'Dokumentasi')->get();
        return view('siswa.kegiatan.dokumentasi', compact('dokumentasi'));
    }

    public function pembelajaranMateri()
    {
        $student = $this->getStudent();
        $classId = $student->school_class_id;

        $materi = LearningMaterial::where('school_class_id', $classId)
            ->with(['subject.teacher'])
            ->latest()
            ->get()
            ->map(function($m){
                return [
                    'mapel' => $m->subject->nama ?? 'Umum',
                    'judul' => $m->judul,
                    'guru' => $m->subject->teacher->nama ?? 'Guru',
                    'tanggal' => $m->tanggal_upload ?? $m->created_at->toDateString(),
                    'file' => $m->file_path,
                    'ukuran' => $m->ukuran_file ?? '0 MB'
                ];
            });
        return view('siswa.pembelajaran.materi', compact('materi'));
    }

    public function pembelajaranTugas()
    {
        $student = $this->getStudent();
        $classId = $student->school_class_id;

        $tugas_pending = Assignment::where('school_class_id', $classId)
            ->with(['subject.teacher'])
            ->whereDoesntHave('studentAssignments', function($q) use($student) {
                $q->where('student_id', $student->id);
            })->latest()->get();
            
        return view('siswa.pembelajaran.tugas', compact('tugas_pending'));
    }

    public function submitTugas(Request $request, $id)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB limit
            ]);

            $student = $this->getStudent();
            if (!$student) {
                return redirect()->back()->withErrors(['error' => 'Data siswa tidak ditemukan.']);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Ensure directory exists
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('kbm/jawaban')) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('kbm/jawaban');
            }

            $filePath = $file->storeAs('kbm/jawaban', $fileName, 'public');

            StudentAssignment::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'assignment_id' => $id,
                ],
                [
                    'tanggal_kumpul' => now()->toDateTimeString(),
                    'file_jawaban' => $filePath,
                    'status' => 'Terkumpul'
                ]
            );

            return redirect()->back()->with('success', 'Jawaban berhasil diunggah!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengunggah: ' . $e->getMessage()]);
        }
    }

    public function pembelajaranNilai()
    {
        $student = $this->getStudent();

        // 1. Nilai dari tugas yang sudah dikumpulkan (student_assignments)
        $nilai_tugas = StudentAssignment::where('student_id', $student->id)
            ->with('assignment.subject')
            ->get()
            ->map(function($sa) {
                return [
                    'tipe' => 'Tugas',
                    'mapel' => $sa->assignment->subject->nama ?? 'Unknown',
                    'judul' => $sa->assignment->judul ?? '-',
                    'tanggal_kumpul' => $sa->tanggal_kumpul,
                    'nilai' => $sa->nilai,
                    'feedback' => $sa->feedback,
                    'status' => $sa->nilai !== null ? 'Dinilai' : ($sa->status ?? 'Terkumpul')
                ];
            });

        // 2. Nilai periodik dari guru (grades table: UH/UTS/UAS)
        $nilai_periodik = Grade::where('student_id', $student->id)
            ->with('subject')
            ->get()
            ->flatMap(function($g) {
                $items = collect();
                if ($g->nilai_uh !== null) {
                    $items->push([
                        'tipe' => 'Ulangan Harian',
                        'mapel' => $g->subject->nama ?? 'Unknown',
                        'judul' => 'Ulangan Harian',
                        'tanggal_kumpul' => $g->updated_at,
                        'nilai' => $g->nilai_uh,
                        'feedback' => null,
                        'status' => 'Dinilai'
                    ]);
                }
                if ($g->nilai_uts !== null) {
                    $items->push([
                        'tipe' => 'UTS',
                        'mapel' => $g->subject->nama ?? 'Unknown',
                        'judul' => 'Ujian Tengah Semester',
                        'tanggal_kumpul' => $g->updated_at,
                        'nilai' => $g->nilai_uts,
                        'feedback' => null,
                        'status' => 'Dinilai'
                    ]);
                }
                if ($g->nilai_uas !== null) {
                    $items->push([
                        'tipe' => 'UAS',
                        'mapel' => $g->subject->nama ?? 'Unknown',
                        'judul' => 'Ujian Akhir Semester',
                        'tanggal_kumpul' => $g->updated_at,
                        'nilai' => $g->nilai_uas,
                        'feedback' => null,
                        'status' => 'Dinilai'
                    ]);
                }
                return $items;
            });

        // Merge both collections
        $semua_nilai = $nilai_tugas->concat($nilai_periodik);

        return view('siswa.pembelajaran.nilai', compact('semua_nilai'));
    }

    // Methods removed as Perpustakaan feature was deleted.

    public function profilBiodata()
    {
        $student = $this->getStudent();
        $class = \App\Models\SchoolClass::find($student->school_class_id);
        $namaKelas = $class ? $class->tingkat . ' ' . $class->nama_kelas : $student->kelas;
        
        $siswa = [
            'nama' => $student->nama,
            'nis' => $student->nis,
            'nisn' => $student->nisn ?? '-',
            'tempat_lahir' => $student->tempat_lahir ?? '-',
            'tanggal_lahir' => $student->tanggal_lahir ?? '-',
            'jenis_kelamin' => $student->jenis_kelamin ?? '-',
            'agama' => $student->agama ?? '-',
            'alamat' => $student->alamat ?? '-',
            'telepon' => $student->telepon ?? '-',
            'email' => $student->email ?? '-',
            'kelas' => $namaKelas,
            'foto' => $student->foto ? asset('storage/'.$student->foto) : 'https://ui-avatars.com/api/?name='.urlencode($student->nama).'&background=0D8ABC&color=fff',
        ];
        return view('siswa.profil.biodata', compact('siswa'));
    }

    public function profilOrangtua()
    {
        $student = $this->getStudent();
        $p = $student->parentProfile; // need to ensure relationship exisits
        $orangtua = [
            'ayah' => ['nama' => $p->nama_ayah ?? '-', 'pekerjaan' => $p->pekerjaan_ayah ?? '-', 'telepon' => $p->telepon_ayah ?? '-', 'alamat' => $p->alamat ?? '-'],
            'ibu' => ['nama' => $p->nama_ibu ?? '-', 'pekerjaan' => $p->pekerjaan_ibu ?? '-', 'telepon' => $p->telepon_ibu ?? '-', 'alamat' => $p->alamat ?? '-'],
            'wali' => ['nama' => '-', 'pekerjaan' => '-', 'telepon' => '-', 'alamat' => '-']
        ];
        return view('siswa.profil.orangtua', compact('orangtua'));
    }

    public function profilPassword()
    {
        return view('siswa.profil.password');
    }
}
