@extends('layouts.admin')

@section('title', 'Izin / Sakit / Alpha')

@section('content')
@php
$izinSiswa = [
  [
    'nama' => 'Andi Pratama',
    'kelas' => 'X RPL 1',
    'jenis' => 'Sakit',
    'tanggal' => '2026-02-01',
    'alasan' => 'Demam tinggi',
    'status' => 'Menunggu',
  ],
  [
    'nama' => 'Siti Aisyah',
    'kelas' => 'XI AKL 2',
    'jenis' => 'Izin',
    'tanggal' => '2026-02-01',
    'alasan' => 'Acara keluarga',
    'status' => 'Disetujui',
  ],
];

$izinGuru = [
  [
    'nama' => 'Budi Santoso, S.Pd',
    'mapel' => 'Matematika',
    'jenis' => 'Izin',
    'tanggal' => '2026-02-01',
    'alasan' => 'Urusan keluarga',
    'status' => 'Menunggu',
  ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Izin / Sakit / Alpha</h1>
    <p class="text-gray-500">Monitoring pengajuan izin dan ketidakhadiran siswa & guru</p>
  </div>

  <!-- Tabs -->
  <div class="flex gap-2 mb-6">
    <button class="tab-btn active" onclick="switchTab('siswa', this)">Siswa</button>
    <button class="tab-btn" onclick="switchTab('guru', this)">Guru</button>
  </div>

  <!-- ===================== -->
  <!-- TAB SISWA -->
  <!-- ===================== -->
  <div id="tab-siswa">
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
      <table class="w-full text-base">
        <thead class="bg-slate-100 text-blue-900">
          <tr>
            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
            <th class="px-5 py-3 text-left font-bold">Kelas</th>
            <th class="px-5 py-3 text-center font-bold">Jenis</th>
            <th class="px-5 py-3 text-center font-bold">Tanggal</th>
            <th class="px-5 py-3 text-left font-bold">Alasan</th>
            <th class="px-5 py-3 text-center font-bold">Status</th>
            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($izinSiswa as $row)
          @php
            $status = strtolower($row['status']);
            $badge = $status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : ($status == 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700');
            $icon = $status == 'menunggu' ? 'fa-clock' : ($status == 'disetujui' ? 'fa-check-circle' : 'fa-times-circle');
          @endphp
          <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
            <td class="px-5 py-3 flex items-center gap-3">
              <span class='w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $row['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
              <span class="font-medium text-gray-800">{{ $row['nama'] }}</span>
            </td>
            <td class="px-5 py-3">{{ $row['kelas'] }}</td>
            <td class="px-5 py-3 text-center">{{ $row['jenis'] }}</td>
            <td class="px-5 py-3 text-center">{{ $row['tanggal'] }}</td>
            <td class="px-5 py-3">{{ $row['alasan'] }}</td>
            <td class="px-5 py-3 text-center">
              <span class="px-3 py-1 rounded-full {{$badge}} text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa {{$icon}}'></i> {{ $row['status'] }}</span>
            </td>
            <td class="px-5 py-3 text-center flex gap-2 justify-center">
              <button class="btn-approve flex items-center gap-1"><i class="fa fa-check"></i> Setujui</button>
              <button class="btn-reject flex items-center gap-1"><i class="fa fa-times"></i> Tolak</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- ===================== -->
  <!-- TAB GURU -->
  <!-- ===================== -->
  <div id="tab-guru" class="hidden">
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
      <table class="w-full text-base">
        <thead class="bg-slate-100 text-blue-900">
          <tr>
            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
            <th class="px-5 py-3 text-left font-bold">Mapel</th>
            <th class="px-5 py-3 text-center font-bold">Jenis</th>
            <th class="px-5 py-3 text-center font-bold">Tanggal</th>
            <th class="px-5 py-3 text-left font-bold">Alasan</th>
            <th class="px-5 py-3 text-center font-bold">Status</th>
            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($izinGuru as $row)
          @php
            $status = strtolower($row['status']);
            $badge = $status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : ($status == 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700');
            $icon = $status == 'menunggu' ? 'fa-clock' : ($status == 'disetujui' ? 'fa-check-circle' : 'fa-times-circle');
          @endphp
          <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
            <td class="px-5 py-3 flex items-center gap-3">
              <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $row['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
              <span class="font-medium text-gray-800">{{ $row['nama'] }}</span>
            </td>
            <td class="px-5 py-3">{{ $row['mapel'] }}</td>
            <td class="px-5 py-3 text-center">{{ $row['jenis'] }}</td>
            <td class="px-5 py-3 text-center">{{ $row['tanggal'] }}</td>
            <td class="px-5 py-3">{{ $row['alasan'] }}</td>
            <td class="px-5 py-3 text-center">
              <span class="px-3 py-1 rounded-full {{$badge}} text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa {{$icon}}'></i> {{ $row['status'] }}</span>
            </td>
            <td class="px-5 py-3 text-center flex gap-2 justify-center">
              <button class="btn-approve flex items-center gap-1"><i class="fa fa-check"></i> Setujui</button>
              <button class="btn-reject flex items-center gap-1"><i class="fa fa-times"></i> Tolak</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>

<style>
.tab-btn {
  padding: 0.5rem 1.25rem;
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
  font-weight: 500;
  color: #6b7280;
}
.tab-btn.active {
  background: #2563eb;
  color: white;
  border-color: #2563eb;
}
.btn-approve {
  background:#16a34a;
  color:white;
  padding:6px 16px;
  border-radius:8px;
  font-size:14px;
  font-weight:600;
  box-shadow:0 2px 8px #16a34a22;
  transition:all .15s;
}
.btn-approve:hover { background:#15803d; box-shadow:0 4px 16px #16a34a33; transform:scale(1.05); }
.btn-reject {
  background:#dc2626;
  color:white;
  padding:6px 16px;
  border-radius:8px;
  font-size:14px;
  font-weight:600;
  box-shadow:0 2px 8px #dc262622;
  transition:all .15s;
}
.btn-reject:hover { background:#b91c1c; box-shadow:0 4px 16px #dc262633; transform:scale(1.05); }
</style>

<script>
function switchTab(tab, btn) {
  document.getElementById('tab-siswa').classList.add('hidden');
  document.getElementById('tab-guru').classList.add('hidden');

  document.getElementById('tab-' + tab).classList.remove('hidden');

  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
@endsection
