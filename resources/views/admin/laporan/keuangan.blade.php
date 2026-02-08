@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
@php
$bulan = 'September';
$tahun = 2025;

$pemasukan = [
    ['tanggal' => '2025-09-01', 'sumber' => 'PPDB', 'keterangan' => 'Biaya pendaftaran', 'jumlah' => 250000],
    ['tanggal' => '2025-09-05', 'sumber' => 'SPP', 'keterangan' => 'SPP September', 'jumlah' => 1500000],
    ['tanggal' => '2025-09-10', 'sumber' => 'Kegiatan', 'keterangan' => 'Iuran lomba', 'jumlah' => 500000],
];

$pengeluaran = [
    ['tanggal' => '2025-09-03', 'kategori' => 'ATK', 'keterangan' => 'Pembelian alat tulis', 'jumlah' => 300000],
    ['tanggal' => '2025-09-08', 'kategori' => 'Kegiatan', 'keterangan' => 'Transport lomba', 'jumlah' => 400000],
];

$totalMasuk = collect($pemasukan)->sum('jumlah');
$totalKeluar = collect($pengeluaran)->sum('jumlah');
$saldo = $totalMasuk - $totalKeluar;
@endphp

<div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

    <!-- HEADER -->
    <div class="flex items-center gap-5 mb-2">
        <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 shadow-xl">
            <i data-lucide="wallet" class="w-9 h-9 text-white"></i>
        </span>
        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan Keuangan</h1>
            <p class="text-gray-400 text-xl">Rekap pemasukan & pengeluaran sekolah secara visual dan informatif</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white border border-blue-200 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow-lg">
        <div class="flex flex-wrap gap-3">
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option>Januari</option>
                <option>Februari</option>
                <option selected>{{ $bulan }}</option>
            </select>
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option selected>{{ $tahun }}</option>
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button class="px-5 py-2 rounded-xl border font-bold hover:bg-gray-50 transition">Export Excel</button>
            <button class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Export PDF</button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gradient-to-br from-blue-100 to-blue-50 border border-blue-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Pemasukan</div>
            <div class="text-4xl font-extrabold text-blue-700 flex items-center gap-3"><i data-lucide="arrow-down-circle" class="w-8 h-8"></i>Rp {{ number_format($totalMasuk,0,',','.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-red-100 to-red-50 border border-red-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Pengeluaran</div>
            <div class="text-4xl font-extrabold text-red-700 flex items-center gap-3"><i data-lucide="arrow-up-circle" class="w-8 h-8"></i>Rp {{ number_format($totalKeluar,0,',','.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-50 border border-green-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Saldo Akhir</div>
            <div class="text-4xl font-extrabold text-green-700 flex items-center gap-3"><i data-lucide="wallet" class="w-8 h-8"></i>Rp {{ number_format($saldo,0,',','.') }}</div>
        </div>
    </div>

    <!-- CHART (PLACEHOLDER) -->
    <div class="bg-white border border-blue-100 rounded-2xl shadow-lg p-8 flex flex-col items-center">
        <div class="font-bold text-blue-700 mb-4 flex items-center gap-2 text-lg"><i data-lucide="bar-chart-3" class="w-5 h-5"></i> Grafik Keuangan Bulan Ini</div>
        <div class="w-full h-48 flex items-center justify-center text-gray-400 italic">[Grafik pemasukan & pengeluaran akan tampil di sini]</div>
    </div>

    <!-- PEMASUKAN -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <div class="p-6 border-b font-bold text-blue-700 flex items-center gap-2 text-lg">
            <i data-lucide="arrow-down-circle" class="w-5 h-5"></i> Pemasukan
        </div>
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-bold">Sumber</th>
                    <th class="px-6 py-4 text-left font-bold">Keterangan</th>
                    <th class="px-6 py-4 text-right font-bold">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemasukan as $p)
                <tr class="border-t hover:bg-blue-50 transition group">
                    <td class="px-6 py-4">{{ $p['tanggal'] }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $p['sumber'] }}</td>
                    <td class="px-6 py-4">{{ $p['keterangan'] }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold">Rp {{ number_format($p['jumlah'],0,',','.') }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PENGELUARAN -->
    <div class="bg-white border border-red-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <div class="p-6 border-b font-bold text-red-700 flex items-center gap-2 text-lg">
            <i data-lucide="arrow-up-circle" class="w-5 h-5"></i> Pengeluaran
        </div>
        <table class="min-w-full text-base">
            <thead class="bg-red-50 text-red-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-bold">Kategori</th>
                    <th class="px-6 py-4 text-left font-bold">Keterangan</th>
                    <th class="px-6 py-4 text-right font-bold">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaran as $k)
                <tr class="border-t hover:bg-red-50 transition group">
                    <td class="px-6 py-4">{{ $k['tanggal'] }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $k['kategori'] }}</td>
                    <td class="px-6 py-4">{{ $k['keterangan'] }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold">Rp {{ number_format($k['jumlah'],0,',','.') }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
