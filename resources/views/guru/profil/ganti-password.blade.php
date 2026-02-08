@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')

<h1 class="text-2xl font-bold mb-6">Ganti Password</h1>

<form class="bg-white rounded-2xl p-6 space-y-4">
<input type="password" placeholder="Password Lama" class="w-full border rounded-xl px-4 py-3">
<input type="password" placeholder="Password Baru" class="w-full border rounded-xl px-4 py-3">
<button class="bg-primary text-white px-6 py-3 rounded-xl">Simpan</button>
</form>

@endsection
