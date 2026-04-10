<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('teacher');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mataPelajaran = $query->latest()->paginate(10);
        $teachers = Teacher::all();

        // Stats
        $daftarJurusan = Subject::whereNotNull('jurusan')->distinct()->pluck('jurusan');
        $daftarTingkat = Subject::whereNotNull('tingkat')->distinct()->pluck('tingkat');
        $totalAktif = Subject::where('status', 'Aktif')->count();
        $totalNonAktif = Subject::where('status', 'Tidak Aktif')->count();
        $totalJam = Subject::sum('jumlah_jam');
        $totalMapel = Subject::count();

        return view('admin.akademik.mata-pelajaran', compact(
            'mataPelajaran', 'teachers', 'daftarJurusan', 'daftarTingkat',
            'totalAktif', 'totalNonAktif', 'totalJam', 'totalMapel'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:subjects,kode',
            'nama' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'teacher_id' => 'required|exists:teachers,id',
            'jumlah_jam' => 'required|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Subject::create($validated);
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        
        $validated = $request->validate([
            'kode' => 'required|unique:subjects,kode,' . $id,
            'nama' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'teacher_id' => 'required|exists:teachers,id',
            'jumlah_jam' => 'required|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $subject->update($validated);
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Mata Pelajaran berhasil dihapus');
    }
}
