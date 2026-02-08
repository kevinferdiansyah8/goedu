@extends('layouts.admin')

@section('title', 'Laporan PPDB')

@section('content')
@php
$ppdb = [
    [
        'no_daftar' => 'PPDB001',
        'nama' => 'Ahmad Fauzi',
        'jurusan' => 'RPL',
        'jalur' => 'Zonasi',
        'tanggal' => '2025-06-01',
        'status' => 'Lulus',
    ],
    [
        'no_daftar' => 'PPDB002',
        'nama' => 'Siti Aminah',
        'jurusan' => 'TKJ',
        'jalur' => 'Prestasi',
        'tanggal' => '2025-06-03',
        'status' => 'Diverifikasi',
    ],
    [
        'no_daftar' => 'PPDB003',
        'nama' => 'Budi Santoso',
        'jurusan' => 'AKL',
        'jalur' => 'Zonasi',
        'tanggal' => '2025-06-05',
        'status' => 'Menunggu',
    ],
    [
        'no_daftar' => 'PPDB004',
        'nama' => 'Dewi Lestari',
        'jurusan' => 'RPL',
        'jalur' => 'Afirmasi',
        'tanggal' => '2025-06-07',
        'status' => 'Tidak Lulus',
    ],
];

$totalPendaftar = count($ppdb);
$lulus = collect($ppdb)->where('status', 'Lulus')->count();
$diverifikasi = collect($ppdb)->where('status', 'Diverifikasi')->count();
$menunggu = collect($ppdb)->where('status', 'Menunggu')->count();
@endphp

<div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

    <!-- HEADER -->
    <div class="flex items-center gap-5 mb-2">
        <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 shadow-xl">
            <i data-lucide="users" class="w-9 h-9 text-white"></i>
        </span>
        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan PPDB</h1>
            <p class="text-gray-400 text-xl">Rekap data pendaftar PPDB berdasarkan status, jurusan, dan jalur</p>
        </div>
    </div>

    <!-- FILTER & EXPORT -->
    <div class="bg-white border border-blue-200 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow-lg">
        <div class="flex flex-wrap gap-3">
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="">Semua Jurusan</option>
                <option>RPL</option>
                <option>TKJ</option>
                <option>AKL</option>
            </select>
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="">Semua Jalur</option>
                <option>Zonasi</option>
                <option>Prestasi</option>
                <option>Afirmasi</option>
            </select>
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="">Semua Status</option>
                <option>Menunggu</option>
                <option>Diverifikasi</option>
                <option>Lulus</option>
                <option>Tidak Lulus</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button class="px-5 py-2 rounded-xl border font-bold hover:bg-gray-50 transition">Export Excel</button>
            <button class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Export PDF</button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div class="bg-gradient-to-br from-blue-100 to-blue-50 border border-blue-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Pendaftar</div>
            <div class="text-4xl font-extrabold text-blue-700 flex items-center gap-3"><i data-lucide="user-plus" class="w-7 h-7"></i>{{ $totalPendaftar }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-50 border border-green-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Lulus</div>
            <div class="text-4xl font-extrabold text-green-700 flex items-center gap-3"><i data-lucide="check-circle" class="w-7 h-7"></i>{{ $lulus }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 border border-yellow-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Diverifikasi</div>
            <div class="text-4xl font-extrabold text-yellow-700 flex items-center gap-3"><i data-lucide="badge-check" class="w-7 h-7"></i>{{ $diverifikasi }}</div>
        </div>
        <div class="bg-gradient-to-br from-gray-200 to-gray-50 border border-gray-300 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Menunggu</div>
            <div class="text-4xl font-extrabold text-gray-700 flex items-center gap-3"><i data-lucide="clock" class="w-7 h-7"></i>{{ $menunggu }}</div>
        </div>
    </div>

    <!-- TABEL PPDB -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">No Daftar</th>
                    <th class="px-6 py-4 text-left font-bold">Nama</th>
                    <th class="px-6 py-4 text-left font-bold">Jurusan</th>
                    <th class="px-6 py-4 text-left font-bold">Jalur</th>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-center font-bold">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ppdb as $p)
                <tr class="border-t hover:bg-blue-50 transition group">
                    <td class="px-6 py-4 font-semibold">{{ $p['no_daftar'] }}</td>
                    <td class="px-6 py-4">{{ $p['nama'] }}</td>
                    <td class="px-6 py-4">{{ $p['jurusan'] }}</td>
                    <td class="px-6 py-4">{{ $p['jalur'] }}</td>
                    <td class="px-6 py-4">{{ $p['tanggal'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($p['status'] === 'Lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"><i data-lucide='check-circle' class='w-4 h-4'></i> Lulus</span>
                        @elseif($p['status'] === 'Diverifikasi')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"><i data-lucide='badge-check' class='w-4 h-4'></i> Diverifikasi</span>
                        @elseif($p['status'] === 'Menunggu')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold"><i data-lucide='clock' class='w-4 h-4'></i> Menunggu</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold"><i data-lucide='x-circle' class='w-4 h-4'></i> Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
