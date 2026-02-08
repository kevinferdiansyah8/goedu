@extends('layouts.admin')

@section('title', 'Jadwal Mengajar')

@section('content')
@php
$jadwal = [
  [
    'guru' => 'Budi Santoso',
    'mapel' => 'Pemrograman Dasar',
    'kelas' => 'X RPL 1',
    'hari' => 'Senin',
    'jam' => '07:00 - 09:00',
    'ruangan' => 'Lab Komputer 1'
  ],
  [
    'guru' => 'Siti Aminah',
    'mapel' => 'Basis Data',
    'kelas' => 'XI RPL 2',
    'hari' => 'Selasa',
    'jam' => '09:00 - 11:00',
    'ruangan' => 'Lab Komputer 2'
  ],
];

$daftarGuru = collect($jadwal)->pluck('guru')->unique();
$daftarHari = collect($jadwal)->pluck('hari')->unique();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
      <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Jadwal Mengajar</h1>
      <p class="text-lg text-gray-400">Atur jadwal mengajar guru dan kelas</p>
    </div>
    <button onclick="toggleForm()"
      class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:scale-105 transition-all duration-200">
      <i class="fa fa-plus"></i>
      Tambah Jadwal
    </button>
  </div>

  <!-- FILTER -->
  <div class="flex flex-wrap gap-4 mb-6">
    <select id="filterGuru" class="border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
      <option value="">Semua Guru</option>
      @foreach($daftarGuru as $g)
        <option value="{{ $g }}">{{ $g }}</option>
      @endforeach
    </select>
    <select id="filterHari" class="border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
      <option value="">Semua Hari</option>
      @foreach($daftarHari as $h)
        <option value="{{ $h }}">{{ $h }}</option>
      @endforeach
    </select>
  </div>

  <!-- TABEL -->
  <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
    <table class="w-full text-base">
      <thead class="bg-slate-100 text-blue-900">
        <tr>
          <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Guru</th>
          <th class="px-5 py-3 font-bold">Mata Pelajaran</th>
          <th class="px-5 py-3 font-bold">Kelas</th>
          <th class="px-5 py-3 font-bold">Hari</th>
          <th class="px-5 py-3 font-bold">Jam</th>
          <th class="px-5 py-3 font-bold">Ruangan</th>
          <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Aksi</th>
        </tr>
      </thead>
      <tbody id="jadwalTable">
        @foreach($jadwal as $j)
        <tr data-guru="{{ $j['guru'] }}" data-hari="{{ $j['hari'] }}" class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
          <td class="px-5 py-3 flex items-center gap-3">
            <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $j['guru']))->map(fn($n)=>$n[0])->join('') }}</span>
            <span class="font-medium text-gray-800">{{ $j['guru'] }}</span>
          </td>
          <td class="px-5 py-3">{{ $j['mapel'] }}</td>
          <td class="px-5 py-3">{{ $j['kelas'] }}</td>
          <td class="px-5 py-3">{{ $j['hari'] }}</td>
          <td class="px-5 py-3">{{ $j['jam'] }}</td>
          <td class="px-5 py-3">{{ $j['ruangan'] }}</td>
          <td class="px-5 py-3 text-center">
            <button class="btn-edit flex items-center gap-1"><i class="fa fa-edit"></i> Edit</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- FORM -->
  <div id="formJadwal" class="hidden max-w-2xl mx-auto mt-10">
    <div class="bg-white/95 rounded-2xl shadow-2xl p-8">
      <h2 class="text-2xl font-bold mb-4 text-blue-700 flex items-center gap-2"><i class="fa fa-calendar-plus"></i> Tambah Jadwal Mengajar</h2>
      <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Nama Guru">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Mata Pelajaran">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Kelas">
          <select class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400">
            <option>Senin</option><option>Selasa</option><option>Rabu</option>
            <option>Kamis</option><option>Jumat</option>
          </select>
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Jam (07:00 - 09:00)">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Ruangan">
        </div>
        <div class="flex justify-end gap-2 mt-6">
          <button type="button" onclick="toggleForm()" class="px-5 py-2 border rounded-xl">Batal</button>
          <button class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 hover:scale-105 transition-all">Simpan</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
lucide.createIcons();
function toggleForm() {
  document.getElementById('formJadwal').classList.toggle('hidden');
}
const guruFilter = document.getElementById('filterGuru');
const hariFilter = document.getElementById('filterHari');
function applyFilter() {
  document.querySelectorAll('#jadwalTable tr').forEach(row => {
    const g = row.dataset.guru;
    const h = row.dataset.hari;
    const show =
      (!guruFilter.value || g === guruFilter.value) &&
      (!hariFilter.value || h === hariFilter.value);
    row.style.display = show ? '' : 'none';
  });
}
guruFilter.addEventListener('change', applyFilter);
hariFilter.addEventListener('change', applyFilter);
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
<style>
.btn-edit {
  background:#2563eb;
  color:white;
  padding:6px 18px;
  border-radius:8px;
  font-size:14px;
  font-weight:600;
  box-shadow:0 2px 8px #2563eb22;
  transition:all .15s;
  display:inline-flex;
  align-items:center;
  gap:6px;
}
.btn-edit:hover { background:#1746a2; box-shadow:0 4px 16px #2563eb33; transform:scale(1.05); }
</style>
@endpush
