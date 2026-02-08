@extends('layouts.admin')

@section('title', 'Rekap Nilai')

@section('content')

{{-- HEADER --}}
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">Rekap Nilai Kelas</h1>
        <p class="text-gray-500">Ringkasan nilai siswa per kelas</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 border">
            <p class="text-sm text-gray-500">Rata-rata Nilai</p>
            <p class="text-2xl font-bold text-blue-600">82</p>
        </div>
        <div class="bg-white rounded-xl p-4 border">
            <p class="text-sm text-gray-500">Nilai Tertinggi</p>
            <p class="text-2xl font-bold text-green-600">95</p>
        </div>
        <div class="bg-white rounded-xl p-4 border">
            <p class="text-sm text-gray-500">Nilai Terendah</p>
            <p class="text-2xl font-bold text-red-600">65</p>
        </div>
        <div class="bg-white rounded-xl p-4 border">
            <p class="text-sm text-gray-500">Jumlah Siswa</p>
            <p class="text-2xl font-bold">32</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Siswa</th>
                    <th class="px-6 py-3 text-left">Nilai Akhir</th>
                    <th class="px-6 py-3 text-left">Predikat</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <tr>
                    <td class="px-6 py-4">Ahmad Fauzi</td>
                    <td class="px-6 py-4">88</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">A</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Budi Santoso</td>
                    <td class="px-6 py-4">72</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">C</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection