@extends('layouts.admin')

@section('title', 'Rapor Siswa')

@section('content')
@php
$kelasList = ['X RPL 1', 'XI TKJ 2'];

$siswa = [
    [
        'nama' => 'Andi Wijaya',
        'kelas' => 'X RPL 1',
        'nilai' => [
            ['mapel' => 'Pemrograman Dasar', 'nilai' => 85],
            ['mapel' => 'Basis Data', 'nilai' => 78],
            ['mapel' => 'Matematika', 'nilai' => 80],
        ]
    ],
    [
        'nama' => 'Siti Aminah',
        'kelas' => 'XI TKJ 2',
        'nilai' => [
            ['mapel' => 'Basis Data', 'nilai' => 70],
            ['mapel' => 'Pemrograman Dasar', 'nilai' => 68],
            ['mapel' => 'Matematika', 'nilai' => 72],
        ]
    ],
];
@endphp


<div class="min-h-screen w-full bg-gradient-to-br from-blue-50 via-white to-blue-100 py-10 px-2 md:px-0">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight drop-shadow">Rapor Siswa</h1>
            <p class="text-lg text-gray-500">Lihat hasil belajar siswa per semester</p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-2xl p-8 mb-10 border border-blue-100 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 w-full">
                <label class="block text-gray-700 font-semibold mb-1" for="filterKelas">Kelas</label>
                <select id="filterKelas" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}">{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 w-full">
                <label class="block text-gray-700 font-semibold mb-1" for="filterSiswa">Siswa</label>
                <select id="filterSiswa" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s['nama'] }}">{{ $s['nama'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end w-full md:w-auto">
                <button onclick="tampilkanRapor()" class="w-full md:w-auto bg-gradient-to-r from-blue-600 to-blue-400 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:scale-105 hover:from-blue-700 hover:to-blue-500 transition-all duration-200">
                    <i class="fa fa-search mr-2"></i> Tampilkan Rapor
                </button>
            </div>
        </div>

        <!-- Rapor Card -->
        <div id="raporBox" class="hidden animate-fade-in bg-white/90 border border-blue-100 rounded-3xl shadow-2xl p-10 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full opacity-30 z-0"></div>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 flex items-center justify-center shadow-lg border-4 border-white">
                        <span class="text-2xl font-bold text-blue-800"><i class="fa fa-user"></i></span>
                    </div>
                    <div>
                        <h2 id="raporNama" class="text-2xl font-extrabold text-gray-900 mb-1"></h2>
                        <span id="raporKelas" class="text-blue-600 font-semibold text-md bg-blue-50 px-3 py-1 rounded-full shadow-sm"></span>
                    </div>
                </div>
                <button class="flex items-center gap-2 px-5 py-2 border-2 border-blue-200 rounded-xl bg-white hover:bg-blue-50 font-semibold text-blue-700 shadow transition-all duration-150">
                    <i class="fa fa-print"></i>
                    Cetak
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-blue-100 bg-white/80 shadow-inner">
                <table class="min-w-full text-base mb-8">
                    <thead>
                        <tr class="bg-blue-50 text-blue-800">
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Mata Pelajaran</th>
                            <th class="px-5 py-3 text-center font-bold">Nilai</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="nilaiTable"></tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mt-6">
                <div class="text-lg font-medium text-gray-700">
                    <span class="font-semibold">Rata-rata:</span>
                    <span id="rataNilai" class="font-extrabold text-blue-600 text-xl"></span>
                </div>
                <div id="statusAkhir" class="px-8 py-3 rounded-xl font-bold text-lg shadow"></div>
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
const dataSiswa = @json($siswa);

function tampilkanRapor() {
    const nama = document.getElementById('filterSiswa').value;
    const raporBox = document.getElementById('raporBox');
    const table = document.getElementById('nilaiTable');

    table.innerHTML = '';

    const siswa = dataSiswa.find(s => s.nama === nama);
    if (!siswa) return;

    document.getElementById('raporNama').textContent = siswa.nama;
    document.getElementById('raporKelas').textContent = siswa.kelas;

    let total = 0;

    siswa.nilai.forEach(n => {
        total += n.nilai;

        table.innerHTML += `
            <tr class="border-b">
                <td class="px-3 py-2">${n.mapel}</td>
                <td class="px-3 py-2 text-center font-semibold">${n.nilai}</td>
                <td class="px-3 py-2 text-center">
                    ${n.nilai >= 75
                        ? '<span class="text-green-600 font-semibold">Lulus</span>'
                        : '<span class="text-yellow-600 font-semibold">Remedial</span>'}
                </td>
            </tr>
        `;
    });

    const rata = Math.round(total / siswa.nilai.length);
    document.getElementById('rataNilai').textContent = rata;

    const status = document.getElementById('statusAkhir');
    if (rata >= 75) {
        status.textContent = 'NAIK KELAS';
        status.className = 'px-4 py-2 rounded-lg bg-green-100 text-green-700 font-semibold';
    } else {
        status.textContent = 'REMEDIAL';
        status.className = 'px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 font-semibold';
    }

    raporBox.classList.remove('hidden');
}
</script>
@endsection
