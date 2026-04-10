@extends('layouts.sidebar-keuangan')

@section('title', 'Biaya Pendaftaran PPDB')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Biaya Pendaftaran PPDB</h1>
            <p class="text-secondary text-sm mt-1">Pengaturan biaya pendaftaran peserta didik baru</p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-primary-hover transition-all duration-200 cursor-pointer w-fit">
            <i data-lucide="edit" class="w-4 h-4"></i>
            <span>Edit Biaya</span>
        </button>
    </div>

    <!-- Biaya Card -->
    <div class="max-w-3xl mx-auto">
        <div class="rounded-2xl border-2 border-blue-200 bg-white overflow-hidden hover:shadow-xl transition-all duration-300">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="relative z-10">
                    <div class="size-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i data-lucide="wallet" class="size-8 text-white"></i>
                    </div>
                    <p class="text-blue-100 text-sm font-medium mb-1 uppercase tracking-wider">Rincian Pembayaran</p>
                    <h2 class="text-3xl font-extrabold text-white">Biaya PPDB 2025/2026</h2>
                </div>
            </div>
            <!-- Body -->
            <div class="px-8 py-8 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-dashed border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><i data-lucide="file-text" class="w-4 h-4"></i></div>
                        <span class="text-gray-600 font-medium">Biaya Formulir</span>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">Rp {{ number_format($biaya['biaya_formulir'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-dashed border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><i data-lucide="clipboard-check" class="w-4 h-4"></i></div>
                        <span class="text-gray-600 font-medium">Daftar Ulang</span>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">Rp {{ number_format($biaya['biaya_daftar_ulang'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-dashed border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><i data-lucide="building" class="w-4 h-4"></i></div>
                        <span class="text-gray-600 font-medium">Uang Gedung</span>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">Rp {{ number_format($biaya['uang_gedung'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-dashed border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><i data-lucide="shirt" class="w-4 h-4"></i></div>
                        <span class="text-gray-600 font-medium">Seragam</span>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">Rp {{ number_format($biaya['seragam'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between pt-6 mt-2">
                    <span class="font-extrabold text-blue-800 text-xl uppercase tracking-wide">Total Biaya</span>
                    <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">
                        <span class="font-bold text-2xl text-blue-700">Rp {{ number_format($biaya['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="p-4 bg-info-light rounded-2xl border-l-4 border-info">
        <div class="flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-info-dark flex-shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-foreground text-sm font-medium">Catatan</h4>
                <p class="text-gray-600 text-xs mt-1">Biaya pendaftaran dapat disesuaikan setiap tahun ajaran. Perubahan biaya hanya berlaku untuk pendaftar baru.</p>
            </div>
        </div>
    </div>
</div>
@endsection
