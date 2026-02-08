@extends('layouts.admin')

@section('title', 'Laporan Akademik')

@section('content')
@php
$semester = request('semester', 'Ganjil');
$kelasAktif = request('kelas', 'X RPL 1');

$kelasList = ['X RPL 1', 'XI RPL 2', 'XII AKL 1'];
$mapelList = ['Matematika', 'Pemrograman Dasar', 'Basis Data'];

$laporan = [
    [
        'nama' => 'Andi Pratama',
        'kelas' => 'X RPL 1',
        'nilai' => [
            'Matematika' => 82,
            'Pemrograman Dasar' => 88,
            'Basis Data' => 85,
        ]
    ],
    [
        'nama' => 'Budi Santoso',
        'kelas' => 'X RPL 1',
        'nilai' => [
            'Matematika' => 70,
            'Pemrograman Dasar' => 75,
            'Basis Data' => 78,
        ]
    ],
    [
        'nama' => 'Citra Lestari',
        'kelas' => 'X RPL 1',
        'nilai' => [
            'Matematika' => 90,
            'Pemrograman Dasar' => 92,
            'Basis Data' => 89,
        ]
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-2">
        <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-500 shadow-lg">
            <i data-lucide="book-open" class="w-8 h-8 text-white"></i>
        </span>
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan Akademik</h1>
            <p class="text-gray-400 text-lg">Rekap nilai siswa per kelas dan semester</p>
        </div>
    </div>

    <!-- FILTER -->
    <div class="bg-white border border-blue-100 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow">
        <div class="flex flex-wrap gap-3">
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option {{ $semester=='Ganjil'?'selected':'' }}>Ganjil</option>
                <option {{ $semester=='Genap'?'selected':'' }}>Genap</option>
            </select>
            <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                @foreach($kelasList as $k)
                    <option {{ $kelasAktif==$k?'selected':'' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button class="px-5 py-2 rounded-xl border font-bold hover:bg-gray-50 transition">Export Excel</button>
            <button class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Export PDF</button>
        </div>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Jumlah Siswa</div>
            <div class="text-3xl font-extrabold text-blue-700 flex items-center gap-2"><i data-lucide="users" class="w-6 h-6"></i>{{ count($laporan) }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Rata-rata Kelas</div>
            <div class="text-3xl font-extrabold text-blue-700 flex items-center gap-2"><i data-lucide="bar-chart-3" class="w-6 h-6"></i>82.5</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Nilai Tertinggi</div>
            <div class="text-3xl font-extrabold text-yellow-700 flex items-center gap-2"><i data-lucide="star" class="w-6 h-6"></i>92</div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Perlu Remedial</div>
            <div class="text-3xl font-extrabold text-red-700 flex items-center gap-2"><i data-lucide="alert-triangle" class="w-6 h-6"></i>1</div>
        </div>
    </div>

    <!-- TABLE NILAI -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto">
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Nama Siswa</th>
                    @foreach($mapelList as $m)
                        <th class="px-6 py-4 text-center font-bold">{{ $m }}</th>
                    @endforeach
                    <th class="px-6 py-4 text-center font-bold">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $s)
                    @php
                        $rata = collect($s['nilai'])->avg();
                    @endphp
                    <tr class="border-t hover:bg-blue-50 transition group">
                        <td class="px-6 py-4 font-semibold flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold group-hover:bg-blue-200">{{ strtoupper(substr($s['nama'],0,1)) }}</span>
                            {{ $s['nama'] }}
                        </td>
                        @foreach($mapelList as $m)
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-blue-700 font-bold">{{ $s['nilai'][$m] }}</span>
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-center font-bold">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700">{{ number_format($rata,1) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
