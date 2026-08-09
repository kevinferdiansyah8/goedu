<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function jadwalMengajar(Request $request)
    {
        $schedules = \App\Models\Schedule::with(['subject.teacher', 'schoolClass'])->latest()->get();
        return view('admin.kepegawaian.jadwal-mengajar', compact('schedules'));
    }

    public function index(Request $request)
    {
        $query = Teacher::with('user');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('nuptk', 'like', '%' . $request->search . '%');
        }

        $guru = $query->latest()->paginate(10);
        $totalGuru = Teacher::count();

        return view('admin.kepegawaian.data-guru', compact('guru', 'totalGuru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:teachers,nip',
            'nik' => 'nullable',
            'nuptk' => 'nullable',
            'nama' => 'required',
            'telepon' => 'nullable',
            'status_kepegawaian' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
        ]);

        $emailBase = $request->nip ? $request->nip : strtolower(str_replace(' ', '', $request->nama));
        $email = $emailBase . '@goedu.sch.id';

        if (User::where('email', $email)->exists()) {
            $email = strtolower(str_replace(' ', '.', $request->nama)) . '@goedu.sch.id';
        }

        $user = User::create([
            'name' => $request->nama,
            'email' => $email,
            'password' => Hash::make($request->password ?: 'guru123'),
            'role' => 'guru',
        ]);

        $validated['user_id'] = $user->id;
        $validated['status'] = 'Aktif';

        Teacher::create($validated);
        return redirect()->back()->with('success', 'Data Guru dan Akun berhasil ditambahkan. Email: ' . $email . ' | Pass: ' . ($request->password ?: 'guru123'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        $validated = $request->validate([
            'nip' => 'nullable|unique:teachers,nip,' . $id,
            'nik' => 'nullable',
            'nuptk' => 'nullable',
            'nama' => 'required',
            'telepon' => 'nullable',
            'status_kepegawaian' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
        ]);

        $teacher->update($validated);

        if ($teacher->user) {
            $teacher->user->update([
                'name' => $request->nama
            ]);
        }

        return redirect()->back()->with('success', 'Data Guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        if ($teacher->user) {
            $teacher->user->delete();
        }
        $teacher->delete();
        return redirect()->back()->with('success', 'Data Guru dan Akun berhasil dihapus');
    }
}
