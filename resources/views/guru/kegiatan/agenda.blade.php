@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-2">Agenda Guru</h1>
  <p class="text-gray-500 mb-6">Daftar agenda kegiatan mengajar dan sekolah</p>

  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full">
      <thead class="bg-slate-100">
        <tr>
          <th class="px-4 py-3 text-left">Tanggal</th>
          <th class="px-4 py-3 text-left">Agenda</th>
          <th class="px-4 py-3 text-left">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b">
          <td class="px-4 py-3">12-02-2026</td>
          <td class="px-4 py-3">Rapat Guru</td>
          <td class="px-4 py-3">Ruang Meeting</td>
        </tr>
        <tr>
          <td class="px-4 py-3">15-02-2026</td>
          <td class="px-4 py-3">Ulangan Harian</td>
          <td class="px-4 py-3">Kelas X RPL</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
