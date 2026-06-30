<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ElearningSession;
use App\Models\ElearningQuestion;
use App\Models\ElearningStudentAnswer;
use App\Models\ElearningMaterial;
use App\Models\ElearningAssignment;
use App\Models\ElearningAssignmentSubmission;
use App\Models\ElearningDiscussion;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Student;

class ElearningGuruController extends Controller
{
    private function getTeacher()
    {
        return Auth::user()->teacher ?? Teacher::first();
    }

    // ─────────────────────────────────────────────
    // Daftar Pertemuan
    // ─────────────────────────────────────────────
    public function index()
    {
        $teacher = $this->getTeacher();
        $sessions = ElearningSession::where('teacher_id', $teacher->id)
            ->with(['subject', 'schoolClass'])
            ->orderBy('school_class_id')
            ->orderBy('urutan')
            ->get();

        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $classes  = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('guru.elearning.index', compact('sessions', 'subjects', 'classes'));
    }

    // ─────────────────────────────────────────────
    // Buat Pertemuan Baru
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'subject_id'      => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
        ]);

        $teacher = $this->getTeacher();

        $urutan = ElearningSession::where('teacher_id', $teacher->id)
            ->where('school_class_id', $request->school_class_id)
            ->where('subject_id', $request->subject_id)
            ->count() + 1;

        ElearningSession::create([
            'teacher_id'      => $teacher->id,
            'subject_id'      => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'urutan'          => $urutan,
            'is_published'    => $request->boolean('is_published', false),
        ]);

        return redirect()->route('guru.elearning.index')->with('success', 'Pertemuan berhasil dibuat!');
    }

    // ─────────────────────────────────────────────
    // Detail Pertemuan (Tab View)
    // ─────────────────────────────────────────────
    public function show($id)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)
            ->with(['subject', 'schoolClass', 'pretestQuestions', 'posttestQuestions', 'materials', 'assignment', 'discussions.replies.user', 'discussions.user'])
            ->findOrFail($id);

        // Siswa di kelas ini
        $students = Student::where('school_class_id', $session->school_class_id)->orderBy('nama')->get();

        // Rekap nilai pretest
        $nilaiPretest = [];
        foreach ($students as $student) {
            $answers = ElearningStudentAnswer::where('session_id', $session->id)
                ->where('student_id', $student->id)
                ->where('tipe', 'pretest')
                ->get();
            $nilaiPretest[$student->id] = [
                'nama'       => $student->nama,
                'total_soal' => $session->pretestQuestions->count(),
                'dijawab'    => $answers->count(),
                'nilai'      => $answers->sum('nilai'),
                'selesai'    => $answers->count() >= $session->pretestQuestions->count() && $session->pretestQuestions->count() > 0,
            ];
        }

        // Rekap nilai posttest
        $nilaiPosttest = [];
        foreach ($students as $student) {
            $answers = ElearningStudentAnswer::where('session_id', $session->id)
                ->where('student_id', $student->id)
                ->where('tipe', 'posttest')
                ->get();
            $nilaiPosttest[$student->id] = [
                'nama'       => $student->nama,
                'total_soal' => $session->posttestQuestions->count(),
                'dijawab'    => $answers->count(),
                'nilai'      => $answers->sum('nilai'),
                'selesai'    => $answers->count() >= $session->posttestQuestions->count() && $session->posttestQuestions->count() > 0,
            ];
        }

        // Submissions tugas
        $submissions = $session->assignment
            ? ElearningAssignmentSubmission::where('assignment_id', $session->assignment->id)
                ->with('student')
                ->get()
            : collect();

        return view('guru.elearning.show', compact('session', 'students', 'nilaiPretest', 'nilaiPosttest', 'submissions'));
    }

    // ─────────────────────────────────────────────
    // Update Pertemuan
    // ─────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($id);

        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $session->update([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'is_published' => $request->boolean('is_published', false),
        ]);

        return back()->with('success', 'Pertemuan berhasil diperbarui!');
    }

    // ─────────────────────────────────────────────
    // Hapus Pertemuan
    // ─────────────────────────────────────────────
    public function destroy($id)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($id);
        $session->delete();

        return redirect()->route('guru.elearning.index')->with('success', 'Pertemuan berhasil dihapus!');
    }

    // ─────────────────────────────────────────────
    // CRUD Soal (Pretest / Posttest)
    // ─────────────────────────────────────────────
    public function storeQuestion(Request $request, $sessionId)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);

        $request->validate([
            'tipe'          => 'required|in:pretest,posttest',
            'pertanyaan'    => 'required|string',
            'opsi_a'        => 'required|string',
            'opsi_b'        => 'required|string',
            'opsi_c'        => 'required|string',
            'opsi_d'        => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        $tipe = $request->tipe;

        // Batas 5 soal per tipe
        $existing = ElearningQuestion::where('session_id', $sessionId)
            ->where('tipe', $tipe)
            ->count();

        if ($existing >= 5) {
            return back()->withErrors(['soal' => 'Maksimal 5 soal per ' . $tipe . '!']);
        }

        ElearningQuestion::create([
            'session_id'    => $sessionId,
            'tipe'          => $tipe,
            'pertanyaan'    => $request->pertanyaan,
            'opsi_a'        => $request->opsi_a,
            'opsi_b'        => $request->opsi_b,
            'opsi_c'        => $request->opsi_c,
            'opsi_d'        => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
            'urutan'        => $existing + 1,
        ]);

        return back()->with('success', 'Soal ' . ucfirst($tipe) . ' berhasil ditambahkan!');
    }

    public function destroyQuestion($sessionId, $questionId)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);
        $question = ElearningQuestion::where('session_id', $sessionId)->findOrFail($questionId);
        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus!');
    }

    // ─────────────────────────────────────────────
    // CRUD Materi/Link Pembelajaran
    // ─────────────────────────────────────────────
    public function storeMaterial(Request $request, $sessionId)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);

        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe'  => 'required|in:youtube,file,link',
        ]);

        $konten   = null;
        $mimeType = null;

        if ($request->tipe === 'file') {
            $request->validate(['file' => 'required|file|max:51200']); // 50MB
            $file     = $request->file('file');
            $mimeType = $file->getMimeType();
            $konten   = $file->store('elearning/materi', 'public');
        } else {
            $request->validate(['url' => 'required|string']);
            $konten = $request->url;
        }

        ElearningMaterial::create([
            'session_id' => $sessionId,
            'judul'      => $request->judul,
            'tipe'       => $request->tipe,
            'konten'     => $konten,
            'mime_type'  => $mimeType,
        ]);

        return back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function destroyMaterial($sessionId, $materialId)
    {
        $teacher  = $this->getTeacher();
        $session  = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);
        $material = ElearningMaterial::where('session_id', $sessionId)->findOrFail($materialId);

        if ($material->tipe === 'file' && $material->konten) {
            Storage::disk('public')->delete($material->konten);
        }
        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus!');
    }

    // ─────────────────────────────────────────────
    // Penugasan Terstruktur
    // ─────────────────────────────────────────────
    public function storeAssignment(Request $request, $sessionId)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);

        $request->validate([
            'instruksi' => 'required|string',
            'deadline'  => 'nullable|date',
        ]);

        ElearningAssignment::updateOrCreate(
            ['session_id' => $sessionId],
            ['instruksi' => $request->instruksi, 'deadline' => $request->deadline]
        );

        return back()->with('success', 'Instruksi tugas berhasil disimpan!');
    }

    // Grade submission siswa
    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate(['nilai' => 'required|integer|min:0|max:100', 'feedback' => 'nullable|string']);
        $submission = ElearningAssignmentSubmission::findOrFail($submissionId);
        $submission->update(['nilai' => $request->nilai, 'feedback' => $request->feedback]);
        return back()->with('success', 'Nilai berhasil diberikan!');
    }

    // ─────────────────────────────────────────────
    // Forum Diskusi
    // ─────────────────────────────────────────────
    public function storeDiscussion(Request $request, $sessionId)
    {
        $teacher = $this->getTeacher();
        $session = ElearningSession::where('teacher_id', $teacher->id)->findOrFail($sessionId);

        $request->validate(['pesan' => 'required|string', 'parent_id' => 'nullable|exists:elearning_discussions,id']);

        $filePath = null;
        $namaFile = null;
        $tipeFile = null;
        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $namaFile = $file->getClientOriginalName();
            $tipeFile = str_contains($file->getMimeType(), 'image') ? 'gambar' : 'dokumen';
            $filePath = $file->store('elearning/diskusi', 'public');
        }

        ElearningDiscussion::create([
            'session_id' => $sessionId,
            'user_id'    => Auth::id(),
            'parent_id'  => $request->parent_id,
            'pesan'      => $request->pesan,
            'file_path'  => $filePath,
            'nama_file'  => $namaFile,
            'tipe_file'  => $tipeFile,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function destroyDiscussion($sessionId, $discussionId)
    {
        $discussion = ElearningDiscussion::where('session_id', $sessionId)
            ->where(function($q) { $q->where('user_id', Auth::id()); })
            ->findOrFail($discussionId);

        if ($discussion->file_path) {
            Storage::disk('public')->delete($discussion->file_path);
        }
        $discussion->delete();

        return back()->with('success', 'Pesan berhasil dihapus!');
    }
}
