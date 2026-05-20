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

        return view('guru.dashboard.index', compact('totalMapel', 'totalKelas', 'totalSiswa', 'jadwalHariIni', 'totalSesiHariIni', 'hariIni'));
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
}
