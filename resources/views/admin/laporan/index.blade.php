@extends('layouts.admin')

@section('title', 'Dashboard Laporan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-2">
        <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-500 shadow-lg">
            <i data-lucide="bar-chart-3" class="w-8 h-8 text-white"></i>
        </span>
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-1">Dashboard Laporan</h1>
            <p class="text-gray-400 text-lg">Ringkasan dan monitoring seluruh laporan sekolah</p>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Absensi -->
        <div class="bg-white border border-blue-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-blue-600"></i>
                </span>
                <h3 class="font-bold text-blue-700 text-lg group-hover:text-blue-600">Laporan Absensi</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Rekap kehadiran siswa & guru (harian, bulanan, tahunan)</p>
            <a href="{{ route('admin.laporan.absensi') }}" class="inline-flex items-center gap-2 text-base font-bold text-blue-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
        <!-- Akademik -->
        <div class="bg-white border border-green-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-green-100">
                    <i data-lucide="book-open" class="w-6 h-6 text-green-600"></i>
                </span>
                <h3 class="font-bold text-green-700 text-lg group-hover:text-green-600">Laporan Akademik</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Nilai, peringkat, rapor, dan performa akademik siswa</p>
            <a href="{{ route('admin.laporan.akademik') }}" class="inline-flex items-center gap-2 text-base font-bold text-green-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
        <!-- Keuangan -->
        <div class="bg-white border border-yellow-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-yellow-100">
                    <i data-lucide="wallet" class="w-6 h-6 text-yellow-600"></i>
                </span>
                <h3 class="font-bold text-yellow-700 text-lg group-hover:text-yellow-600">Laporan Keuangan</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Pembayaran SPP, PPDB, dan transaksi sekolah</p>
            <a href="{{ route('admin.laporan.keuangan') }}" class="inline-flex items-center gap-2 text-base font-bold text-yellow-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
        <!-- PPDB -->
        <div class="bg-white border border-purple-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100">
                    <i data-lucide="user-plus" class="w-6 h-6 text-purple-600"></i>
                </span>
                <h3 class="font-bold text-purple-700 text-lg group-hover:text-purple-600">Laporan PPDB</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Pendaftaran, seleksi, kelulusan, dan statistik PPDB</p>
            <a href="{{ route('admin.laporan.ppdb') }}" class="inline-flex items-center gap-2 text-base font-bold text-purple-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
        <!-- Perpustakaan -->
        <div class="bg-white border border-indigo-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100">
                    <i data-lucide="library" class="w-6 h-6 text-indigo-600"></i>
                </span>
                <h3 class="font-bold text-indigo-700 text-lg group-hover:text-indigo-600">Laporan Perpustakaan</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Peminjaman, pengembalian, dan denda buku</p>
            <a href="{{ route('admin.laporan.perpustakaan') }}" class="inline-flex items-center gap-2 text-base font-bold text-indigo-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
        <!-- Kegiatan -->
        <div class="bg-white border border-red-100 rounded-3xl shadow-xl p-8 flex flex-col justify-between hover:shadow-2xl transition group">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-red-100">
                    <i data-lucide="calendar-days" class="w-6 h-6 text-red-600"></i>
                </span>
                <h3 class="font-bold text-red-700 text-lg group-hover:text-red-600">Laporan Kegiatan</h3>
            </div>
            <p class="text-base text-gray-500 mb-6">Event sekolah, agenda, dan dokumentasi</p>
            <a href="{{ route('admin.laporan.kegiatan') }}" class="inline-flex items-center gap-2 text-base font-bold text-red-600 hover:underline">
                Lihat Detail <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        lucide.createIcons();
    }
});
</script>
@endpush
