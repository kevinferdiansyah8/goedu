<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PPDBLoginController extends Controller
{
    public function login(Request $request)
    {
        $nisn = $request->input('nisn');
        $tanggal_lahir = $request->input('tanggal_lahir');

        // Contoh validasi sederhana
        if ($nisn === '1234567890' && $tanggal_lahir === '2006-01-01') {
            // Sukses login, redirect ke halaman siswa baru
            return redirect('/siswa/dashboard');
        }

        // Gagal login, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors(['nisn' => 'NISN atau tanggal lahir salah'])->withInput();
    }
}
