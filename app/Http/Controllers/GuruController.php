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
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // Mock user session fetching for Guru
    private function getTeacher() {
        return Teacher::first(); 
    }

    public function dashboard()
    {
        $teacher = $this->getTeacher();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        // Fetch schedules for the teacher's subjects
        $jadwal_mengajar = Schedule::whereIn('subject_id', $subjects->pluck('id'))
            ->with('subject')
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.dashboard.index', compact('jadwal_mengajar'));
    }

    public function kelasSiswa(Request $request)
    {
        $teacher = $this->getTeacher();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        $selectedClassId = $request->input('class_id', $classes->first()->id ?? null);
        
        $students = \App\Models\Student::query()
            ->when($selectedClassId, function($q) use($selectedClassId) {
                return $q->where('school_class_id', $selectedClassId);
            })
            ->when($request->search, function($q) use($request) {
                return $q->where('nama', 'like', '%'.$request->search.'%');
            })
            ->get();

        $selectedClass = SchoolClass::find($selectedClassId);

        return view('guru.akademik.kelas-siswa', compact('students', 'classes', 'selectedClassId', 'selectedClass'));
    }

    public function updateStudentNote(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $student->update(['catatan_guru' => $request->catatan_guru]);
        return redirect()->back()->with('success', 'Catatan guru berhasil diperbarui');
    }

    // --- Student CRUD ---
    public function storeStudent(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis',
            'school_class_id' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $data = $request->all();
        $class = SchoolClass::find($request->school_class_id);
        $data['kelas'] = $class ? ($class->tingkat . ' ' . $class->nama_kelas) : '';

        Student::create($data);

        return redirect()->back()->with('success', 'Siswa baru berhasil ditambahkan!');
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis,' . $id,
            'school_class_id' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $data = $request->all();
        $class = SchoolClass::find($request->school_class_id);
        $data['kelas'] = $class ? ($class->tingkat . ' ' . $class->nama_kelas) : '';

        $student->update($data);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroyStudent($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari database!');
    }

    // --- Class CRUD ---
    public function storeClass(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required',
        ]);

        $teacher = $this->getTeacher();

        SchoolClass::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'teacher_id' => $teacher->id // Default to current teacher as Wali Kelas
        ]);

        return redirect()->back()->with('success', 'Kelas baru berhasil dibuat!');
    }

    public function updateClass(Request $request, $id)
    {
        $class = SchoolClass::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required',
        ]);

        $class->update($request->all());

        return redirect()->back()->with('success', 'Informasi kelas berhasil diperbarui!');
    }

    public function destroyClass($id)
    {
        SchoolClass::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
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

    public function storeMataPelajaran(Request $request)
    {
        $teacher = $this->getTeacher();
        $validated = $request->validate([
            'kode' => 'required|unique:subjects,kode',
            'nama' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'jumlah_jam' => 'required|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $validated['teacher_id'] = $teacher->id;

        Subject::create($validated);
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function updateMataPelajaran(Request $request, $id)
    {
        $teacher = $this->getTeacher();
        $subject = Subject::where('teacher_id', $teacher->id)->findOrFail($id);
        
        $validated = $request->validate([
            'kode' => 'required|unique:subjects,kode,' . $id,
            'nama' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'jumlah_jam' => 'required|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $subject->update($validated);
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    public function destroyMataPelajaran($id)
    {
        $teacher = $this->getTeacher();
        Subject::where('teacher_id', $teacher->id)->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil dihapus!');
    }

    // --- Jadwal Mengajar ---
    public function jadwalMengajar()
    {
        $teacher = $this->getTeacher();
        $schedules = Schedule::with(['subject'])
            ->whereHas('subject', function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->map(function($s) {
                return [
                    'id' => $s->id,
                    'hari' => $s->hari,
                    'timeStart' => \Carbon\Carbon::parse($s->jam_mulai)->format('H:i'),
                    'timeEnd' => \Carbon\Carbon::parse($s->jam_selesai)->format('H:i'),
                    'subject' => $s->subject->nama,
                    'class' => $s->kelas,
                    'room' => 'R.' . ($s->id + 100),
                ];
            });

        return view('guru.akademik.jadwal-mengajar', compact('schedules'));
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

        $students = [];
        if ($selectedClassId) {
            $students = Student::where('school_class_id', $selectedClassId)
                ->with(['grades'])
                ->get()
                ->map(function($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->nama,
                        'nis' => $s->nis,
                        'score' => $s->grades->avg('score') ?? 0,
                    ];
                });
            
            // Sort by score for ranking
            $students = $students->sortByDesc('score');
        }

        return view('guru.akademik.rekap-nilai', compact('students', 'classes', 'selectedClassId'));
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
    public function absensiPertemuan()
    {
        $teacher = $this->getTeacher();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        // For attendance, we need class data. 
        // We'll use the dynamic list I implemented earlier.
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        // Fetch recent reports for this teacher
        $reports = TeachingReport::where('teacher_id', $teacher->id)
            ->with(['schoolClass', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        return view('guru.absensi.absensi-pertemuan', compact('subjects', 'classes', 'reports'));
    }

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

                if (strpos($selectedType, 'assignment_') === 0) {
                    // Logic for specific assignment
                    $assignmentId = str_replace('assignment_', '', $selectedType);
                    $sa = StudentAssignment::where('student_id', $student->id)
                        ->where('assignment_id', $assignmentId)
                        ->first();
                    $score = $sa ? $sa->nilai : null;
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
                    'score' => $score
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
                StudentAssignment::updateOrCreate(
                    ['student_id' => $studentId, 'assignment_id' => $assignmentId],
                    [
                        'nilai' => $finalScore, 
                        'status' => ($finalScore !== null ? 'Dinilai' : 'Belum'),
                        'tanggal_kumpul' => $finalScore !== null ? now()->toDateString() : null
                    ]
                );
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
}
