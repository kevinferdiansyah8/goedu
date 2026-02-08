@extends('layouts.admin')

@section('title', 'Absensi Siswa')

@section('content')
@php
$kelasList = ['X RPL 1', 'X RPL 2', 'XI RPL 1'];

$siswa = [
    'X RPL 1' => [
        ['nama' => 'Andi Saputra', 'nis' => '101'],
        ['nama' => 'Budi Hartono', 'nis' => '102'],
        ['nama' => 'Citra Lestari', 'nis' => '103'],
    ],
    'X RPL 2' => [
        ['nama' => 'Dewi Anggraini', 'nis' => '201'],
        ['nama' => 'Eko Prasetyo', 'nis' => '202'],
    ],
    'XI RPL 1' => [
        ['nama' => 'Fajar Nugraha', 'nis' => '301'],
        ['nama' => 'Gina Putri', 'nis' => '302'],
    ],
];
@endphp



<div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-white to-blue-100 py-10 px-2 md:px-0">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1 tracking-tight">Absensi Siswa</h1>
                <p class="text-base text-gray-500">Kelola kehadiran siswa harian dengan mudah dan visual yang fun.</p>
            </div>
            <div class="flex gap-2">
                <button class="rounded-full bg-white shadow px-4 py-2 text-blue-600 font-bold border border-blue-100 hover:bg-blue-50 transition"><i class="fa fa-question-circle mr-2"></i>Bantuan</button>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white/90 shadow-xl rounded-2xl p-6 mb-8 border border-blue-100 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 w-full">
                <label class="block text-gray-700 font-semibold mb-1" for="kelasSelect">Kelas</label>
                <select id="kelasSelect" class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 w-full">
                <label class="block text-gray-700 font-semibold mb-1" for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
            </div>
            <div class="flex items-end w-full md:w-auto">
                <button onclick="loadSiswa()" class="w-full md:w-auto bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:scale-105 hover:bg-blue-800 transition-all duration-200">
                    <i class="fa fa-search mr-2"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Statistik dengan icon dan efek glass -->
        <div id="statistik" class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 hidden">
            <div class="flex flex-col items-center bg-white/80 border-2 border-green-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-green-400 text-2xl"><i class="fa fa-user-check"></i></span>
                <span class="text-3xl font-extrabold text-green-700 mb-1" id="statHadir">0</span>
                <span class="font-semibold text-green-700 text-lg">Hadir</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-yellow-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-yellow-400 text-2xl"><i class="fa fa-user-clock"></i></span>
                <span class="text-3xl font-extrabold text-yellow-700 mb-1" id="statIzin">0</span>
                <span class="font-semibold text-yellow-700 text-lg">Izin</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-blue-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-blue-400 text-2xl"><i class="fa fa-user-md"></i></span>
                <span class="text-3xl font-extrabold text-blue-700 mb-1" id="statSakit">0</span>
                <span class="font-semibold text-blue-700 text-lg">Sakit</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-red-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-red-400 text-2xl"><i class="fa fa-user-times"></i></span>
                <span class="text-3xl font-extrabold text-red-700 mb-1" id="statAlpha">0</span>
                <span class="font-semibold text-red-700 text-lg">Alpha</span>
            </div>
        </div>

        <!-- Tabel Absensi dengan avatar dan badge -->
        <div id="absensiTable" class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl p-0 md:p-8 hidden animate-fade-in overflow-x-auto">
            <table class="min-w-full text-base mb-8">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-slate-100 text-blue-900">
                        <th class="px-5 py-3 text-left font-bold rounded-tl-xl">NIS</th>
                        <th class="px-5 py-3 text-left font-bold">Nama Siswa</th>
                        <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
            <div class="flex justify-end mt-6">
                <button class="bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:scale-105 hover:bg-blue-800 transition-all duration-200">
                    <i class="fa fa-save mr-2"></i> Simpan Absensi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.7s cubic-bezier(.4,0,.2,1) both;
}
</style>

<script>
const siswaData = @json($siswa);

function loadSiswa() {
    const kelas = document.getElementById('kelasSelect').value;
    const table = document.getElementById('absensiTable');
    const body = document.getElementById('tableBody');

    if (!kelas) {
        alert('Pilih kelas terlebih dahulu');
        return;
    }

    body.innerHTML = '';
    siswaData[kelas].forEach((s, i) => {
        // Avatar inisial
        const inisial = s.nama.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
        body.innerHTML += `
            <tr class="border-b hover:bg-blue-50 transition">
                <td class="px-5 py-3 font-semibold text-blue-900">${s.nis}</td>
                <td class="px-5 py-3 flex items-center gap-3">
                    <span class='w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shadow'>${inisial}</span>
                    <span>${s.nama}</span>
                </td>
                <td class="px-5 py-3 text-center">
                    <select onchange="updateStat()" class="px-4 py-2 border-2 rounded-xl status font-semibold focus:ring-2 focus:ring-blue-200">
                        <option value="Hadir">✅ Hadir</option>
                        <option value="Izin">🟡 Izin</option>
                        <option value="Sakit">🔵 Sakit</option>
                        <option value="Alpha">❌ Alpha</option>
                    </select>
                </td>
            </tr>
        `;
    });

    table.classList.remove('hidden');
    document.getElementById('statistik').classList.remove('hidden');
    updateStat();
}

function updateStat() {
    let hadir = 0, izin = 0, sakit = 0, alpha = 0;
    document.querySelectorAll('.status').forEach(s => {
        if (s.value === 'Hadir') hadir++;
        if (s.value === 'Izin') izin++;
        if (s.value === 'Sakit') sakit++;
        if (s.value === 'Alpha') alpha++;
    });

    document.getElementById('statHadir').innerText = hadir;
    document.getElementById('statIzin').innerText = izin;
    document.getElementById('statSakit').innerText = sakit;
    document.getElementById('statAlpha').innerText = alpha;
}
</script>
@endsection
