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
            <button onclick="document.getElementById('modalBuatTagihan').classList.remove('hidden')" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition-all duration-200 cursor-pointer shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Buat Tagihan</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('keuangan.pembayaran.tagihan') }}" class="flex flex-wrap gap-3 items-center">
        <div class="relative">
            <select name="kelas" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition cursor-pointer">
                <option value="">Semua Kelas</option>
                @foreach($availableClasses as $c)
                    <option value="{{ $c }}" {{ request('kelas') == $c ? 'selected' : '' }}>Kelas {{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <select name="bulan" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition cursor-pointer">
                <option value="">Semua Bulan</option>
                @foreach($availableMonths as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <select name="status" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="Belum Bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="Cicilan" {{ request('status') == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
            </select>
        </div>
        <div class="relative flex-1 min-w-[200px]">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa / NIS..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
            Cari
        </button>
        @if(request()->anyFilled(['kelas', 'bulan', 'status', 'search']))
            <a href="{{ route('keuangan.pembayaran.tagihan') }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-semibold transition">Reset</a>
        @endif
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-success/10 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="size-5 text-success"></i></div>
            <div><p class="text-xs text-secondary">Lunas</p><p class="font-bold text-lg text-success">{{ $totalLunas }} siswa</p></div>
        </div>
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-error/10 rounded-xl flex items-center justify-center"><i data-lucide="x-circle" class="size-5 text-error"></i></div>
            <div><p class="text-xs text-secondary">Belum Bayar</p><p class="font-bold text-lg text-error">{{ $totalBelumBayar }} siswa</p></div>
        </div>
        <div class="flex items-center gap-3 rounded-2xl border border-border p-4 bg-white">
            <div class="size-10 bg-warning/10 rounded-xl flex items-center justify-center"><i data-lucide="clock" class="size-5 text-warning-dark"></i></div>
            <div><p class="text-xs text-secondary">Cicilan</p><p class="font-bold text-lg text-warning-dark">{{ $totalCicilan }} siswa</p></div>
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
                <tbody class="divide-y divide-gray-100">
                    @forelse($tagihan as $t)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-foreground">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $t['nis'] }}</td>
                        <td class="px-6 py-4 text-foreground font-bold">{{ $t['nama'] }}</td>
                        <td class="px-6 py-4 text-secondary">Kelas {{ $t['kelas'] }}</td>
                        <td class="px-6 py-4 text-secondary">{{ $t['bulan'] }}</td>
                        <td class="px-6 py-4 text-foreground font-bold text-right text-blue-700">Rp {{ number_format($t['nominal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($t['status'] === 'Lunas')
                                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">Lunas</span>
                            @elseif($t['status'] === 'Cicilan')
                                <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Cicilan</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="size-8 flex items-center justify-center rounded-lg hover:bg-blue-50 transition-colors" title="Detail">
                                    <i data-lucide="eye" class="size-4 text-blue-600"></i>
                                </button>
                                <button class="size-8 flex items-center justify-center rounded-lg hover:bg-green-50 transition-colors" title="Bayar">
                                    <i data-lucide="credit-card" class="size-4 text-green-600"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                            Tidak ada data tagihan SPP yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Counter -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan {{ count($tagihan) }} data tagihan</p>
        </div>
    </div>
</div>

<!-- Modal Buat Tagihan Baru -->
<div id="modalBuatTagihan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
            <h3 class="font-bold text-lg text-foreground">Terbitkan Tagihan SPP Bulan Baru</h3>
            <button onclick="document.getElementById('modalBuatTagihan').classList.add('hidden')" class="text-secondary hover:text-foreground">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('keuangan.pembayaran.tagihan.generate') }}" method="POST">
            @csrf
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Pilih Bulan & Tahun Tagihan</label>
                    <input type="text" name="bulan" required placeholder="Contoh: September 2026, Oktober 2026" value="September 2026" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                    <p class="text-[11px] text-gray-400 mt-1">Sistem juga otomatis membuat tagihan saat pergantian bulan berjalan.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Nominal SPP per Siswa (Rp)</label>
                    <input type="number" name="nominal" required value="350000" min="10000" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-border bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalBuatTagihan').classList.add('hidden')" class="px-5 py-2.5 rounded-xl font-medium text-secondary hover:text-foreground transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors shadow-sm cursor-pointer">Terbitkan Tagihan</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-in slide-in-from-bottom-8 z-50">
    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@endsection
