<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\TeachingReport;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // Mock user session fetching for Guru
    private function getTeacher() {
        return Auth::user()->teacher ?? Teacher::first(); // Fallback to first if not linked yet for testing
    }

    public function dashboard()
    {
        $teacher = $this->getTeacher();
        
        // 1. Total Mata Pelajaran yang diampu
        $totalMapel = Subject::where('teacher_id', $teacher->id)->count();

        // 2. Total Kelas & Total Siswa
        $classIds = Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('school_class_id')->unique()->filter();
        
        $totalKelas = $classIds->count();
        $totalSiswa = Student::whereIn('school_class_id', $classIds)->count();

        // 3. Jadwal Hari Ini
        $hariIni = now()->locale('id')->isoFormat('dddd');
        
        $jadwalHariIni = Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->where('hari', $hariIni)
        ->with(['subject', 'schoolClass'])
        ->orderBy('jam_mulai')
        ->get();

        $totalSesiHariIni = $jadwalHariIni->count();

        // - Rata-rata Nilai (Grade / Rapor Akhir)
        $averageGrade = \App\Models\Grade::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->avg('nilai_akhir');
        $averageGrade = round($averageGrade ?? 0, 1);

        // - Tren Kehadiran & Chart (7 Hari Terakhir)
        $studentsAjarIds = \App\Models\Student::whereIn('school_class_id', $classIds)->pluck('id');
        
        $chartLabels = [];
        $chartData = [];
        $totalHadir7Hari = 0;
        $totalAbsen7Hari = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $label = \Carbon\Carbon::now()->subDays($i)->isoFormat('dddd');
            $chartLabels[] = $label;
            
            $hadirCount = \App\Models\Attendance::whereIn('student_id', $studentsAjarIds)
                ->where('tanggal', $date)
                ->where('status', 'Hadir')
                ->count();
                
            $totalCount = \App\Models\Attendance::whereIn('student_id', $studentsAjarIds)
                ->where('tanggal', $date)
                ->count();
                
            $persentase = $totalCount > 0 ? round(($hadirCount / $totalCount) * 100) : 0;
            $chartData[] = $persentase;
            
            $totalHadir7Hari += $hadirCount;
            $totalAbsen7Hari += $totalCount;
        }

        $attendancePercentage = $totalAbsen7Hari > 0 ? round(($totalHadir7Hari / $totalAbsen7Hari) * 100, 1) : 0;

        // 4. Aktivitas & Notifikasi
        $notifikasi = [];

        // - Tugas Menunggu Penilaian
        $tugasMenunggu = \App\Models\StudentAssignment::whereHas('assignment.subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->whereNull('nilai')
        ->with(['assignment.schoolClass', 'assignment.subject', 'student'])
        ->latest()
        ->take(3)
        ->get();

        foreach($tugasMenunggu as $tugas) {
            $notifikasi[] = [
                'type' => 'TGS',
                'color' => 'orange',
                'title' => 'Tugas Menunggu',
                'time' => $tugas->created_at->diffForHumans(),
                'desc' => 'Tugas "' . ($tugas->assignment->judul ?? '') . '" dari ' . ($tugas->student->nama ?? 'Siswa') . ' belum dinilai.',
                'action_text' => 'Nilai Sekarang',
                'action_url' => route('guru.materi-tugas.komentar-feedback')
            ];
        }

        // - Izin Siswa hari ini (Siswa yang diajar)
        $studentsAjarIds = Student::whereIn('school_class_id', $classIds)->pluck('id');
        $izinSiswa = \App\Models\Attendance::whereIn('student_id', $studentsAjarIds)
            ->whereIn('status', ['Izin', 'Sakit'])
            ->whereDate('tanggal', date('Y-m-d'))
            ->with(['student.schoolClass'])
            ->take(3)
            ->get();

        foreach($izinSiswa as $izin) {
            $notifikasi[] = [
                'type' => 'IZN',
                'color' => 'blue',
                'title' => 'Izin Siswa',
                'time' => $izin->created_at->format('H:i'),
                'desc' => '<span class="font-semibold text-gray-800">' . ($izin->student->nama ?? 'Unknown') . '</span> (' . ($izin->student->schoolClass->nama_kelas ?? '') . ') izin ' . strtolower($izin->status) . '.',
                'action_text' => 'Lihat Data',
                'action_url' => route('guru.absensi.izin-sakit-alpha')
            ];
        }

        // - Rapat / Pengumuman
        $pengumuman = \App\Models\Event::whereIn('tipe_info', ['Pengumuman', 'Agenda'])
            ->latest()
            ->take(2)
            ->get();

        foreach($pengumuman as $info) {
            $notifikasi[] = [
                'type' => 'INFO',
                'color' => 'purple',
                'title' => $info->judul,
                'time' => \Carbon\Carbon::parse($info->tanggal_pelaksanaan)->diffForHumans(),
                'desc' => \Illuminate\Support\Str::limit($info->deskripsi, 60),
                'action_text' => null,
                'action_url' => null
            ];
        }
        
        $notifikasi = collect($notifikasi)->take(5)->toArray();

        return view('guru.dashboard.index', compact(
            'totalMapel', 'totalKelas', 'totalSiswa', 'jadwalHariIni', 'totalSesiHariIni', 'hariIni', 
            'notifikasi', 'averageGrade', 'attendancePercentage', 'chartLabels', 'chartData'
        ));
    }

    public function kelasSiswa(Request $request)
    {
        $teacher = $this->getTeacher();
        
        // Dapatkan ID kelas dari jadwal mengajar guru ini
        $classIds = Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('school_class_id')->unique()->filter();

        // Hanya tampilkan kelas-kelas yang diajar oleh guru ini
        $classes = SchoolClass::whereIn('id', $classIds)->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        
        $students = collect();
        $selectedClass = null;
        
        if ($selectedClassId) {
            $students = \App\Models\Student::query()
                ->where('school_class_id', $selectedClassId)
                ->when($request->search, function($q) use($request) {
                    return $q->where('nama', 'like', '%'.$request->search.'%');
                })
                ->get();
            $selectedClass = SchoolClass::find($selectedClassId);
        }

        return view('guru.akademik.kelas-siswa', compact('students', 'classes', 'selectedClassId', 'selectedClass'));
    }

    public function updateStudentNote(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $student->update(['catatan_guru' => $request->catatan_guru]);
        return redirect()->back()->with('success', 'Catatan guru berhasil diperbarui');
    }

    // --- Mata Pelajaran ---
    public function mataPelajaran(Request $request)
    {
        $teacher = $this->getTeacher();
        $query = Subject::where('teacher_id', $teacher->id);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
            });
        }

        $mataPelajaran = $query->latest()->paginate(10);
        
        // Stats
        $totalAktif = Subject::where('teacher_id', $teacher->id)->where('status', 'Aktif')->count();
        $totalJam = Subject::where('teacher_id', $teacher->id)->sum('jumlah_jam');

        return view('guru.akademik.mata-pelajaran', compact('mataPelajaran', 'totalAktif', 'totalJam'));
    }

    // CRUD removed - Subjects are managed by Admin


    // --- Jadwal Mengajar ---
    public function jadwalMengajar()
    {
        $teacher = $this->getTeacher();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        $schedules = Schedule::with(['subject'])
            ->whereHas('subject', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->map(function($s) {
                // Try to resolve class_id from the 'kelas' string
                $classId = null;
                $kelasParts = explode('-', $s->kelas);
                if (count($kelasParts) == 2) {
                    $schoolClass = SchoolClass::where('tingkat', $kelasParts[0])
                        ->where('nama_kelas', $kelasParts[1])
                        ->first();
                    $classId = $schoolClass ? $schoolClass->id : null;
                } else {
                    $schoolClass = SchoolClass::where('nama_kelas', $s->kelas)->first();
                    $classId = $schoolClass ? $schoolClass->id : null;
                }

                return [
                    'id' => $s->id,
                    'hari' => $s->hari,
                    'jam_mulai' => $s->jam_mulai,
                    'jam_selesai' => $s->jam_selesai,
                    'timeStart' => \Carbon\Carbon::parse($s->jam_mulai)->format('H:i'),
                    'timeEnd' => \Carbon\Carbon::parse($s->jam_selesai)->format('H:i'),
                    'subject' => $s->subject->nama,
                    'subject_id' => $s->subject_id,
                    'kelas' => $s->kelas,
                    'class_id' => $classId,
                    'room' => 'R.' . ($s->id + 100),
                ];
            });

        return view('guru.akademik.jadwal-mengajar', compact('schedules', 'subjects', 'classes'));
    }

    public function storeSchedule(Request $request)
    {
        $teacher = $this->getTeacher();
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // Verify ownership
        Subject::where('id', $request->subject_id)->where('teacher_id', $teacher->id)->firstOrFail();

        Schedule::create($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateSchedule(Request $request, $id)
    {
        $teacher = $this->getTeacher();
        $schedule = Schedule::findOrFail($id);
        
        // Verify ownership
        Subject::where('id', $schedule->subject_id)->where('teacher_id', $teacher->id)->firstOrFail();

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // Verify new subject ownership too
        Subject::where('id', $request->subject_id)->where('teacher_id', $teacher->id)->firstOrFail();

        $schedule->update($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroySchedule($id)
    {
        $teacher = $this->getTeacher();
        $schedule = Schedule::findOrFail($id);
        
        // Verify ownership
        Subject::where('id', $schedule->subject_id)->where('teacher_id', $teacher->id)->firstOrFail();

        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }

    // --- Nilai Rapor ---
    public function inputNilaiRapor(Request $request)
    {
        $teacher = $this->getTeacher();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        $selectedSubjectId = $request->input('subject_id', $subjects->first()->id ?? null);

        $students = [];
        if ($selectedClassId) {
            $students = Student::where('school_class_id', $selectedClassId)
                ->with(['grades' => function($q) use ($selectedSubjectId) {
                    $q->where('subject_id', $selectedSubjectId)
                      ->where('type', 'Rapor');
                }])->get()
                ->map(function($s) {
                    $grade = $s->grades->first();
                    return [
                        'id' => $s->id,
                        'name' => $s->nama,
                        'nis' => $s->nis,
                        'score' => $grade ? $grade->score : 0,
                    ];
                });
        }

        return view('guru.akademik.input-nilai-rapor', compact('students', 'classes', 'subjects', 'selectedClassId', 'selectedSubjectId'));
    }

    public function storeNilaiRapor(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'grades' => 'required|array',
        ]);

        foreach ($request->grades as $studentId => $score) {
            Grade::updateOrCreate(
                [
                    'student_id' => $studentId, 
                    'subject_id' => $request->subject_id,
                    'type' => 'Rapor'
                ],
                ['score' => $score]
            );
        }

        return redirect()->back()->with('success', 'Nilai Rapor berhasil disimpan!');
    }

    // --- Rekap Nilai ---
    public function rekapNilai(Request $request)
    {
        $teacher = $this->getTeacher();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $selectedSubjectId = $request->input('subject_id', $subjects->first()->id ?? null);

        $students = [];
        if ($selectedClassId && $selectedSubjectId) {
            $students = Student::where('school_class_id', $selectedClassId)
                ->with(['grades' => function($q) use ($selectedSubjectId) {
                    $q->where('subject_id', $selectedSubjectId);
                }])
                ->get()
                ->map(function($s) {
                    $grades = $s->grades;
                    $periodicGrade = $grades->where('type', null)->first();
                    $raporGrade = $grades->where('type', 'Rapor')->first();
                    
                    $score = 0;
                    if ($raporGrade) {
                        $score = $raporGrade->score;
                    } elseif ($periodicGrade) {
                        $pScores = array_filter([$periodicGrade->nilai_uh, $periodicGrade->nilai_uts, $periodicGrade->nilai_uas]);
                        $score = count($pScores) > 0 ? array_sum($pScores) / count($pScores) : 0;
                    }

                    return [
                        'id' => $s->id,
                        'name' => $s->nama,
                        'nis' => $s->nis,
                        'score' => (float)$score,
                    ];
                });
            
            // Sort by score for ranking
            $students = $students->sortByDesc('score');
        }

        return view('guru.akademik.rekap-nilai', compact('students', 'classes', 'subjects', 'selectedClassId', 'selectedSubjectId'));
    }

    // ==========================================
    // MATERI (Learning Materials)
    // ==========================================
    public function materiIndex()
    {
        $teacher = $this->getTeacher();
        $materi = LearningMaterial::whereHas('subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with(['subject', 'schoolClass'])->latest()->get();

        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('guru.materi-tugas.materi', compact('materi', 'subjects', 'classes'));
    }

    public function uploadForm()
    {
        $teacher = $this->getTeacher();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $kelas = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('guru.materi-tugas.upload', compact('subjects', 'kelas'));
    }

    public function storeMateri(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'judul' => 'required|string',
            'file' => 'required|file|max:10240', // 10MB limit
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('kbm/materi', $fileName, 'public');
        
        $size = number_format($file->getSize() / 1048576, 2) . ' MB';

        LearningMaterial::create([
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'judul' => $request->judul,
            'file_path' => $filePath,
            'ukuran_file' => $size,
            'tanggal_upload' => now()->toDateString()
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diunggah!');
    }

    public function updateMateri(Request $request, $id)
    {
        $materi = LearningMaterial::findOrFail($id);

        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'judul' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $data = [
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'judul' => $request->judul,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('kbm/materi', $fileName, 'public');
            $data['ukuran_file'] = number_format($file->getSize() / 1048576, 2) . ' MB';
            $data['tanggal_upload'] = now()->toDateString();
        }

        $materi->update($data);

        return redirect()->back()->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyMateri($id)
    {
        $materi = LearningMaterial::findOrFail($id);
        
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }
        
        $materi->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus!');
    }

    // ==========================================
    // TUGAS (Assignments)
    // ==========================================
    public function tugasIndex()
    {
        $teacher = $this->getTeacher();
        $tugas = Assignment::whereHas('subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with(['subject', 'schoolClass', 'studentAssignments'])->latest()->get();

        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('guru.materi-tugas.tugas', compact('tugas', 'subjects', 'classes'));
    }

    public function storeTugas(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file|max:10240'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('kbm/tugas', $fileName, 'public');
        }

        Assignment::create([
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_path' => $filePath
        ]);

        return redirect()->back()->with('success', 'Tugas baru berhasil dibagikan!');
    }

    public function updateTugas(Request $request, $id)
    {
        $tugas = Assignment::findOrFail($id);

        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file|max:10240'
        ]);

        $data = [
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline
        ];

        if ($request->hasFile('file')) {
            if ($tugas->file_path && Storage::disk('public')->exists($tugas->file_path)) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('kbm/tugas', $fileName, 'public');
        }

        $tugas->update($data);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroyTugas($id)
    {
        $tugas = Assignment::findOrFail($id);
        
        // When deleting assignment, it cascades to student_assignments. Let's delete their files too.
        foreach(\App\Models\StudentAssignment::where('assignment_id', $id)->get() as $sa) {
            if ($sa->file_jawaban && Storage::disk('public')->exists($sa->file_jawaban)) {
                Storage::disk('public')->delete($sa->file_jawaban);
            }
        }

        $tugas->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }

    // ==========================================
    // PENILAIAN TUGAS (Grading)
    // ==========================================
    public function penilaianIndex()
    {
        $teacher = $this->getTeacher();
        
        $pengumpulan = StudentAssignment::whereHas('assignment.subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with(['student', 'assignment.subject'])->latest()->get();

        return view('guru.materi-tugas.penilaian-tugas', compact('pengumpulan'));
    }

    public function updateNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $studentAssignment = StudentAssignment::findOrFail($id);
        $studentAssignment->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
            'status' => 'Dinilai'
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }

    // ==========================================
    // ABSENSI & REPORTS
    // ==========================================


    public function reportsIndex()
    {
        $teacher = $this->getTeacher();
        $reports = TeachingReport::where('teacher_id', $teacher->id)
            ->with(['schoolClass', 'subject'])
            ->latest()
            ->get();
        
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('guru.absensi.reports.index', compact('reports', 'subjects', 'classes'));
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'tanggal' => 'required|date',
            'materi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $teacher = $this->getTeacher();

        TeachingReport::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Laporan pembelajaran berhasil disimpan!');
    }

    public function updateReport(Request $request, $id)
    {
        $report = TeachingReport::findOrFail($id);

        $request->validate([
            'subject_id' => 'required',
            'school_class_id' => 'required',
            'tanggal' => 'required|date',
            'materi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $report->update($request->all());

        return redirect()->back()->with('success', 'Laporan pembelajaran berhasil diperbarui!');
    }

    public function destroyReport($id)
    {
        TeachingReport::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Laporan pemberlajaran berhasil dihapus!');
    }

    // ==========================================
    // INPUT NILAI (Grades)
    // ==========================================
    public function inputNilaiTugas(Request $request)
    {
        $teacher = $this->getTeacher();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        $selectedSubjectId = $request->input('subject_id', $subjects->first()->id ?? null);
        
        // Fetch specific assignments for this subject and class
        $assignments = [];
        if ($selectedSubjectId && $selectedClassId) {
            $assignments = Assignment::where('subject_id', $selectedSubjectId)
                ->where('school_class_id', $selectedClassId)
                ->get();
        }

        $selectedType = $request->input('type', 'nilai_uh');

        $students = [];
        if ($selectedClassId && $selectedSubjectId) {
            $studentsData = Student::where('school_class_id', $selectedClassId)->get();
            
            foreach ($studentsData as $student) {
                $score = null;
                $status = 'Belum';
                $file = null;

                if (strpos($selectedType, 'assignment_') === 0) {
                    // Logic for specific assignment
                    $assignmentId = str_replace('assignment_', '', $selectedType);
                    $sa = StudentAssignment::where('student_id', $student->id)
                        ->where('assignment_id', $assignmentId)
                        ->first();
                    $score = $sa ? $sa->nilai : null;
                    $status = $sa ? $sa->status : 'Belum';
                    $file = $sa ? $sa->file_jawaban : null;
                } else {
                    // Logic for periodic grade (UH/UTS/UAS)
                    $grade = Grade::where('student_id', $student->id)
                        ->where('subject_id', $selectedSubjectId)
                        ->first();
                    $score = $grade ? $grade->{$selectedType} : null;
                }
                
                $students[] = [
                    'id' => $student->id,
                    'name' => $student->nama,
                    'nis' => $student->nis,
                    'score' => $score,
                    'status' => $status,
                    'file' => $file
                ];
            }
        }

        return view('guru.akademik.input-nilai-tugas', compact('students', 'classes', 'subjects', 'assignments', 'selectedClassId', 'selectedSubjectId', 'selectedType'));
    }

    public function storeNilaiTugas(Request $request)
    {
        $teacher = $this->getTeacher();
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|string',
            'grades' => 'required|array',
        ]);

        // Verify ownership
        $subject = Subject::where('id', $request->subject_id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $type = $request->type;

        foreach ($request->grades as $studentId => $score) {
            $finalScore = ($score !== '' && $score !== null) ? $score : null;

            if (strpos($type, 'assignment_') === 0) {
                // Save to StudentAssignment (Specific Tasks)
                $assignmentId = str_replace('assignment_', '', $type);
                $sa = StudentAssignment::where('student_id', $studentId)->where('assignment_id', $assignmentId)->first();
                
                if ($sa) {
                    // Update existing submission
                    $sa->nilai = $finalScore;
                    if ($finalScore !== null) {
                        $sa->status = 'Dinilai';
                    }
                    $sa->save();
                } else {
                    // Create if grading a student who hasn't submitted anything yet
                    if ($finalScore !== null) {
                        StudentAssignment::create([
                            'student_id' => $studentId,
                            'assignment_id' => $assignmentId,
                            'nilai' => $finalScore,
                            'status' => 'Dinilai',
                        ]);
                    }
                }
            } else {
                // Save to Grade Table (Periodic: UH/UTS/UAS)
                Grade::updateOrCreate(
                    ['student_id' => $studentId, 'subject_id' => $subject->id],
                    [$type => $finalScore]
                );
            }
        }

        return redirect()->back()->with('success', 'Berhasil! Data nilai telah disimpan ke database.');
    }
    public function absensiPertemuan(Request $request)
    {
        $teacher = $this->getTeacher();
        
        // Get all schedules for this teacher
        $jadwalMengajar = Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with(['subject', 'schoolClass'])->get();

        $selectedScheduleId = $request->schedule_id;
        $selectedDate = $request->tanggal ?? now()->toDateString();
        $students = collect();
        $attendances = collect();

        if ($selectedScheduleId) {
            $schedule = Schedule::with('schoolClass')->findOrFail($selectedScheduleId);
            $students = Student::where('school_class_id', $schedule->school_class_id)->orderBy('nama')->get();
            
            // Get existing attendance for this schedule & date
            $attendances = \App\Models\Attendance::where('schedule_id', $selectedScheduleId)
                ->where('tanggal', $selectedDate)
                ->get()
                ->keyBy('student_id');
        }

        return view('guru.absensi.index', compact('jadwalMengajar', 'selectedScheduleId', 'selectedDate', 'students', 'attendances'));
    }

    public function storeAbsensi(Request $request)
    {
        $teacher = $this->getTeacher();
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'tanggal' => 'required|date',
            'status' => 'required|array',
        ]);

        $scheduleId = $request->schedule_id;
        $tanggal = $request->tanggal;
        $statuses = $request->status;

        // Verify ownership (optional but good for security)
        $schedule = Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->findOrFail($scheduleId);

        foreach ($statuses as $studentId => $status) {
            \App\Models\Attendance::updateOrCreate(
                [
                    'schedule_id' => $scheduleId,
                    'student_id' => $studentId,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data absensi kelas berhasil disimpan!');
    }
    public function absensiRekap(Request $request)
    {
        $teacher = $this->getTeacher();
        
        $classIds = \App\Models\Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('school_class_id')->unique()->filter();

        $classes = \App\Models\SchoolClass::whereIn('id', $classIds)->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $bulan = $request->input('bulan', date('Y-m'));
        
        $totalSiswa = 0;
        $statsHadir = 0;
        $statsSakit = 0;
        $statsIzin = 0;
        $statsAlpha = 0;
        $pctKehadiran = 0;
        $rekapHarian = [];
        $rekapBulanan = [];
        $individuSiswa = [];
        $donutData = [0, 0, 0, 0];
        $chartLabels = [];
        $chartData = [];

        if ($selectedClassId) {
            $students = \App\Models\Student::where('school_class_id', $selectedClassId)->get();
            $totalSiswa = $students->count();
            
            $attendancesToday = \App\Models\Attendance::whereIn('student_id', $students->pluck('id'))
                ->where('tanggal', $tanggal)->get();
                
            $statsHadir = $attendancesToday->where('status', 'Hadir')->count();
            $statsSakit = $attendancesToday->where('status', 'Sakit')->count();
            $statsIzin = $attendancesToday->where('status', 'Izin')->count();
            $statsAlpha = $attendancesToday->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
            
            $totalAbsenToday = $statsHadir + $statsSakit + $statsIzin + $statsAlpha;
            $pctKehadiran = $totalAbsenToday > 0 ? round(($statsHadir / $totalAbsenToday) * 100) : 0;
            $donutData = [$statsHadir, $statsSakit, $statsIzin, $statsAlpha];
            
            foreach ($students as $s) {
                $att = $attendancesToday->where('student_id', $s->id)->first();
                $rekapHarian[] = [
                    'nama' => $s->nama,
                    'kelas' => $s->schoolClass->nama_kelas ?? '-',
                    'status' => $att ? $att->status : 'Belum Absen',
                    'jam_masuk' => $att ? $att->created_at->format('H:i') : '-'
                ];
                
                $attBulan = \App\Models\Attendance::where('student_id', $s->id)
                    ->where('tanggal', 'like', $bulan . '-%')->get();
                    
                $bHadir = $attBulan->where('status', 'Hadir')->count();
                $bSakit = $attBulan->where('status', 'Sakit')->count();
                $bIzin = $attBulan->where('status', 'Izin')->count();
                $bAlpha = $attBulan->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
                $bTotal = $bHadir + $bSakit + $bIzin + $bAlpha;
                $bPct = $bTotal > 0 ? round(($bHadir / $bTotal) * 100) : 0;
                
                $rekapBulanan[] = [
                    'nama' => $s->nama,
                    'hadir' => $bHadir,
                    'sakit' => $bSakit,
                    'izin' => $bIzin,
                    'alpha' => $bAlpha,
                    'persen' => $bPct
                ];
                
                $riwayatAll = \App\Models\Attendance::where('student_id', $s->id)->orderBy('tanggal', 'desc')->take(10)->get();
                $iHadir = \App\Models\Attendance::where('student_id', $s->id)->where('status', 'Hadir')->count();
                $iSakit = \App\Models\Attendance::where('student_id', $s->id)->where('status', 'Sakit')->count();
                $iIzin = \App\Models\Attendance::where('student_id', $s->id)->where('status', 'Izin')->count();
                $iAlpha = \App\Models\Attendance::where('student_id', $s->id)->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
                $iTotal = $iHadir + $iSakit + $iIzin + $iAlpha;
                
                $individuSiswa[] = [
                    'nama' => $s->nama,
                    'kelas' => $s->schoolClass->nama_kelas ?? '-',
                    'nis' => $s->nis,
                    'hadir' => $iHadir,
                    'sakit' => $iSakit,
                    'izin' => $iIzin,
                    'alpha' => $iAlpha,
                    'persen' => $iTotal > 0 ? round(($iHadir / $iTotal) * 100) : 0,
                    'riwayat' => $riwayatAll->map(function($r) {
                        return [
                            'tanggal' => \Carbon\Carbon::parse($r->tanggal)->format('d M Y'),
                            'status' => $r->status
                        ];
                    })->toArray()
                ];
            }
            
            for ($i = 6; $i >= 0; $i--) {
                $d = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                $chartLabels[] = \Carbon\Carbon::parse($d)->format('d M');
                
                $dayAtt = \App\Models\Attendance::whereIn('student_id', $students->pluck('id'))->where('tanggal', $d)->get();
                $dH = $dayAtt->where('status', 'Hadir')->count();
                $dT = $dayAtt->count();
                $chartData[] = $dT > 0 ? round(($dH / $dT) * 100) : 0;
            }
        }

        return view('guru.absensi.rekap-absensi', compact(
            'classes', 'selectedClassId', 'tanggal', 'bulan', 
            'totalSiswa', 'statsHadir', 'statsSakit', 'statsIzin', 'statsAlpha', 'pctKehadiran',
            'rekapHarian', 'rekapBulanan', 'individuSiswa', 'donutData', 'chartLabels', 'chartData'
        ));
    }

    // ==========================================
    // IZIN / SAKIT / ALPHA
    // ==========================================
    public function absensiIzinSakitAlpha(Request $request)
    {
        $teacher = $this->getTeacher();

        // Ambil class_id dari jadwal mengajar guru ini
        $classIds = \App\Models\Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('school_class_id')->unique()->filter();

        $classes = \App\Models\SchoolClass::whereIn('id', $classIds)
            ->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // Ambil student_id dari kelas yang diajar
        $studentIds = \App\Models\Student::whereIn('school_class_id', $classIds)->pluck('id');

        // Query attendance dengan status Izin / Sakit / Alpha
        $query = \App\Models\Attendance::whereIn('student_id', $studentIds)
            ->whereIn('status', ['Izin', 'Sakit', 'Alpha', 'Tanpa Keterangan'])
            ->with(['student.schoolClass', 'schedule.subject']);

        // Filter kelas
        if ($request->filled('kelas')) {
            $filteredStudentIds = \App\Models\Student::where('school_class_id', $request->kelas)->pluck('id');
            $query->whereIn('student_id', $filteredStudentIds);
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter search nama
        if ($request->filled('search')) {
            $searchStudentIds = \App\Models\Student::where('nama', 'like', '%' . $request->search . '%')->pluck('id');
            $query->whereIn('student_id', $searchStudentIds);
        }

        $records = $query->orderBy('tanggal', 'desc')->get();

        // Stats
        $totalAll   = $records->count();
        $totalIzin  = $records->where('status', 'Izin')->count();
        $totalSakit = $records->where('status', 'Sakit')->count();
        $totalAlpha = $records->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();

        return view('guru.absensi.izin-sakit-alpha', compact(
            'records', 'classes', 'totalAll', 'totalIzin', 'totalSakit', 'totalAlpha'
        ));
    }

    // ==========================================
    // FEEDBACK & KOMENTAR
    // ==========================================
    public function feedbackIndex()
    {
        $teacher = $this->getTeacher();
        
        $feedbacks = \App\Models\StudentAssignment::whereHas('assignment.subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->whereNotNull('feedback')
        ->where('feedback', '!=', '')
        ->with(['student', 'assignment.subject', 'assignment.schoolClass'])
        ->latest('updated_at')
        ->get();

        $recentlyGraded = \App\Models\StudentAssignment::whereHas('assignment.subject', function($q) use($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->whereNotNull('nilai')
        ->with(['student', 'assignment.subject'])
        ->latest('updated_at')
        ->take(10)
        ->get();

        return view('guru.materi-tugas.komentar-feedback', compact('feedbacks', 'recentlyGraded'));
    }

    // ==========================================
    // KEGIATAN & INFORMASI
    // ==========================================
    public function kegiatanAgenda(Request $request)
    {
        $agenda = \App\Models\Event::where('tipe_info', 'Agenda')
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->get();
        return view('guru.kegiatan.agenda', compact('agenda'));
    }

    public function kegiatanEvent(Request $request)
    {
        $events = \App\Models\Event::where('tipe_info', 'Event')
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();
        return view('guru.kegiatan.event', compact('events'));
    }

    public function kegiatanPengumuman(Request $request)
    {
        $pengumuman = \App\Models\Event::where('tipe_info', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('guru.kegiatan.pengumuman', compact('pengumuman'));
    }

    // ==========================================
    // PROFIL GURU & ARSIP
    // ==========================================
    public function profilBiodata()
    {
        $teacher = $this->getTeacher();
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $subjects = \App\Models\Subject::where('teacher_id', $teacher->id)->get();
        $mapel = $subjects->pluck('nama')->unique()->implode(', ') ?: 'Belum Ada';
        
        $classes = \App\Models\Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('school_class_id')->unique()->filter();
        
        $classNames = \App\Models\SchoolClass::whereIn('id', $classes)->get()->map(function($c) {
            return $c->tingkat . ' ' . $c->nama_kelas;
        })->toArray();

        $waliKelas = \App\Models\SchoolClass::where('teacher_id', $teacher->id)->first();

        $guru = [
            'nama' => $teacher->nama,
            'nip' => $teacher->nip ?? '-',
            'nuptk' => $teacher->nuptk ?? '-',
            'status' => $teacher->status ?? 'Aktif',
            'jabatan' => $teacher->jabatan ?? 'Guru Mata Pelajaran',
            'golongan' => $teacher->golongan ?? '-',
            'pendidikan' => $teacher->pendidikan ?? '-',
            'mapel' => $mapel,
            'kelas_diampu' => $classNames,
            'wali_kelas' => $waliKelas ? $waliKelas->tingkat . ' ' . $waliKelas->nama_kelas : 'Bukan Wali Kelas',
            'tahun_masuk' => $teacher->created_at ? $teacher->created_at->format('Y') : date('Y'),
            
            // Pribadi
            'tempat_lahir' => $teacher->tempat_lahir ?? '-',
            'tanggal_lahir' => $teacher->tanggal_lahir ? \Carbon\Carbon::parse($teacher->tanggal_lahir)->translatedFormat('d F Y') : '-',
            'jenis_kelamin' => $teacher->jenis_kelamin ?? '-',
            'agama' => $teacher->agama ?? '-',
            'alamat' => $teacher->alamat ?? '-',
            
            // Kontak
            'email' => $user->email ?? '-',
            'telp' => $teacher->no_hp ?? '-'
        ];

        return view('guru.profil.biodata', compact('guru'));
    }

    public function profilRiwayat()
    {
        $teacher = $this->getTeacher();
        
        $schedules = \App\Models\Schedule::whereHas('subject', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with(['subject', 'schoolClass'])->get();

        $kelasArray = [];
        foreach($schedules as $s) {
            $namaKelas = $s->schoolClass ? $s->schoolClass->tingkat . ' ' . $s->schoolClass->nama_kelas : 'Unknown';
            $kelasArray[$namaKelas] = [
                'nama' => $namaKelas,
                'mapel' => $s->subject->nama ?? '-',
                'jam' => 2,
                'siswa' => $s->schoolClass ? \App\Models\Student::where('school_class_id', $s->schoolClass->id)->count() : 0,
                'wali' => $s->schoolClass && $s->schoolClass->teacher_id == $teacher->id
            ];
        }

        $riwayat = [
            [
                'tahun' => date('Y').'/'.(date('Y')+1),
                'semester' => 'Ganjil',
                'status' => 'Berjalan',
                'kelas' => array_values($kelasArray)
            ]
        ];

        return view('guru.profil.riwayat-mengajar', compact('riwayat'));
    }

    public function profilArsip()
    {
        $teacher = $this->getTeacher();
        $documents = \App\Models\TeacherDocument::where('teacher_id', $teacher->id)->get();
        
        $grouped = $documents->groupBy('kategori');
        $dokumen = [];
        
        $categories = [
            'Surat Keputusan' => ['icon' => 'file-text', 'color' => 'indigo'],
            'Sertifikat & Pelatihan' => ['icon' => 'award', 'color' => 'emerald'],
            'Ijazah & Transkrip' => ['icon' => 'graduation-cap', 'color' => 'blue'],
            'Dokumen Lainnya' => ['icon' => 'folder', 'color' => 'gray'],
        ];

        foreach($categories as $catName => $style) {
            $items = $grouped->get($catName, collect());
            $dokItems = [];
            foreach($items as $item) {
                $sizeMb = 'Unknown';
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($item->file_path)) {
                    $sizeMb = number_format(\Illuminate\Support\Facades\Storage::disk('public')->size($item->file_path) / 1048576, 2) . ' MB';
                }

                $dokItems[] = [
                    'id' => $item->id,
                    'nama' => $item->nama_dokumen,
                    'file' => basename($item->file_path),
                    'ukuran' => $sizeMb,
                    'tanggal' => $item->created_at->format('d/m/Y'),
                    'status' => 'Aktif',
                    'file_path' => asset('storage/' . $item->file_path)
                ];
            }
            if(count($dokItems) > 0 || $catName == 'Surat Keputusan') {
                $dokumen[] = [
                    'kategori' => $catName,
                    'icon' => $style['icon'],
                    'color' => $style['color'],
                    'items' => $dokItems
                ];
            }
        }

        return view('guru.profil.arsip-dokumen', compact('dokumen'));
    }

    public function storeArsip(Request $request)
    {
        $teacher = $this->getTeacher();
        $request->validate([
            'nama_dokumen' => 'required|string',
            'kategori' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('arsip_dokumen', $fileName, 'public');

        \App\Models\TeacherDocument::create([
            'teacher_id' => $teacher->id,
            'nama_dokumen' => $request->nama_dokumen,
            'kategori' => $request->kategori,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah');
    }

    public function destroyArsip($id)
    {
        $teacher = $this->getTeacher();
        $doc = \App\Models\TeacherDocument::where('teacher_id', $teacher->id)->findOrFail($id);
        
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($doc->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function profilPassword()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $lastChanged = $user->updated_at;
        return view('guru.profil.ganti-password', compact('lastChanged'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = clone \Illuminate\Support\Facades\Auth::user();
        $realUser = \App\Models\User::find($user->id);
        
        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $realUser->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        $realUser->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $realUser->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
