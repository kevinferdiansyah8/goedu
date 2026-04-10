@extends('layouts.sidebar-keuangan')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Riwayat Pembayaran</h1>
            <p class="text-secondary text-sm mt-1">Daftar riwayat transaksi pembayaran SPP siswa</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export Excel</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak</span>
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-3 items-center">
        <div class="relative">
            <input type="date" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition" value="2026-04-01">
        </div>
        <span class="text-secondary">s/d</span>
        <div class="relative">
            <input type="date" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition" value="2026-04-07">
        </div>
        <div class="relative flex-1 min-w-[200px]">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary"></i>
            <input type="text" placeholder="Cari nama siswa..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-border overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-border">
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Tanggal</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">NIS</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Nama Siswa</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Kelas</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Bulan</th>
                        <th class="text-right px-6 py-4 font-semibold text-secondary">Nominal</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Metode</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $r)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-secondary">{{ $r['tanggal'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $r['nis'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $r['nama'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $r['kelas'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $r['bulan'] }}</td>
                        <td class="px-6 py-4 text-foreground font-semibold text-right">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($r['metode'] === 'Transfer Bank')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-info-light text-info-dark text-xs font-semibold">
                                    <i data-lucide="building-2" class="size-3"></i> Transfer
                                </span>
                            @elseif($r['metode'] === 'QRIS')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold">
                                    <i data-lucide="qr-code" class="size-3"></i> QRIS
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                    <i data-lucide="banknote" class="size-3"></i> Tunai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($r['status'] === 'Terverifikasi')
                                <span class="inline-flex px-3 py-1 rounded-full bg-success-light text-success-dark text-xs font-semibold">Terverifikasi</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-warning-light text-warning-dark text-xs font-semibold">Cicilan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan 1-6 dari 6 transaksi</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">&laquo; Prev</button>
                <button class="px-3 py-1.5 rounded-lg text-sm bg-primary text-white font-medium">1</button>
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">Next &raquo;</button>
            </div>
        </div>
    </div>
</div>
@endsection
