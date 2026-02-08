@extends('layouts.admin')

@section('title', 'PPDB - Verifikasi & Seleksi')

@section('content')
@php
$status = 'diverifikasi'; // ganti: menunggu | diverifikasi | perbaikan | lulus | tidak_lulus

$pendaftar = [
    'no' => 'PPDB-2024-0021',
    'nama' => 'Siti Aminah',
    'jurusan' => 'Teknik Komputer & Jaringan',
    'jalur' => 'Prestasi'
];

$berkas = [
    ['nama' => 'Kartu Keluarga', 'status' => 'valid'],
    ['nama' => 'Akta Kelahiran', 'status' => 'valid'],
    ['nama' => 'Ijazah / SKL', 'status' => 'perbaikan'],
    ['nama' => 'Raport', 'status' => 'valid'],
];
@endphp

<div class="max-w-7xl mx-auto px-6 py-8 space-y-10">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">PPDB – Verifikasi & Seleksi</h1>
        <p class="text-gray-500 mt-1">Kelola berkas, seleksi, dan keputusan akhir pendaftar</p>
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
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['no'] }}</span>
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
        </div>
    </div>

    <!-- VERIFIKASI BERKAS MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl mb-8">
        <div class="p-6 border-b">
            <h2 class="font-bold text-lg text-blue-700">1️⃣ Verifikasi Berkas</h2>
        </div>
        <table class="w-full text-base">
            <thead class="bg-blue-50 text-blue-900">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Berkas</th>
                    <th class="px-6 py-4 text-center font-bold">Status</th>
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
                    <td class="px-6 py-4 text-center">
                        <button class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition shadow" onclick="alert('Preview berkas belum tersedia')">Lihat</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SELEKSI MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-6 mb-8 {{ $status !== 'diverifikasi' ? 'opacity-50 pointer-events-none' : '' }}">
        <h2 class="font-bold text-lg text-blue-700 mb-4">2️⃣ Seleksi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium">Nilai Seleksi</label>
                <input type="number" class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition" placeholder="0 - 100">
            </div>
            <div>
                <label class="text-sm font-medium">Catatan Seleksi</label>
                <textarea rows="3" class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition"></textarea>
            </div>
        </div>
    </div>

    <!-- KEPUTUSAN AKHIR MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-7 mb-8">
        <h2 class="text-lg font-bold mb-4 text-blue-700">3️⃣ Keputusan Akhir</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium">Status Akhir</label>
                <select class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition">
                    <option>Menunggu</option>
                    <option>Diverifikasi</option>
                    <option>Lulus</option>
                    <option>Tidak Lulus</option>
                    <option>Perlu Perbaikan</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium">Catatan untuk Pendaftar</label>
                <textarea rows="3" class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 mt-6 justify-end">
            <button class="px-6 py-2 border-2 border-blue-200 rounded-lg font-semibold bg-white hover:bg-blue-50 transition">Batal</button>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">Simpan Keputusan</button>
        </div>
    </div>

</div>
@endsection
