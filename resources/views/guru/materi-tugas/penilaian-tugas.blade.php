@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')

<h1 class="text-2xl font-bold mb-6">Penilaian Tugas</h1>

<div class="bg-white rounded-2xl p-6">
<table class="w-full">
<tr>
  <th>Nama</th>
  <th>Status</th>
  <th>Nilai</th>
</tr>
<tr>
  <td>Ahmad Fauzi</td>
  <td>Sudah</td>
  <td><input class="w-20 border rounded-lg px-2"></td>
</tr>
</table>
</div>


@endsection
