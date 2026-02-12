@extends('layouts.admin')

@section('title', 'Tagihan SPP')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tagihan SPP</h1>
        <p class="text-gray-600">Daftar tagihan pembayaran sekolah yang belum lunas.</p>
    </div>

    <!-- Active Bill Card -->
    <div class="bg-white rounded-xl shadow-lg border-l-4 border-red-500 overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                     <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold mb-2 inline-block">BELUM LUNAS</span>
                    <h3 class="text-xl font-bold text-gray-800">SPP Bulan Februari 2024</h3>
                    <p class="text-gray-500 mt-1">Jatuh Tempo: 10 Februari 2024</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Total Tagihan</p>
                    <h2 class="text-3xl font-bold text-gray-800">Rp 500.000</h2>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                 <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 font-medium text-sm">Detail Tagihan</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-md shadow-blue-600/20 text-sm">Bayar Sekarang</button>
            </div>
        </div>
    </div>

     <!-- Upcoming Bills (Dummy) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50">
             <h3 class="font-semibold text-gray-800">Tagihan Mendatang</h3>
        </div>
        <div class="p-6 text-center text-gray-500 py-12">
            <i data-lucide="check-circle" class="w-12 h-12 mx-auto text-green-200 mb-3"></i>
            <p>Tidak ada tagihan mendatang lainnya.</p>
        </div>
    </div>
</div>
@endsection
