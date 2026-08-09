<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('kelas')) {
            $kelasFilter = $request->kelas;
            $cleanFilter = str_replace('Kelas ', '', $kelasFilter);
            $query->where(function($q) use ($kelasFilter, $cleanFilter) {
                $q->where('kelas', $kelasFilter)
                  ->orWhere('kelas', $cleanFilter)
                  ->orWhere('kelas', 'like', $cleanFilter . ' %')
                  ->orWhere('kelas', 'like', $cleanFilter . '-%');
            });
        }

        $siswa = $query->latest()->paginate(10);
        $totalSiswa = Student::count();
        $daftarKelas = SchoolClass::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('admin.users', compact('siswa', 'totalSiswa', 'daftarKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'nik' => 'nullable',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'school_class_id' => 'required|exists:school_classes,id',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $kelasName = $kelas->tingkat === $kelas->nama_kelas ? $kelas->tingkat : $kelas->tingkat . ' ' . $kelas->nama_kelas;

        $plainPassword = $request->filled('password') ? $request->password : 'siswa123';

        // 1. Create linked User account
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => 'siswa',
        ]);

        // 2. Create Student data
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'school_class_id' => $request->school_class_id,
            'kelas' => $kelasName,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        return redirect()->back()->with([
            'success' => "Data Siswa & Akun Login berhasil dibuat (Password: {$plainPassword})",
            'wa_student_id' => $student->id,
            'wa_plain_password' => $plainPassword,
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $userId = $student->user_id;

        $request->validate([
            'nis' => 'required|unique:students,nis,' . $id,
            'nisn' => 'nullable|unique:students,nisn,' . $id,
            'nik' => 'nullable',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($userId ?: 'NULL'),
            'password' => 'nullable|string|min:6',
            'school_class_id' => 'required|exists:school_classes,id',
            'jenis_kelamin' => 'nullable',
            'telepon' => 'nullable',
        ]);

        $kelas = SchoolClass::find($request->school_class_id);
        $kelasName = $kelas->tingkat === $kelas->nama_kelas ? $kelas->tingkat : $kelas->tingkat . ' ' . $kelas->nama_kelas;

        $plainPassword = $request->filled('password') ? $request->password : null;

        // Update or create linked User account
        if ($student->user) {
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $student->user->update($userData);
        } else {
            $plainPassword = $request->filled('password') ? $request->password : 'siswa123';
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($plainPassword),
                'role' => 'siswa',
            ]);
            $student->user_id = $user->id;
        }

        $student->update([
            'user_id' => $student->user_id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'school_class_id' => $request->school_class_id,
            'kelas' => $kelasName,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        return redirect()->back()->with([
            'success' => 'Data Siswa & Akun Login berhasil diperbarui',
            'wa_student_id' => $student->id,
            'wa_plain_password' => $plainPassword,
        ]);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();

        return redirect()->back()->with('success', 'Data Siswa & Akun Login berhasil dihapus');
    }
}

