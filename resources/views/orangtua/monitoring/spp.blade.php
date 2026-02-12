@extends('layouts.admin')

@section('title', 'Status SPP')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Status SPP</h1>
        <p class="text-gray-600">Informasi pembayaran SPP siswa.</p>
    </div>

    <!-- Status Card -->
     <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Status Pembayaran Bulan Ini (Februari 2024)</h3>
                <p class="text-gray-500 text-sm mt-1">Jatuh tempo: 10 Februari 2024</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">LUNAS</span>
            </div>
        </div>
    </div>

    <!-- History Payment -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
             <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i data-lucide="history" class="w-4 h-4 text-orange-500"></i> Riwayat Pembayaran
            </h3>
            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Download Rekap</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                 <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">Bulan</th>
                        <th class="p-4">Tanggal Bayar</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Metode</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Bukti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- Item -->
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">Februari 2024</td>
                        <td class="p-4 text-gray-600">05 Feb 2024</td>
                        <td class="p-4 text-gray-800 font-semibold">Rp 500.000</td>
                        <td class="p-4 text-gray-600">Transfer Bank</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span></td>
                        <td class="p-4"><button class="text-blue-600 hover:underline text-xs">Lihat</button></td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">Januari 2024</td>
                        <td class="p-4 text-gray-600">08 Jan 2024</td>
                        <td class="p-4 text-gray-800 font-semibold">Rp 500.000</td>
                        <td class="p-4 text-gray-600">Va BCA</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span></td>
                        <td class="p-4"><button class="text-blue-600 hover:underline text-xs">Lihat</button></td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">Desember 2023</td>
                        <td class="p-4 text-gray-600">10 Des 2023</td>
                        <td class="p-4 text-gray-800 font-semibold">Rp 500.000</td>
                        <td class="p-4 text-gray-600">Transfer Bank</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span></td>
                         <td class="p-4"><button class="text-blue-600 hover:underline text-xs">Lihat</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
