@extends('layouts.sidebar-keuangan')

@section('title', 'Rekap Keuangan PPDB')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Rekap Keuangan PPDB</h1>
            <p class="text-secondary text-sm mt-1">Rekap penerimaan keuangan dari PPDB tahun ajaran 2026/2027</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak</span>
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center"><i data-lucide="users" class="size-6 text-primary"></i></div>
                <p class="font-medium text-secondary text-sm">Total Pendaftar</p>
            </div>
            <p class="font-bold text-[32px] leading-10">{{ $rekap['total_pendaftar'] }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="size-6 text-success"></i></div>
                <p class="font-medium text-secondary text-sm">Sudah Lunas</p>
            </div>
            <p class="font-bold text-[32px] leading-10 text-success">{{ $rekap['total_lunas'] }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-error/10 rounded-xl flex items-center justify-center"><i data-lucide="x-circle" class="size-6 text-error"></i></div>
                <p class="font-medium text-secondary text-sm">Belum Bayar</p>
            </div>
            <p class="font-bold text-[32px] leading-10 text-error">{{ $rekap['total_belum_bayar'] }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center"><i data-lucide="trending-up" class="size-6 text-success"></i></div>
                <p class="font-medium text-secondary text-sm">Total Pemasukan</p>
            </div>
            <p class="font-bold text-xl leading-8 text-success">Rp {{ number_format($rekap['total_pemasukan'], 0, ',', '.') }}</p>
        </div>
    </div>

</div>
@endsection
