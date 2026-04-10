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
        $daftarKelas = SchoolClass::pluck('nama_kelas')->toArray(); // Can use SchoolClass or unique values from students table

        return view('admin.users', compact('siswa', 'totalSiswa', 'daftarKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'nama' => 'required',
            'kelas' => 'required',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

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
            'kelas' => 'required',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

        $student->update($validated);
        return redirect()->back()->with('success', 'Data Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Siswa berhasil dihapus');
    }
}
