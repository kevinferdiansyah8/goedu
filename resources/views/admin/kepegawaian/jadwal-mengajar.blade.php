@extends('layouts.admin')

@section('title', 'Jadwal Mengajar')

@section('content')
@php
$daftarGuru = collect($schedules)->map(fn($s) => $s->subject->teacher->nama ?? null)->filter()->unique();
$daftarHari = collect($schedules)->pluck('hari')->filter()->unique();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
      <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Jadwal Mengajar</h1>
      <p class="text-lg text-gray-400">Atur jadwal mengajar guru dan kelas</p>
    </div>
    <a href="{{ route('admin.akademik.jadwal-pelajaran') }}"
      class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:scale-105 transition-all duration-200">
      Kelola di Akademik
    </a>
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
        @foreach($schedules as $j)
        @php
            $guruNama = $j->subject->teacher->nama ?? '-';
            $initials = collect(explode(' ', $guruNama))->map(fn($n)=>substr($n, 0, 1))->join('');
        @endphp
        <tr data-guru="{{ $guruNama }}" data-hari="{{ $j->hari }}" class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
          <td class="px-5 py-3 flex items-center gap-3">
            <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ $initials ?: '-' }}</span>
            <span class="font-medium text-gray-800">{{ $guruNama }}</span>
          </td>
          <td class="px-5 py-3">{{ $j->subject->nama ?? '-' }}</td>
          <td class="px-5 py-3">{{ $j->kelas ?? '-' }}</td>
          <td class="px-5 py-3">{{ $j->hari }}</td>
          <td class="px-5 py-3">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
          <td class="px-5 py-3">-</td>
          <td class="px-5 py-3 text-center">
            <a href="{{ route('admin.akademik.jadwal-pelajaran') }}" class="btn-edit flex items-center gap-1 justify-center"><i class="fa fa-edit"></i> Edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- FORM (Dihilangkan, diarahkan ke Akademik) -->

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
