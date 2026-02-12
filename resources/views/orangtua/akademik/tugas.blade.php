@extends('layouts.admin')

@section('title', 'Nilai Tugas & Ulangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Nilai Tugas & Ulangan</h1>
        <p class="text-gray-600">Daftar nilai tugas harian dan ulangan siswa.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Judul / Materi</th>
                        <th class="p-4">Nilai</th>
                        <th class="p-4">Komentar Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">Matematika</td>
                         <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Tugas</span></td>
                        <td class="p-4 text-gray-600">Aljabar Linear</td>
                        <td class="p-4 font-bold text-green-600">90</td>
                        <td class="p-4 text-gray-500">Pengerjaan sangat rapi.</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">Bahasa Indonesia</td>
                         <td class="p-4"><span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-md text-xs font-medium">Ulangan</span></td>
                        <td class="p-4 text-gray-600">Puisi Baru</td>
                        <td class="p-4 font-bold text-green-600">85</td>
                        <td class="p-4 text-gray-500">Perhatikan diksi.</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">IPA</td>
                         <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Tugas</span></td>
                        <td class="p-4 text-gray-600">Laporan Praktikum</td>
                        <td class="p-4 font-bold text-blue-600">88</td>
                        <td class="p-4 text-gray-500">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
