<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswa = $query->latest()->paginate(10);
        $totalSiswa = Student::count();
        $daftarKelas = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('admin.users', compact('siswa', 'totalSiswa', 'daftarKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'nama' => 'required',
            'school_class_id' => 'required|exists:school_classes,id',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $validated['kelas'] = $kelas->tingkat . ' ' . $kelas->nama_kelas;

        Student::create($validated);
        return redirect()->back()->with('success', 'Data Siswa (User) berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'nis' => 'required|unique:students,nis,' . $id,
            'nisn' => 'nullable|unique:students,nisn,' . $id,
            'nama' => 'required',
            'school_class_id' => 'required|exists:school_classes,id',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $validated['kelas'] = $kelas->tingkat . ' ' . $kelas->nama_kelas;

        $student->update($validated);
        return redirect()->back()->with('success', 'Data Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Siswa berhasil dihapus');
    }
}
