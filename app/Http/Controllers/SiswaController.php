<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Event;
use App\Models\Grade;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\LearningMaterial;

class SiswaController extends Controller
{
    // Mock user session fetching
    private function getStudent() {
        return Student::first(); 
    }

    public function index()
    {
        $student = $this->getStudent();
        
        $jadwal_hari_ini = Schedule::where('kelas', $student->kelas)
            ->where('hari', 'Senin') // mock for today
            ->with('subject.teacher')
            ->get()->map(function($j) {
                return ['jam' => $j->jam_mulai . ' - ' . $j->jam_selesai, 'mapel' => $j->subject->nama, 'guru' => $j->subject->teacher->nama ?? '-'];
            });

        $kehadiran = [
            'hadir' => Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count() * 10, // mock percentage 
            'sakit' => Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count(),
            'izin'  => Attendance::where('student_id', $student->id)->where('status', 'Izin')->count(),
            'alpha' => Attendance::where('student_id', $student->id)->where('status', 'Alpha')->count(),
        ];

        $tugas_aktif = Assignment::whereHas('subject', function($q) use($student) {
                $q->whereHas('schedules', fn($sq) => $sq->where('kelas', $student->kelas));
            })->get()->map(function($t) use($student) {
                $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
                return [
                    'mapel' => $t->subject->nama,
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
        $schedules = Schedule::where('kelas', $student->kelas)->with('subject.teacher')->get();
        $jadwal = [];
        foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari) {
            $jadwal[$hari] = $schedules->where('hari', $hari)->map(function($j){
                return ['jam' => $j->jam_mulai . ' - ' . $j->jam_selesai, 'mapel' => $j->subject->nama, 'guru' => $j->subject->teacher->nama ?? '-'];
            })->values()->toArray();
        }
        return view('siswa.akademik.jadwal', compact('jadwal'));
    }

    public function akademikTugas()
    {
        $student = $this->getStudent();
        $class = \App\Models\SchoolClass::where('nama_kelas', $student->kelas)->first();
        $classId = $class ? $class->id : 0;

        $tugas = Assignment::where('school_class_id', $classId)->get()->map(function($t) use($student) {
                $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
                return [
                    'mapel' => $t->subject->nama,
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
        $riwayat_izin = []; // Can be derived or separate table, mock for now
        return view('siswa.kehadiran.izin', compact('riwayat_izin'));
    }

    public function kehadiranRekap()
    {
        $rekap = [
            ['bulan' => 'Oktober', 'hadir' => 20, 'sakit' => 0, 'izin' => 1, 'alpha' => 0, 'terlambat' => 0],
        ];
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
        $class = \App\Models\SchoolClass::where('nama_kelas', $student->kelas)->first();
        $classId = $class ? $class->id : 0;

        $materi = LearningMaterial::where('school_class_id', $classId)->with('subject.teacher')->get()->map(function($m){
            return [
                'mapel' => $m->subject->nama,
                'judul' => $m->judul,
                'guru' => $m->subject->teacher->nama ?? '-',
                'tanggal' => $m->tanggal_upload,
                'file' => $m->file_path,
                'ukuran' => $m->ukuran_file
            ];
        });
        return view('siswa.pembelajaran.materi', compact('materi'));
    }

    public function pembelajaranTugas()
    {
        $student = $this->getStudent();
        $class = \App\Models\SchoolClass::where('nama_kelas', $student->kelas)->first();
        $classId = $class ? $class->id : 0;

        $tugas_pending = Assignment::where('school_class_id', $classId)
            ->whereDoesntHave('studentAssignments', function($q) use($student) {
                $q->where('student_id', $student->id);
            })->get();
            
        return view('siswa.pembelajaran.tugas', compact('tugas_pending'));
    }

    public function submitTugas(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB limit
        ]);

        $student = $this->getStudent();
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('kbm/jawaban', $fileName, 'public');

        StudentAssignment::create([
            'student_id' => $student->id,
            'assignment_id' => $id,
            'tanggal_kumpul' => now()->toDateTimeString(),
            'file_jawaban' => $filePath,
            'status' => 'Terkumpul'
        ]);

        return redirect()->back()->with('success', 'Jawaban berhasil diunggah!');
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

    public function perpustakaanKatalog()
    {
        $buku = Book::all();
        return view('siswa.perpustakaan.katalog', compact('buku'));
    }

    public function perpustakaanPinjam()
    {
        $buku_list = Book::pluck('judul')->toArray();
        return view('siswa.perpustakaan.pinjam', compact('buku_list'));
    }

    public function perpustakaanRiwayat()
    {
        $student = $this->getStudent();
        $riwayat_pinjam = BookLoan::where('student_id', $student->id)->with('book')->get()->map(function($b){
            return [
                'judul' => $b->book->judul,
                'tgl_pinjam' => $b->tanggal_pinjam,
                'tgl_kembali' => $b->tanggal_kembali,
                'status' => $b->status,
                'denda' => $b->denda
            ];
        });
        return view('siswa.perpustakaan.riwayat', compact('riwayat_pinjam'));
    }

    public function profilBiodata()
    {
        $student = $this->getStudent();
        $siswa = [
            'nama' => $student->nama,
            'nis' => $student->nis,
            'nisn' => '0012345678',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2006-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 10',
            'telepon' => '081234567890',
            'email' => 'siswa@goedu.com',
            'kelas' => $student->kelas,
            'foto' => 'https://ui-avatars.com/api/?name='.urlencode($student->nama).'&background=0D8ABC&color=fff',
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
