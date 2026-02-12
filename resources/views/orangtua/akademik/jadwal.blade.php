@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
        <p class="text-gray-600">Jadwal kegiatan belajar mengajar minggu ini.</p>
    </div>

    <!-- Day Tabs (Visual only for now) -->
    <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium shadow-sm whitespace-nowrap">Senin</button>
        <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg font-medium whitespace-nowrap">Selasa</button>
        <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg font-medium whitespace-nowrap">Rabu</button>
        <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg font-medium whitespace-nowrap">Kamis</button>
        <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg font-medium whitespace-nowrap">Jumat</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-semibold text-gray-800">Senin</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white text-gray-600 font-medium text-sm border-b border-gray-100">
                    <tr>
                        <th class="p-4 w-32">Jam</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru</th>
                        <th class="p-4">Ruang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-mono">07:00 - 07:45</td>
                        <td class="p-4 font-medium text-gray-800">Upacara Bendera</td>
                         <td class="p-4 text-gray-600">-</td>
                        <td class="p-4 text-gray-600">Lapangan</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-mono">07:45 - 09:15</td>
                        <td class="p-4 font-medium text-gray-800">Matematika</td>
                         <td class="p-4 text-gray-600">Pak Bambang</td>
                        <td class="p-4 text-gray-600">X-IPA 1</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors bg-orange-50">
                        <td class="p-4 text-gray-500 font-mono">09:15 - 09:30</td>
                        <td class="p-4 font-medium text-orange-800">Istirahat</td>
                         <td class="p-4 text-gray-600">-</td>
                        <td class="p-4 text-gray-600">-</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-mono">09:30 - 11:00</td>
                        <td class="p-4 font-medium text-gray-800">Bahasa Indonesia</td>
                         <td class="p-4 text-gray-600">Bu Ani</td>
                        <td class="p-4 text-gray-600">X-IPA 1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
