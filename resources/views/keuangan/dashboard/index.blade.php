@extends('layouts.sidebar-keuangan')

@section('title', 'Dashboard Keuangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Dashboard Keuangan</h1>
            <p class="text-secondary text-sm mt-1">Ringkasan keuangan sekolah hari ini</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-full text-foreground font-medium transition-all duration-200 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-primary-hover transition-all duration-200 cursor-pointer">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total Pemasukan -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="trending-up" class="size-6 text-success"></i>
                </div>
                <p class="font-medium text-secondary text-sm">Total Pemasukan</p>
            </div>
            <div class="flex items-center gap-3">
                <p class="font-bold text-2xl leading-8 text-success">Rp {{ number_format($stats['total_pemasukan'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Total Tunggakan -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-error/10 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="trending-down" class="size-6 text-error"></i>
                </div>
                <p class="font-medium text-secondary text-sm">Total Tunggakan</p>
            </div>
            <div class="flex items-center gap-3">
                <p class="font-bold text-2xl leading-8 text-error">Rp {{ number_format($stats['total_tunggakan'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Pembayaran Hari Ini -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="wallet" class="size-6 text-primary"></i>
                </div>
                <p class="font-medium text-secondary text-sm">Masuk Hari Ini</p>
            </div>
            <div class="flex items-center gap-3">
                <p class="font-bold text-2xl leading-8">Rp {{ number_format($stats['pembayaran_hari_ini'], 0, ',', '.') }}</p>
                <span class="text-success text-sm font-semibold">+12%</span>
            </div>
        </div>

        <!-- Siswa Belum Bayar -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-warning/10 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="user-x" class="size-6 text-warning-dark"></i>
                </div>
                <p class="font-medium text-secondary text-sm">Belum Bayar</p>
            </div>
            <p class="font-bold text-[32px] leading-10">{{ $stats['siswa_belum_bayar'] }} <span class="text-base font-medium text-secondary">siswa</span></p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pemasukan & Pengeluaran Bulanan Chart -->
        <div class="lg:col-span-2 flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <i data-lucide="bar-chart-2" class="size-6 text-primary"></i>
                    </div>
                    <p class="font-medium text-secondary">Pemasukan vs Pengeluaran</p>
                </div>
                <span class="text-sm text-secondary">Tahun 2026</span>
            </div>
            <div class="w-full overflow-x-auto">
                <div class="min-w-[500px] h-[300px]">
                    <canvas id="pemasukanChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sumber Pemasukan Pie -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
            <div class="flex items-center gap-2">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="pie-chart" class="size-6 text-success"></i>
                </div>
                <p class="font-medium text-secondary">Sumber Pemasukan</p>
            </div>
            <div class="h-[300px] flex items-center justify-center">
                <canvas id="sumberChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('keuangan.pembayaran.verifikasi') }}" class="flex items-center gap-4 rounded-2xl border border-border p-5 bg-white hover:border-primary hover:shadow-lg transition-all duration-300 group">
            <div class="size-12 bg-warning/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-warning/20 transition-all">
                <i data-lucide="shield-check" class="size-6 text-warning-dark"></i>
            </div>
            <div>
                <h3 class="font-semibold text-foreground">Verifikasi Pembayaran</h3>
                <p class="text-sm text-secondary">4 pembayaran menunggu</p>
            </div>
        </a>
        <a href="{{ route('keuangan.pembayaran.tagihan') }}" class="flex items-center gap-4 rounded-2xl border border-border p-5 bg-white hover:border-primary hover:shadow-lg transition-all duration-300 group">
            <div class="size-12 bg-error/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-error/20 transition-all">
                <i data-lucide="receipt" class="size-6 text-error"></i>
            </div>
            <div>
                <h3 class="font-semibold text-foreground">Tagihan SPP</h3>
                <p class="text-sm text-secondary">{{ $stats['siswa_belum_bayar'] }} siswa menunggak</p>
            </div>
        </a>
        <a href="{{ route('keuangan.laporan') }}" class="flex items-center gap-4 rounded-2xl border border-border p-5 bg-white hover:border-primary hover:shadow-lg transition-all duration-300 group">
            <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-all">
                <i data-lucide="file-bar-chart" class="size-6 text-primary"></i>
            </div>
            <div>
                <h3 class="font-semibold text-foreground">Laporan Keuangan</h3>
                <p class="text-sm text-secondary">Lihat laporan lengkap</p>
            </div>
        </a>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bulan = {!! json_encode($bulan_labels) !!};
    const pemasukan = {!! json_encode($pemasukan_bulanan) !!}.map(v => v/1000000);
    const pengeluaran = {!! json_encode($pengeluaran_bulanan) !!}.map(v => v/1000000);

    new Chart(document.getElementById('pemasukanChart'), {
        type: 'bar',
        data: {
            labels: bulan,
            datasets: [
                { label: 'Pemasukan (Jt)', data: pemasukan, backgroundColor: '#22C55E', borderRadius: 6 },
                { label: 'Pengeluaran (Jt)', data: pengeluaran, backgroundColor: '#EF4444', borderRadius: 6 }
            ]
        },
        options: {
            animation: false,
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v + 'Jt' } } }
        }
    });

    const sumber = {!! json_encode($sumber_pemasukan) !!};
    new Chart(document.getElementById('sumberChart'), {
        type: 'doughnut',
        data: {
            labels: sumber.labels,
            datasets: [{ data: sumber.data, backgroundColor: ['#165DFF', '#22C55E', '#F59E0B', '#6B7280'] }]
        },
        options: {
            animation: false,
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@endpush
@endsection
