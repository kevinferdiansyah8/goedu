<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        $guru = $query->latest()->paginate(10);
        $totalGuru = Teacher::count();

        return view('admin.kepegawaian.data-guru', compact('guru', 'totalGuru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:teachers,nip',
            'nama' => 'required',
            'telepon' => 'nullable',
        ]);

        Teacher::create($validated);
        return redirect()->back()->with('success', 'Data Guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        $validated = $request->validate([
            'nip' => 'nullable|unique:teachers,nip,' . $id,
            'nama' => 'required',
            'telepon' => 'nullable',
        ]);

        $teacher->update($validated);
        return redirect()->back()->with('success', 'Data Guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Guru berhasil dihapus');
    }
}
