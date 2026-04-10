@extends('layouts.sidebar-keuangan')

@section('title', 'Pembayaran PPDB')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Pembayaran PPDB</h1>
            <p class="text-secondary text-sm mt-1">Daftar pembayaran pendaftaran peserta didik baru</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-3 items-center">

        <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
            <option>Semua Status</option>
            <option>Lunas</option>
            <option>Menunggu Verifikasi</option>
            <option>Belum Bayar</option>
        </select>
        <div class="relative flex-1 min-w-[200px]">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary"></i>
            <input type="text" placeholder="Cari no pendaftaran / nama..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-border overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-border">
                        <th class="text-left px-6 py-4 font-semibold text-secondary">No Pendaftaran</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Nama</th>

                        <th class="text-right px-6 py-4 font-semibold text-secondary">Nominal</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Tanggal</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Status</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran as $p)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-foreground font-mono font-medium text-sm">{{ $p['no_daftar'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $p['nama'] }}</td>

                        <td class="px-6 py-4 text-foreground font-semibold text-right">Rp {{ number_format($p['nominal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $p['tanggal'] }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($p['status'] === 'Lunas')
                                <span class="inline-flex px-3 py-1 rounded-full bg-success-light text-success-dark text-xs font-semibold">Lunas</span>
                            @elseif($p['status'] === 'Menunggu Verifikasi')
                                <span class="inline-flex px-3 py-1 rounded-full bg-warning-light text-warning-dark text-xs font-semibold">Menunggu</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-error-light text-error-dark text-xs font-semibold">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="size-8 flex items-center justify-center rounded-lg hover:bg-primary/10 transition-colors mx-auto" title="Detail">
                                <i data-lucide="eye" class="size-4 text-primary"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan 1-6 dari 6 data</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">&laquo; Prev</button>
                <button class="px-3 py-1.5 rounded-lg text-sm bg-primary text-white font-medium">1</button>
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">Next &raquo;</button>
            </div>
        </div>
    </div>
</div>
@endsection
