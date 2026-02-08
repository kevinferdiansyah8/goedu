@extends('layouts.admin')

@section('title', 'Verifikasi Berkas PPDB')

@section('content')
@php
$pendaftar = [
    'no_daftar' => 'PPDB002',
    'nama' => 'Siti Aminah',
    'jurusan' => 'TKJ',
    'jalur' => 'Prestasi',
];

$berkas = [
    ['nama' => 'Kartu Keluarga', 'status' => 'valid', 'catatan' => ''],
    ['nama' => 'Akta Kelahiran', 'status' => 'valid', 'catatan' => ''],
    ['nama' => 'Ijazah / SKL', 'status' => 'perbaikan', 'catatan' => 'Foto kurang jelas'],
    ['nama' => 'Raport', 'status' => 'valid', 'catatan' => ''],
    ['nama' => 'Pas Foto', 'status' => 'tidak_valid', 'catatan' => 'Background tidak sesuai'],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Verifikasi Berkas PPDB</h1>
        <p class="text-gray-500 mt-1">Periksa dan verifikasi kelengkapan berkas pendaftar</p>
    </div>

    <!-- INFO PENDAFTAR MODERN -->
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <div class="flex-1 flex items-center bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition relative">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-extrabold flex items-center justify-center text-3xl shadow-lg border-4 border-white mr-6">
                {{ collect(explode(' ', $pendaftar['nama']))->map(fn($n)=>$n[0])->join('') }}
            </div>
            <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">No Pendaftaran</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['no_daftar'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Nama</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['nama'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Jurusan</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['jurusan'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Jalur</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['jalur'] }}</span>
                </div>
            </div>
            <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 shadow">Diverifikasi</span>
        </div>
    </div>

    <!-- TABEL BERKAS MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl overflow-hidden mb-8">
        <table class="w-full text-base">
            <thead class="bg-blue-50 text-blue-900">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Berkas</th>
                    <th class="px-6 py-4 text-center font-bold">Status</th>
                    <th class="px-6 py-4 text-left font-bold">Catatan</th>
                    <th class="px-6 py-4 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($berkas as $b)
                <tr class="even:bg-blue-50/40 hover:bg-blue-100/60 transition rounded-xl">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $b['nama'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($b['status'] === 'valid')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Valid</span>
                        @elseif($b['status'] === 'perbaikan')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Perbaikan</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Tidak Valid</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <textarea class="w-full px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 text-base focus:border-blue-400 transition resize-none shadow" rows="1" placeholder="Catatan...">{{ $b['catatan'] }}</textarea>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition shadow" onclick="alert('Preview berkas belum tersedia')">Lihat</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- KEPUTUSAN AKHIR MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-7 mb-8">
        <h2 class="text-lg font-bold mb-4 text-blue-700">Keputusan Akhir PPDB</h2>
        <div class="flex flex-col md:flex-row md:items-center gap-6 mb-4">
            <div class="flex flex-wrap gap-4">
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 cursor-pointer transition">
                    <input type="radio" name="keputusan" checked>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Diverifikasi</span>
                </label>
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 cursor-pointer transition">
                    <input type="radio" name="keputusan">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Lulus</span>
                </label>
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 cursor-pointer transition">
                    <input type="radio" name="keputusan">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Tidak Lulus</span>
                </label>
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 cursor-pointer transition">
                    <input type="radio" name="keputusan">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Perbaikan</span>
                </label>
            </div>
            <textarea class="w-full px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 text-base focus:border-blue-400 transition resize-none shadow min-w-[200px]" rows="2" placeholder="Catatan akhir untuk pendaftar..."></textarea>
        </div>
        <div class="flex flex-wrap gap-4 mt-2 justify-end">
            <button class="px-5 py-2 rounded-xl font-bold shadow text-white transition-all text-base bg-blue-600 hover:bg-blue-700">Simpan</button>
            <button class="px-5 py-2 rounded-xl font-bold shadow text-gray-900 transition-all text-base bg-yellow-400 hover:bg-yellow-500">Kembalikan</button>
            <button class="px-5 py-2 rounded-xl font-bold shadow text-white transition-all text-base bg-green-600 hover:bg-green-700">Luluskan</button>
            <button class="px-5 py-2 rounded-xl font-bold shadow text-white transition-all text-base bg-red-600 hover:bg-red-700">Tolak</button>
        </div>
    </div>

</div>
@endsection
