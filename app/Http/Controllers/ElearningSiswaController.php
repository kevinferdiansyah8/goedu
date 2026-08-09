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
use App\Models\Student;

class ElearningSiswaController extends Controller
{
    private function getStudent()
    {
        return Auth::user()->student ?? Student::first();
    }

    private function recordAttendance($session, $student)
    {
        if (!$student || !$session) return null;

        $schedule = \App\Models\Schedule::where('subject_id', $session->subject_id)
            ->where('school_class_id', $session->school_class_id)
            ->first();

        return \App\Models\Attendance::updateOrCreate(
            [
                'student_id'           => $student->id,
                'elearning_session_id' => $session->id,
            ],
            [
                'schedule_id' => $schedule ? $schedule->id : null,
                'tanggal'     => now()->toDateString(),
                'jam_masuk'   => now()->format('H:i:s'),
                'status'      => 'Hadir',
                'keterangan'  => 'Hadir via E-Learning: ' . $session->judul,
            ]
        );
    }

    private function checkAndRecordAttendance($session, $student): bool
    {
        if (!$student || !$session) return false;

        $session->loadMissing(['pretestQuestions', 'posttestQuestions', 'assignment']);

        // 1. Cek Pretest (jika ada soal pretest)
        $hasPretest = $session->pretestQuestions && $session->pretestQuestions->count() > 0;
        $pretestDone = !$hasPretest || $this->hasCompletedPretest($session->id, $student->id);

        // 2. Cek Penugasan (jika ada tugas)
        $hasAssignment = (bool) $session->assignment;
        $assignmentDone = !$hasAssignment || ElearningAssignmentSubmission::where('assignment_id', $session->assignment->id)
            ->where('student_id', $student->id)
            ->exists();

        // 3. Cek Keaktifan Forum Diskusi (minimal 2 postingan/balasan)
        $discussionCount = ElearningDiscussion::where('session_id', $session->id)
            ->where('user_id', Auth::id())
            ->count();
        $forumDone = $discussionCount >= 2;

        // 4. Cek Posttest (jika ada soal posttest)
        $hasPosttest = $session->posttestQuestions && $session->posttestQuestions->count() > 0;
        $posttestDone = !$hasPosttest || $this->hasCompletedPosttest($session->id, $student->id);

        // Hanya jika seluruh tahapan wajib diselesaikan (termasuk Diskusi >= 2 dan Posttest), absensi tercatat Hadir
        if ($pretestDone && $assignmentDone && $forumDone && $posttestDone) {
            $this->recordAttendance($session, $student);
            return true;
        }

        return false;
    }

    public function recordPresensi($id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->findOrFail($id);

        $attended = $this->checkAndRecordAttendance($session, $student);

        if ($attended) {
            return back()->with('success', 'Status presensi kehadiran E-Learning berhasil dicatat (Hadir)!');
        }

        return back()->with('error', 'Presensi tidak dapat dilakukan manual. Harap selesaikan seluruh tahapan E-Learning hingga Posttest terlebih dahulu.');
    }

    // Cek apakah siswa sudah menyelesaikan pretest
    private function hasCompletedPretest($sessionId, $studentId): bool
    {
        $session = ElearningSession::with('pretestQuestions')->find($sessionId);
        if (!$session || $session->pretestQuestions->count() === 0) return false;

        $answered = ElearningStudentAnswer::where('session_id', $sessionId)
            ->where('student_id', $studentId)
            ->where('tipe', 'pretest')
            ->count();

        return $answered >= $session->pretestQuestions->count();
    }

    // Cek apakah siswa sudah mengerjakan posttest
    private function hasCompletedPosttest($sessionId, $studentId): bool
    {
        $session = ElearningSession::with('posttestQuestions')->find($sessionId);
        if (!$session || $session->posttestQuestions->count() === 0) return false;

        $answered = ElearningStudentAnswer::where('session_id', $sessionId)
            ->where('student_id', $studentId)
            ->where('tipe', 'posttest')
            ->count();

        return $answered >= $session->posttestQuestions->count();
    }

    // ─────────────────────────────────────────────
    // Daftar Pertemuan
    // ─────────────────────────────────────────────
    public function index()
    {
        $student  = $this->getStudent();
        $sessions = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with(['subject', 'pretestQuestions'])
            ->orderBy('subject_id')
            ->orderBy('urutan')
            ->get();

        // Tambahkan status progress & absensi tiap pertemuan
        $sessionsWithProgress = $sessions->map(function ($session) use ($student) {
            $pretestDone  = $this->hasCompletedPretest($session->id, $student->id);
            $posttestDone = $this->hasCompletedPosttest($session->id, $student->id);

            // Cek submission tugas
            $hasAssignment = $session->assignment()->exists();
            $submitted = false;
            if ($hasAssignment) {
                $submitted = ElearningAssignmentSubmission::where('assignment_id', $session->assignment->id)
                    ->where('student_id', $student->id)
                    ->exists();
            }

            // Cek keaktifan di forum (minimal 2 kiriman)
            $discussionCount = ElearningDiscussion::where('session_id', $session->id)
                ->where('user_id', Auth::id())
                ->count();
            $forumDone = $discussionCount >= 2;

            // Cek dan sync absensi jika SEMUA tahapan telah lengkap
            $this->checkAndRecordAttendance($session, $student);

            // Cek status absensi
            $isAttended = \App\Models\Attendance::where('student_id', $student->id)
                ->where('elearning_session_id', $session->id)
                ->where('status', 'Hadir')
                ->exists();

            $session->pretest_done     = $pretestDone;
            $session->posttest_done    = $posttestDone;
            $session->tugas_done       = $submitted;
            $session->discussion_count = $discussionCount;
            $session->forum_done       = $forumDone;
            $session->is_attended      = $isAttended;

            return $session;
        });

        return view('siswa.elearning.index', compact('sessionsWithProgress'));
    }

    // ─────────────────────────────────────────────
    // Detail Pertemuan
    // ─────────────────────────────────────────────
    public function show($id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with(['subject', 'schoolClass', 'materials', 'assignment', 'pretestQuestions', 'posttestQuestions'])
            ->findOrFail($id);

        $pretestDone  = $this->hasCompletedPretest($session->id, $student->id);
        $posttestDone = $this->hasCompletedPosttest($session->id, $student->id);

        // Hasil pretest
        $pretestAnswers = ElearningStudentAnswer::where('session_id', $session->id)
            ->where('student_id', $student->id)
            ->where('tipe', 'pretest')
            ->with('question')
            ->get();
        $nilaiPretest = $pretestAnswers->sum('nilai');

        // Hasil posttest
        $posttestAnswers = ElearningStudentAnswer::where('session_id', $session->id)
            ->where('student_id', $student->id)
            ->where('tipe', 'posttest')
            ->with('question')
            ->get();
        $nilaiPosttest = $posttestAnswers->sum('nilai');

        // Submission tugas
        $mySubmission = null;
        if ($session->assignment) {
            $mySubmission = ElearningAssignmentSubmission::where('assignment_id', $session->assignment->id)
                ->where('student_id', $student->id)
                ->first();
        }

        // Diskusi
        $discussions = ElearningDiscussion::where('session_id', $session->id)
            ->whereNull('parent_id')
            ->with(['replies.user', 'user'])
            ->latest()
            ->get();

        $discussionCount = ElearningDiscussion::where('session_id', $session->id)
            ->where('user_id', Auth::id())
            ->count();

        $forumDone = $discussionCount >= 2;

        // Sync absensi hanya jika seluruh tahapan lengkap
        $this->checkAndRecordAttendance($session, $student);

        $isAttended = \App\Models\Attendance::where('student_id', $student->id)
            ->where('elearning_session_id', $session->id)
            ->where('status', 'Hadir')
            ->exists();

        return view('siswa.elearning.show', compact(
            'session', 'pretestDone', 'posttestDone',
            'nilaiPretest', 'nilaiPosttest',
            'pretestAnswers', 'posttestAnswers',
            'mySubmission', 'discussions', 'student',
            'discussionCount', 'forumDone', 'isAttended'
        ));
    }

    // ─────────────────────────────────────────────
    // Submit Pretest
    // ─────────────────────────────────────────────
    public function showPretest($id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with('pretestQuestions')
            ->findOrFail($id);

        if ($this->hasCompletedPretest($id, $student->id)) {
            return redirect()->route('siswa.elearning.show', $id)->with('info', 'Anda sudah mengerjakan pretest ini.');
        }

        if ($session->pretestQuestions->count() === 0) {
            return redirect()->route('siswa.elearning.show', $id)->with('info', 'Pretest belum tersedia.');
        }

        return view('siswa.elearning.pretest', compact('session'));
    }

    public function submitPretest(Request $request, $id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with('pretestQuestions')
            ->findOrFail($id);

        if ($this->hasCompletedPretest($id, $student->id)) {
            return redirect()->route('siswa.elearning.show', $id);
        }

        $request->validate(['jawaban' => 'required|array']);

        foreach ($session->pretestQuestions as $question) {
            $jawaban    = $request->jawaban[$question->id] ?? null;
            $is_correct = $jawaban === $question->jawaban_benar;

            ElearningStudentAnswer::updateOrCreate(
                ['session_id' => $id, 'student_id' => $student->id, 'question_id' => $question->id, 'tipe' => 'pretest'],
                ['jawaban' => $jawaban, 'is_correct' => $is_correct, 'nilai' => $is_correct ? 20 : 0]
            );
        }

        // Otomatis cek & catat absensi Hadir jika seluruh tahapan sudah lengkap
        $isAttended = $this->checkAndRecordAttendance($session, $student);
        $msg = $isAttended 
            ? 'Pretest berhasil dikumpulkan! Seluruh tahapan E-Learning selesai & Absensi Anda otomatis tercatat (Hadir).' 
            : 'Pretest berhasil dikumpulkan! Selesaikan tahapan lainnya s.d. Posttest untuk mendapatkan absensi Hadir.';

        return redirect()->route('siswa.elearning.hasil', [$id, 'pretest'])->with('success', $msg);
    }

    // ─────────────────────────────────────────────
    // Submit Posttest
    // ─────────────────────────────────────────────
    public function showPosttest($id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with('posttestQuestions')
            ->findOrFail($id);

        if (!$this->hasCompletedPretest($id, $student->id)) {
            return redirect()->route('siswa.elearning.show', $id)
                ->with('error', 'Selesaikan Pretest terlebih dahulu sebelum mengerjakan Posttest.');
        }

        $discussionCount = ElearningDiscussion::where('session_id', $id)
            ->where('user_id', Auth::id())
            ->count();

        if ($discussionCount < 2) {
            return redirect()->route('siswa.elearning.show', $id)
                ->with('error', 'Anda harus berpartisipasi di Forum Diskusi minimal 2 kali (membuat pertanyaan atau membalas diskusi) sebelum mengerjakan Posttest.');
        }

        if ($this->hasCompletedPosttest($id, $student->id)) {
            return redirect()->route('siswa.elearning.hasil', [$id, 'posttest'])->with('info', 'Anda sudah mengerjakan posttest ini.');
        }

        if ($session->posttestQuestions->count() === 0) {
            return redirect()->route('siswa.elearning.show', $id)->with('info', 'Posttest belum tersedia.');
        }

        return view('siswa.elearning.posttest', compact('session'));
    }

    public function submitPosttest(Request $request, $id)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->with('posttestQuestions')
            ->findOrFail($id);

        if (!$this->hasCompletedPretest($id, $student->id)) {
            return redirect()->route('siswa.elearning.show', $id)
                ->with('error', 'Selesaikan Pretest terlebih dahulu.');
        }

        $discussionCount = ElearningDiscussion::where('session_id', $id)
            ->where('user_id', Auth::id())
            ->count();

        if ($discussionCount < 2) {
            return redirect()->route('siswa.elearning.show', $id)
                ->with('error', 'Anda harus berpartisipasi di Forum Diskusi minimal 2 kali sebelum mengirimkan Posttest.');
        }

        if ($this->hasCompletedPosttest($id, $student->id)) {
            return redirect()->route('siswa.elearning.hasil', [$id, 'posttest']);
        }

        $request->validate(['jawaban' => 'required|array']);

        foreach ($session->posttestQuestions as $question) {
            $jawaban    = $request->jawaban[$question->id] ?? null;
            $is_correct = $jawaban === $question->jawaban_benar;

            ElearningStudentAnswer::updateOrCreate(
                ['session_id' => $id, 'student_id' => $student->id, 'question_id' => $question->id, 'tipe' => 'posttest'],
                ['jawaban' => $jawaban, 'is_correct' => $is_correct, 'nilai' => $is_correct ? 20 : 0]
            );
        }

        // Otomatis cek & catat absensi Hadir jika seluruh tahapan sudah lengkap
        $isAttended = $this->checkAndRecordAttendance($session, $student);
        $msg = $isAttended 
            ? 'Posttest berhasil dikumpulkan! Seluruh tahapan E-Learning telah selesai & Absensi Anda otomatis tercatat (Hadir).' 
            : 'Posttest berhasil dikumpulkan!';

        return redirect()->route('siswa.elearning.hasil', [$id, 'posttest'])->with('success', $msg);
    }

    // ─────────────────────────────────────────────
    // Hasil Pre/Posttest
    // ─────────────────────────────────────────────
    public function hasil($id, $tipe)
    {
        $student  = $this->getStudent();
        $session  = ElearningSession::where('school_class_id', $student->school_class_id)->findOrFail($id);
        $answers  = ElearningStudentAnswer::where('session_id', $id)
            ->where('student_id', $student->id)
            ->where('tipe', $tipe)
            ->with('question')
            ->get();

        $totalNilai  = $answers->sum('nilai');
        $totalBenar  = $answers->where('is_correct', true)->count();
        $totalSalah  = $answers->where('is_correct', false)->count();

        return view('siswa.elearning.hasil', compact('session', 'answers', 'totalNilai', 'totalBenar', 'totalSalah', 'tipe'));
    }

    // ─────────────────────────────────────────────
    // Upload Tugas
    // ─────────────────────────────────────────────
    public function storeSubmission(Request $request, $sessionId)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->findOrFail($sessionId);

        $assignment = ElearningAssignment::where('session_id', $sessionId)->firstOrFail();

        $request->validate([
            'tipe_submit' => 'required|in:file,link,gambar,video',
            'catatan'     => 'nullable|string',
        ]);

        $filePath = null;
        $namaFile = null;
        $konten   = null;

        if ($request->tipe_submit === 'link') {
            $request->validate(['konten' => 'required|string']);
            $konten = $request->konten;
        } else {
            $request->validate(['file' => 'required|file|max:51200']);
            $file     = $request->file('file');
            $namaFile = $file->getClientOriginalName();
            $filePath = $file->store('elearning/tugas', 'public');
        }

        ElearningAssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $student->id],
            [
                'tipe_submit' => $request->tipe_submit,
                'konten'      => $konten,
                'file_path'   => $filePath,
                'nama_file'   => $namaFile,
                'catatan'     => $request->catatan,
            ]
        );

        // Otomatis cek & catat absensi Hadir jika seluruh tahapan sudah lengkap
        $isAttended = $this->checkAndRecordAttendance($session, $student);
        $msg = $isAttended 
            ? 'Tugas berhasil dikumpulkan! Seluruh tahapan E-Learning telah selesai & Absensi Anda otomatis tercatat (Hadir).' 
            : 'Tugas berhasil dikumpulkan! Lanjutkan pengerjaan modul hingga Posttest untuk mendapatkan absensi Hadir.';

        return back()->with('success', $msg);
    }

    // ─────────────────────────────────────────────
    // Forum Diskusi
    // ─────────────────────────────────────────────
    public function storeDiscussion(Request $request, $sessionId)
    {
        $student = $this->getStudent();
        $session = ElearningSession::where('school_class_id', $student->school_class_id)
            ->where('is_published', true)
            ->findOrFail($sessionId);

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

        // Otomatis cek & catat absensi Hadir jika seluruh tahapan sudah lengkap
        $this->checkAndRecordAttendance($session, $student);

        $newCount = ElearningDiscussion::where('session_id', $sessionId)
            ->where('user_id', Auth::id())
            ->count();

        $msg = 'Pesan berhasil dikirim ke forum diskusi!';
        if ($newCount >= 2) {
            $msg .= ' Anda telah memenuhi kuota minimal 2 diskusi. Posttest kini dapat dibuka.';
        } else {
            $msg .= " Partisipasi diskusi Anda saat ini: {$newCount}/2. Kirim 1 pesan lagi untuk membuka Posttest.";
        }

        return back()->with('success', $msg);
    }
}
