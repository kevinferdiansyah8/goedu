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
    <form method="GET" action="{{ route('keuangan.pembayaran.riwayat') }}" class="flex flex-wrap gap-3 items-center">
        <div class="relative flex-1 min-w-[240px]">
            <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa / NIS / Keterangan..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
            Cari Transaksi
        </button>
        @if(request('search'))
            <a href="{{ route('keuangan.pembayaran.riwayat') }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-semibold transition">Reset</a>
        @endif
    </form>

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
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $r)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-secondary">{{ $r['tanggal'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $r['nis'] }}</td>
                        <td class="px-6 py-4 text-foreground font-bold">{{ $r['nama'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $r['kelas'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $r['bulan'] }}</td>
                        <td class="px-6 py-4 text-foreground font-bold text-right text-blue-700">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if(str_contains(strtolower($r['metode']), 'mandiri') || str_contains(strtolower($r['metode']), 'transfer'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold">
                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i> Mandiri (123456789)
                                </span>
                            @elseif(str_contains(strtolower($r['metode']), 'langsung') || str_contains(strtolower($r['metode']), 'tunai'))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                                    <i data-lucide="banknote" class="w-3.5 h-3.5"></i> Pembayaran Langsung
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 text-xs font-semibold">
                                    <i data-lucide="credit-card" class="w-3.5 h-3.5"></i> {{ $r['metode'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($r['status'] === 'Terverifikasi')
                                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">Terverifikasi</span>
                            @elseif($r['status'] === 'Pending')
                                <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Menunggu</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">{{ $r['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                            Belum ada riwayat transaksi pembayaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan {{ count($riwayat) }} transaksi</p>
        </div>
    </div>
</div>
@endsection
