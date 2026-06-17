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
        
        $hariIni = now()->locale('id')->isoFormat('dddd');
        
        $jadwal_hari_ini = Schedule::where('school_class_id', $student->school_class_id)
            ->where('hari', $hariIni)
            ->with('subject.teacher')
            ->get()->map(function($j) {
                return ['jam' => $j->jam_mulai . ' - ' . $j->jam_selesai, 'mapel' => $j->subject->nama_pelajaran ?? $j->subject->nama ?? 'Unknown', 'guru' => $j->subject->teacher->nama ?? '-'];
            });

        $hadirCount = Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count();
        $sakitCount = Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count();
        $izinCount  = Attendance::where('student_id', $student->id)->where('status', 'Izin')->count();
        $alphaCount = Attendance::where('student_id', $student->id)->where('status', 'Alpha')->count();
        
        $totalAbsen = $hadirCount + $sakitCount + $izinCount + $alphaCount;
        $persenHadir = $totalAbsen > 0 ? round(($hadirCount / $totalAbsen) * 100) : 0;

        $kehadiran = [
            'hadir' => $persenHadir,
            'sakit' => $sakitCount,
            'izin'  => $izinCount,
            'alpha' => $alphaCount,
        ];

        $tugas_aktif = Assignment::where('school_class_id', $student->school_class_id)
            ->with('subject')
            ->get()->map(function($t) use($student) {
                $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
                return [
                    'mapel' => $t->subject->nama_pelajaran ?? $t->subject->nama ?? 'Unknown',
                    'judul' => $t->judul,
                    'deadline' => $t->deadline,
                    'status' => $sa ? $sa->status : 'Belum'
                ];
            });

        $pengumuman = Event::where('tipe_info', 'Pengumuman')->latest()->take(2)->get()->map(function($e) {
            return ['judul' => $e->judul, 'tanggal' => $e->tanggal_pelaksanaan, 'isi' => substr($e->deskripsi, 0, 50) . '...'];
        });

        return view('siswa.dashboard.index', compact('jadwal_hari_ini', 'kehadiran', 'tugas_aktif', 'pengumuman'));
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
            return [
                'mapel' => $g->subject->nama,
                'uh' => $g->nilai_uh,
                'uts' => $g->nilai_uts,
                'uas' => $g->nilai_uas,
                'akhir' => $g->nilai_akhir
            ];
        });
        return view('siswa.akademik.nilai', compact('nilai'));
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
        $nilai_tugas = StudentAssignment::where('student_id', $student->id)->with('assignment.subject')->get()->map(function($sa) {
            return [
                'mapel' => $sa->assignment->subject->nama,
                'judul' => $sa->assignment->judul,
                'tanggal_kumpul' => $sa->tanggal_kumpul,
                'nilai' => $sa->nilai,
                'feedback' => $sa->feedback,
                'status' => 'Dinilai'
            ];
        });
        return view('siswa.pembelajaran.nilai', compact('nilai_tugas'));
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
