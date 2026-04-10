<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::with('teacher');

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $kelas = $query->latest()->paginate(10);
        $teachers = Teacher::all();

        $daftarTingkat = SchoolClass::whereNotNull('tingkat')->distinct()->pluck('tingkat');
        $daftarTahunAjaran = SchoolClass::whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        $totalKelas = SchoolClass::count();
        $totalDenganWali = SchoolClass::whereNotNull('teacher_id')->count();
        $totalTanpaWali = SchoolClass::whereNull('teacher_id')->count();

        // Calculate total siswa if students table is related but currently no direct relationship, we leave it static 0 for now
        $totalSiswa = 0; 
        
        return view('admin.akademik.kelas-wali-kelas', compact(
            'kelas', 'teachers', 'daftarTingkat', 'daftarTahunAjaran',
            'totalKelas', 'totalDenganWali', 'totalTanpaWali', 'totalSiswa'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required',
            'nama_kelas' => 'required|unique:school_classes,nama_kelas',
            'teacher_id' => 'nullable|exists:teachers,id',
            'tahun_ajaran' => 'required',
        ]);

        SchoolClass::create($validated);
        return redirect()->back()->with('success', 'Data Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);

        $validated = $request->validate([
            'tingkat' => 'required',
            'nama_kelas' => 'required|unique:school_classes,nama_kelas,' . $id,
            'teacher_id' => 'nullable|exists:teachers,id',
            'tahun_ajaran' => 'required',
        ]);

        $schoolClass->update($validated);
        return redirect()->back()->with('success', 'Data Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        SchoolClass::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Kelas berhasil dihapus');
    }
}
