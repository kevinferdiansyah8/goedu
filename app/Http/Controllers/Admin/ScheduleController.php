<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::all();
        $classes = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();
        // Load subjects with teacher info so we can filter by teacher in JS
        $subjects = Subject::with('teacher')->get();

        $query = Schedule::with(['subject.teacher', 'schoolClass']);

        // Optional filtering by teacher
        $selectedTeacherId = $request->teacher_id;
        if ($selectedTeacherId) {
            $query->whereHas('subject', function($q) use ($selectedTeacherId) {
                $q->where('teacher_id', $selectedTeacherId);
            });
        }

        $schedules = $query->latest()->get();

        return view('admin.akademik.jadwal-pelajaran', compact('schedules', 'teachers', 'classes', 'subjects', 'selectedTeacherId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $validated['kelas'] = $kelas->tingkat . ' ' . $kelas->nama_kelas;

        Schedule::create($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $validated['kelas'] = $kelas->tingkat . ' ' . $kelas->nama_kelas;

        $schedule->update($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }
}
