@extends('layouts.admin')

@section('title', 'Laporan Kegiatan Sekolah')

@section('content')
@php
$kegiatan = [
    [
        'nama' => 'Upacara Bendera',
        'jenis' => 'Internal',
        'kategori' => 'Akademik',
        'tanggal' => '2025-01-06',
        'penanggung_jawab' => 'Waka Kesiswaan',
        'status' => 'Selesai',
    ],
    [
        'nama' => 'Lomba Futsal Antar Kelas',
        'jenis' => 'Ekstrakurikuler',
        'kategori' => 'Non Akademik',
        'tanggal' => '2025-02-12',
        'penanggung_jawab' => 'OSIS',
        'status' => 'Selesai',
    ],
    [
        'nama' => 'Kunjungan Industri',
        'jenis' => 'Akademik',
        'kategori' => 'Akademik',
        'tanggal' => '2025-03-20',
        'penanggung_jawab' => 'Hubin',
        'status' => 'Terjadwal',
    ],
    [
        'nama' => 'Workshop Guru',
        'jenis' => 'Internal',
        'kategori' => 'Akademik',
        'tanggal' => '2025-04-05',
        'penanggung_jawab' => 'Kepala Sekolah',
        'status' => 'Dibatalkan',
    ],
];

$total = count($kegiatan);
$selesai = collect($kegiatan)->where('status', 'Selesai')->count();
$terjadwal = collect($kegiatan)->where('status', 'Terjadwal')->count();
$dibatalkan = collect($kegiatan)->where('status', 'Dibatalkan')->count();
@endphp

<div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

    <!-- HEADER -->
    <div class="flex items-center gap-5 mb-2">
        <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 shadow-xl">
            <i data-lucide="calendar-check-2" class="w-9 h-9 text-white"></i>
        </span>
        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan Kegiatan Sekolah</h1>
            <p class="text-gray-400 text-xl">Rekap dan arsip seluruh kegiatan sekolah</p>
        </div>
    </div>

    <!-- FILTER & EXPORT -->
    <div class="bg-white border border-blue-200 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow-lg">
        <div class="flex flex-wrap gap-3">
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="">Semua Jenis</option>
                <option>Akademik</option>
                <option>Non Akademik</option>
                <option>Ekstrakurikuler</option>
                <option>Internal</option>
            </select>
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="">Semua Status</option>
                <option>Terjadwal</option>
                <option>Berlangsung</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
            <input type="month" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 text-base appearance-none">
        </div>
        <div class="flex gap-2">
            <button class="px-5 py-2 rounded-xl border font-bold hover:bg-gray-50 transition">Export Excel</button>
            <button class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Export PDF</button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div class="bg-gradient-to-br from-blue-100 to-blue-50 border border-blue-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Kegiatan</div>
            <div class="text-4xl font-extrabold text-blue-700 flex items-center gap-3"><i data-lucide="list-checks" class="w-7 h-7"></i>{{ $total }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-50 border border-green-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Selesai</div>
            <div class="text-4xl font-extrabold text-green-700 flex items-center gap-3"><i data-lucide="check-circle" class="w-7 h-7"></i>{{ $selesai }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 border border-yellow-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Terjadwal</div>
            <div class="text-4xl font-extrabold text-yellow-700 flex items-center gap-3"><i data-lucide="calendar-clock" class="w-7 h-7"></i>{{ $terjadwal }}</div>
        </div>
        <div class="bg-gradient-to-br from-red-100 to-red-50 border border-red-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Dibatalkan</div>
            <div class="text-4xl font-extrabold text-red-700 flex items-center gap-3"><i data-lucide="x-circle" class="w-7 h-7"></i>{{ $dibatalkan }}</div>
        </div>
    </div>

    <!-- TABEL KEGIATAN -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Nama Kegiatan</th>
                    <th class="px-6 py-4 text-left font-bold">Jenis</th>
                    <th class="px-6 py-4 text-left font-bold">Kategori</th>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-bold">Penanggung Jawab</th>
                    <th class="px-6 py-4 text-center font-bold">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan as $k)
                <tr class="border-t hover:bg-blue-50 transition group">
                    <td class="px-6 py-4 font-semibold">{{ $k['nama'] }}</td>
                    <td class="px-6 py-4">{{ $k['jenis'] }}</td>
                    <td class="px-6 py-4">{{ $k['kategori'] }}</td>
                    <td class="px-6 py-4">{{ $k['tanggal'] }}</td>
                    <td class="px-6 py-4">{{ $k['penanggung_jawab'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($k['status'] === 'Selesai')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"><i data-lucide='check-circle' class='w-4 h-4'></i> Selesai</span>
                        @elseif($k['status'] === 'Terjadwal')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"><i data-lucide='calendar-clock' class='w-4 h-4'></i> Terjadwal</span>
                        @elseif($k['status'] === 'Dibatalkan')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold"><i data-lucide='x-circle' class='w-4 h-4'></i> Dibatalkan</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold"><i data-lucide='loader' class='w-4 h-4'></i> Berlangsung</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
