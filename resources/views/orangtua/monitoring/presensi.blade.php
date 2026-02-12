@extends('layouts.admin')

@section('title', 'Ringkasan Kehadiran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Kehadiran</h1>
        <p class="text-gray-600">Laporan kehadiran siswa semester ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 mb-1">Hadir</div>
            <div class="text-2xl font-bold text-green-600">85%</div>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 mb-1">Sakit</div>
            <div class="text-2xl font-bold text-blue-600">5%</div>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 mb-1">Izin</div>
            <div class="text-2xl font-bold text-yellow-600">3%</div>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 mb-1">Alpha</div>
            <div class="text-2xl font-bold text-red-600">7%</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Riwayat Kehadiran Bulan Ini</h3>
             <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- Dummy Data -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">12 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                        <td class="p-4 text-gray-500">-</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">11 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                        <td class="p-4 text-gray-500">-</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">10 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Sakit</span></td>
                        <td class="p-4 text-gray-500">Demam</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">09 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                        <td class="p-4 text-gray-500">-</td>
                    </tr>
                      <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">08 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                        <td class="p-4 text-gray-500">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
