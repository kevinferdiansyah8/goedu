@extends('layouts.admin')

@section('title', 'Data Guru & Staff')

@section('content')
@php
$pegawai = [
    [
        'id' => 1,
        'nama' => 'Budi Santoso',
        'nip' => '198712121',
        'role' => 'Guru',
        'mapel' => 'Pemrograman Dasar',
        'status' => 'Aktif',
        'email' => 'budi@sekolah.id',
    ],
    [
        'id' => 2,
        'nama' => 'Siti Aminah',
        'nip' => '198811222',
        'role' => 'Guru',
        'mapel' => 'Basis Data',
        'status' => 'Aktif',
        'email' => 'siti@sekolah.id',
    ],
    [
        'id' => 3,
        'nama' => 'Andi Wijaya',
        'nip' => '199001334',
        'role' => 'Staff',
        'mapel' => '-',
        'status' => 'Aktif',
        'email' => 'andi@sekolah.id',
    ],
    [
        'id' => 4,
        'nama' => 'Dewi Lestari',
        'nip' => '198905556',
        'role' => 'Guru',
        'mapel' => 'Akuntansi',
        'status' => 'Nonaktif',
        'email' => 'dewi@sekolah.id',
    ],
];

$totalPegawai = count($pegawai);
$totalGuru = collect($pegawai)->where('role','Guru')->count();
$totalStaff = collect($pegawai)->where('role','Staff')->count();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
      <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Data Guru & Staff</h1>
      <p class="text-lg text-gray-400">Kelola data kepegawaian sekolah</p>
    </div>
    <button onclick="toggleForm()"
      class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:scale-105 transition-all duration-200">
      <i data-lucide="plus" class="w-5 h-5"></i>
      Tambah Pegawai
    </button>
  </div>

  <!-- STATISTIK -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="card-stat bg-gradient-to-br from-blue-100 to-blue-50 border-2 border-blue-200">
      <div class="flex items-center gap-3 mb-2">
        <i class="fa fa-users text-blue-500 text-2xl"></i>
        <span class="text-gray-500 font-medium">Total Pegawai</span>
      </div>
      <div class="text-3xl font-extrabold text-blue-700">{{ $totalPegawai }}</div>
    </div>
    <div class="card-stat bg-gradient-to-br from-green-100 to-green-50 border-2 border-green-200">
      <div class="flex items-center gap-3 mb-2">
        <i class="fa fa-chalkboard-teacher text-green-500 text-2xl"></i>
        <span class="text-gray-500 font-medium">Total Guru</span>
      </div>
      <div class="text-3xl font-extrabold text-green-700">{{ $totalGuru }}</div>
    </div>
    <div class="card-stat bg-gradient-to-br from-pink-100 to-pink-50 border-2 border-pink-200">
      <div class="flex items-center gap-3 mb-2">
        <i class="fa fa-user-tie text-pink-500 text-2xl"></i>
        <span class="text-gray-500 font-medium">Total Staff</span>
      </div>
      <div class="text-3xl font-extrabold text-pink-700">{{ $totalStaff }}</div>
    </div>
  </div>

  <!-- FILTER -->
  <div class="flex flex-wrap gap-4 mb-6">
    <select id="filterRole" class="border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
      <option value="">Semua Role</option>
      <option value="Guru">Guru</option>
      <option value="Staff">Staff</option>
    </select>
    <select id="filterStatus" class="border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
      <option value="">Semua Status</option>
      <option value="Aktif">Aktif</option>
      <option value="Nonaktif">Nonaktif</option>
    </select>
  </div>

  <!-- TABEL -->
  <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
    <table class="w-full text-base">
      <thead class="bg-slate-100 text-blue-900">
        <tr>
          <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
          <th class="px-5 py-3">NIP</th>
          <th class="px-5 py-3">Role</th>
          <th class="px-5 py-3">Mapel</th>
          <th class="px-5 py-3">Status</th>
          <th class="px-5 py-3 text-center rounded-tr-xl">Aksi</th>
        </tr>
      </thead>
      <tbody id="pegawaiTable">
        @foreach($pegawai as $p)
        @php
          $status = strtolower($p['status']);
          $badge = $status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600';
          $icon = $status == 'aktif' ? 'fa-check-circle' : 'fa-minus-circle';
        @endphp
        <tr data-role="{{ $p['role'] }}" data-status="{{ $p['status'] }}" class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
          <td class="px-5 py-3 flex items-center gap-3">
            <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $p['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
            <span class="font-medium text-gray-800">{{ $p['nama'] }}</span>
          </td>
          <td class="px-5 py-3">{{ $p['nip'] }}</td>
          <td class="px-5 py-3">{{ $p['role'] }}</td>
          <td class="px-5 py-3">{{ $p['mapel'] }}</td>
          <td class="px-5 py-3">
            <span class="px-3 py-1 rounded-full {{$badge}} text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa {{$icon}}'></i> {{ $p['status'] }}</span>
          </td>
          <td class="px-5 py-3 text-center">
            <button class="btn-edit flex items-center gap-1"><i class="fa fa-edit"></i> Edit</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- FORM TAMBAH -->
  <div id="formPegawai" class="hidden max-w-2xl mx-auto mt-10">
    <div class="bg-white/95 rounded-2xl shadow-2xl p-8">
      <h2 class="text-2xl font-bold mb-4 text-blue-700 flex items-center gap-2"><i class="fa fa-user-plus"></i> Tambah Pegawai</h2>
      <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Nama Lengkap">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="NIP / NIK">
          <select class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400">
            <option>Guru</option>
            <option>Staff</option>
          </select>
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Mata Pelajaran (jika guru)">
          <input class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Email">
          <select class="input border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400">
            <option>Aktif</option>
            <option>Nonaktif</option>
          </select>
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
  document.getElementById('formPegawai').classList.toggle('hidden');
}
const roleFilter = document.getElementById('filterRole');
const statusFilter = document.getElementById('filterStatus');
function applyFilter() {
  document.querySelectorAll('#pegawaiTable tr').forEach(row => {
    const role = row.dataset.role;
    const status = row.dataset.status;
    const show =
      (!roleFilter.value || role === roleFilter.value) &&
      (!statusFilter.value || status === statusFilter.value);
    row.style.display = show ? '' : 'none';
  });
}
roleFilter.addEventListener('change', applyFilter);
statusFilter.addEventListener('change', applyFilter);
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
<style>
.card-stat {
  border-radius: 20px;
  box-shadow: 0 2px 12px #2563eb11;
  min-height: 110px;
  padding: 1.5rem 1.5rem 1.2rem 1.5rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  transition: box-shadow .2s, transform .2s;
}
.card-stat:hover { box-shadow: 0 4px 24px #2563eb22; transform: scale(1.03); }
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
