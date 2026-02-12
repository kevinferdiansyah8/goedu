@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pembayaran</h1>
        <p class="text-gray-600">Catatan historis pembayaran yang telah dilakukan.</p>
    </div>

    <!-- Filter -->
    <div class="flex gap-4 mb-6">
        <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border bg-white shadow-sm">
            <option>Semua Status</option>
            <option>Lunas</option>
            <option>Menunggu Konfirmasi</option>
        </select>
         <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border bg-white shadow-sm">
            <option>Tahun Ajaran 2023/2024</option>
             <option>Tahun Ajaran 2022/2023</option>
        </select>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">ID Transaksi</th>
                        <th class="p-4">Tanggal Pembayaran</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4">Metode</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-xs text-gray-500">#INV-20240105-001</td>
                        <td class="p-4 text-gray-700">05 Jan 2024</td>
                        <td class="p-4 font-medium text-gray-800">SPP Januari 2024</td>
                        <td class="p-4 text-gray-600">Transfer BCA</td>
                        <td class="p-4 font-bold text-gray-800">Rp 500.000</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span></td>
                        <td class="p-4">
                            <button class="text-blue-600 hover:text-blue-700 font-medium text-xs flex items-center gap-1">
                                <i data-lucide="printer" class="w-3 h-3"></i> Cetak Invoice
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                         <td class="p-4 font-mono text-xs text-gray-500">#INV-20231210-005</td>
                        <td class="p-4 text-gray-700">10 Des 2023</td>
                        <td class="p-4 font-medium text-gray-800">SPP Desember 2023</td>
                        <td class="p-4 text-gray-600">QRIS</td>
                        <td class="p-4 font-bold text-gray-800">Rp 500.000</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span></td>
                        <td class="p-4">
                           <button class="text-blue-600 hover:text-blue-700 font-medium text-xs flex items-center gap-1">
                                <i data-lucide="printer" class="w-3 h-3"></i> Cetak Invoice
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
