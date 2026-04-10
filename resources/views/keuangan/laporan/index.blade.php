@extends('layouts.sidebar-keuangan')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Laporan Keuangan</h1>
            <p class="text-secondary text-sm mt-1">Ringkasan dan detail laporan keuangan sekolah</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export PDF</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                <span>Export Excel</span>
            </button>
            <button onclick="document.getElementById('modalTambahTransaksi').classList.remove('hidden')" class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-blue-600 transition-all duration-200 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Transaksi</span>
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-3 items-center">
        <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
            <option>April 2026</option>
            <option>Maret 2026</option>
            <option>Februari 2026</option>
        </select>
        <select class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-foreground bg-white focus:border-primary focus:ring-1 focus:ring-primary transition">
            <option>Semua Jenis</option>
            <option>Pemasukan</option>
            <option>Pengeluaran</option>
        </select>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center"><i data-lucide="arrow-up-circle" class="size-6 text-success"></i></div>
                <p class="font-medium text-secondary text-sm">Pemasukan Bulan Ini</p>
            </div>
            <p class="font-bold text-xl text-success">Rp {{ number_format($ringkasan['pemasukan_bulan_ini'], 0, ',', '.') }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-error/10 rounded-xl flex items-center justify-center"><i data-lucide="arrow-down-circle" class="size-6 text-error"></i></div>
                <p class="font-medium text-secondary text-sm">Pengeluaran Bulan Ini</p>
            </div>
            <p class="font-bold text-xl text-error">Rp {{ number_format($ringkasan['pengeluaran_bulan_ini'], 0, ',', '.') }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center"><i data-lucide="wallet" class="size-6 text-primary"></i></div>
                <p class="font-medium text-secondary text-sm">Saldo Bulan Ini</p>
            </div>
            <p class="font-bold text-xl text-primary">Rp {{ number_format($ringkasan['saldo'], 0, ',', '.') }}</p>
        </div>
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-info/10 rounded-xl flex items-center justify-center"><i data-lucide="bar-chart-2" class="size-6 text-info"></i></div>
                <p class="font-medium text-secondary text-sm">Total Pemasukan Tahun</p>
            </div>
            <p class="font-bold text-xl text-info">Rp {{ number_format($ringkasan['pemasukan_tahun'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="rounded-2xl border border-border overflow-hidden bg-white">
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
            <h3 class="font-bold text-lg text-foreground">Transaksi Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-border">
                        <th class="text-left px-6 py-3 font-semibold text-secondary">Tanggal</th>
                        <th class="text-left px-6 py-3 font-semibold text-secondary">Keterangan</th>
                        <th class="text-center px-6 py-3 font-semibold text-secondary">Jenis</th>
                        <th class="text-right px-6 py-3 font-semibold text-secondary">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi_terbaru as $t)
                    <tr class="border-b border-border hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-secondary">{{ $t['tanggal'] }}</td>
                        <td class="px-6 py-4 text-foreground font-medium">{{ $t['keterangan'] }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($t['jenis'] === 'Masuk')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-success-light text-success-dark text-xs font-semibold">
                                    <i data-lucide="arrow-up" class="size-3"></i> Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-error-light text-error-dark text-xs font-semibold">
                                    <i data-lucide="arrow-down" class="size-3"></i> Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold {{ $t['jenis'] === 'Masuk' ? 'text-success' : 'text-error' }}">
                            {{ $t['jenis'] === 'Masuk' ? '+' : '-' }} Rp {{ number_format($t['nominal'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-secondary">Menampilkan 8 transaksi terbaru</p>
            <button class="text-sm text-primary font-semibold hover:underline cursor-pointer">Lihat Semua →</button>
        </div>
    </div>

    <!-- Info -->
    <div class="p-4 bg-info-light rounded-2xl border-l-4 border-info">
        <div class="flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-info-dark flex-shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-foreground text-sm font-medium">Informasi</h4>
                <p class="text-gray-600 text-xs mt-1">Laporan ini menampilkan data keuangan sekolah secara real-time. Untuk laporan resmi, silakan gunakan fitur Export PDF.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div id="modalTambahTransaksi" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
            <h3 class="font-bold text-lg text-foreground">Catat Transaksi Manual</h3>
            <button onclick="document.getElementById('modalTambahTransaksi').classList.add('hidden')" class="text-secondary hover:text-foreground">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('keuangan.laporan.store') }}" method="POST">
            @csrf
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Jenis Transaksi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis" value="Masuk" required class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium">Pemasukan (Masuk)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis" value="Keluar" required class="text-primary focus:ring-primary">
                            <span class="text-sm font-medium">Pengeluaran (Keluar)</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" required min="1" placeholder="Contoh: 500000" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Keterangan</label>
                    <input type="text" name="keterangan" required placeholder="Contoh: Pembelian ATK Kantor" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Metode</label>
                    <select name="metode" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                        <option value="Tunai">Tunai / Cash</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-border bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalTambahTransaksi').classList.add('hidden')" class="px-5 py-2.5 rounded-xl font-medium text-secondary hover:text-foreground transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-blue-600 transition-colors shadow-sm cursor-pointer">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-success text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-in slide-in-from-bottom-8">
    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@endsection
