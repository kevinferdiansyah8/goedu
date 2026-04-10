@extends('layouts.sidebar-keuangan')

@section('title', 'Tagihan SPP Siswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Tagihan SPP Siswa</h1>
            <p class="text-secondary text-sm mt-1">Kelola tagihan SPP per bulan untuk semua siswa</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-primary-hover transition-all duration-200 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Buat Tagihan</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap gap-3 items-center">
        <div class="relative">
            <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
                <option>Semua Kelas</option>
                <option>X-A</option>
                <option>X-B</option>
                <option>XI-A</option>
                <option>XI-B</option>
                <option>XII-A</option>
                <option>XII-B</option>
            </select>
        </div>
        <div class="relative">
            <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
                <option>April 2026</option>
                <option>Maret 2026</option>
                <option>Februari 2026</option>
                <option>Januari 2026</option>
            </select>
        </div>
        <div class="relative">
            <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
                <option>Semua Status</option>
                <option>Lunas</option>
                <option>Belum Bayar</option>
                <option>Cicilan</option>
            </select>
        </div>
        <div class="relative flex-1 min-w-[200px]">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary"></i>
            <input type="text" placeholder="Cari nama siswa..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-success/10 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="size-5 text-success"></i></div>
            <div><p class="text-xs text-secondary">Lunas</p><p class="font-bold text-lg text-success">4 siswa</p></div>
        </div>
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-error/10 rounded-xl flex items-center justify-center"><i data-lucide="x-circle" class="size-5 text-error"></i></div>
            <div><p class="text-xs text-secondary">Belum Bayar</p><p class="font-bold text-lg text-error">4 siswa</p></div>
        </div>
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-warning/10 rounded-xl flex items-center justify-center"><i data-lucide="clock" class="size-5 text-warning-dark"></i></div>
            <div><p class="text-xs text-secondary">Cicilan</p><p class="font-bold text-lg text-warning-dark">2 siswa</p></div>
        </div>
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-border overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-border">
                        <th class="text-left px-6 py-4 font-semibold text-secondary">No</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">NIS</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Nama Siswa</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Kelas</th>
                        <th class="text-left px-6 py-4 font-semibold text-secondary">Bulan</th>
                        <th class="text-right px-6 py-4 font-semibold text-secondary">Nominal</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Status</th>
                        <th class="text-center px-6 py-4 font-semibold text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $t)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-foreground">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $t['nis'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $t['nama'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $t['kelas'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $t['bulan'] }}</td>
                        <td class="px-6 py-4 text-foreground font-semibold text-right">Rp {{ number_format($t['nominal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($t['status'] === 'Lunas')
                                <span class="inline-flex px-3 py-1 rounded-full bg-success-light text-success-dark text-xs font-semibold">Lunas</span>
                            @elseif($t['status'] === 'Cicilan')
                                <span class="inline-flex px-3 py-1 rounded-full bg-warning-light text-warning-dark text-xs font-semibold">Cicilan</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-error-light text-error-dark text-xs font-semibold">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="size-8 flex items-center justify-center rounded-lg hover:bg-primary/10 transition-colors" title="Detail">
                                    <i data-lucide="eye" class="size-4 text-primary"></i>
                                </button>
                                <button class="size-8 flex items-center justify-center rounded-lg hover:bg-success/10 transition-colors" title="Bayar">
                                    <i data-lucide="credit-card" class="size-4 text-success"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan 1-10 dari 10 data</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">&laquo; Prev</button>
                <button class="px-3 py-1.5 rounded-lg text-sm bg-primary text-white font-medium">1</button>
                <button class="px-3 py-1.5 rounded-lg text-sm text-secondary hover:bg-gray-100 transition-colors">Next &raquo;</button>
            </div>
        </div>
    </div>
</div>
@endsection
