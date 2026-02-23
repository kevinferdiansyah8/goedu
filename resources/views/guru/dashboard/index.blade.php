@extends('layouts.admin')

@section('title', 'Dashboard EduGo')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="dashboardPage()">
    
    {{-- HEADER SECTION --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang, Pak Budi 👋</h1>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wide">Guru Admin</span>
            </div>
            <p class="text-gray-500 text-sm">Berikut adalah ringkasan aktivitas akademik Anda hari ini.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-white border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-600 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Tahun Ajaran 2023/2024
            </div>
            <button class="p-2 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        {{-- Total Kelas --}}
        <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:border-blue-500 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Kelas</p>
            <h3 class="text-2xl font-bold text-gray-900">5 <span class="text-sm font-normal text-gray-400">Mapel</span></h3>
        </div>

        {{-- Jadwal Hari Ini --}}
        <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:border-orange-500 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Jadwal Hari Ini</p>
            <h3 class="text-2xl font-bold text-gray-900">3 <span class="text-sm font-normal text-gray-400">Sesi</span></h3>
        </div>

        {{-- Rata-rata Nilai --}}
        <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:border-green-500 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg> +2.1
                </span>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Rata-rata Nilai</p>
            <h3 class="text-2xl font-bold text-gray-900">84.5</h3>
        </div>

        {{-- Kehadiran --}}
        <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:border-indigo-500 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg> -0.5%
                </span>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Kehadiran</p>
            <h3 class="text-2xl font-bold text-gray-900">95.2%</h3>
        </div>

        {{-- Tugas --}}
        <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:border-red-500 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-xs font-bold text-white bg-red-500 px-2 py-0.5 rounded-full">Baru</span>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Belum Dinilai</p>
            <h3 class="text-2xl font-bold text-gray-900">4 <span class="text-sm font-normal text-gray-400">Tugas</span></h3>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- JADWAL MENGAJAR --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-6 bg-blue-600 rounded-full"></span>
                        Jadwal Hari Ini
                    </h2>
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    {{-- Active Class --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border border-blue-100 bg-blue-50/50 relative overflow-hidden group">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                        <div class="flex-shrink-0 flex sm:flex-col items-center justify-center sm:justify-start gap-2 sm:gap-0 sm:w-20 text-center">
                            <span class="text-xs font-bold text-blue-600 uppercase">JAM KE</span>
                            <span class="text-xl font-bold text-gray-900">1-2</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Matematika Wajib</h3>
                                    <p class="text-gray-600 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Kelas X IPA 1
                                    </p>
                                    <p class="text-gray-600 text-sm flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        Ruang 101
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 animate-pulse">
                                    Sedang Berlangsung
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Next Class --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors group">
                        <div class="flex-shrink-0 flex sm:flex-col items-center justify-center sm:justify-start gap-2 sm:gap-0 sm:w-20 text-center">
                            <span class="text-xs font-bold text-gray-400 uppercase">JAM KE</span>
                            <span class="text-xl font-bold text-gray-700">3-4</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Matematika Peminatan</h3>
                                    <p class="text-gray-600 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Kelas XI IPA 2
                                    </p>
                                    <p class="text-gray-600 text-sm flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        Ruang 102
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    Akan Datang
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Next Class --}}
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors group">
                        <div class="flex-shrink-0 flex sm:flex-col items-center justify-center sm:justify-start gap-2 sm:gap-0 sm:w-20 text-center">
                            <span class="text-xs font-bold text-gray-400 uppercase">JAM KE</span>
                            <span class="text-xl font-bold text-gray-700">7-8</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Fisika Dasar</h3>
                                    <p class="text-gray-600 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Kelas X IPS 1
                                    </p>
                                    <p class="text-gray-600 text-sm flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        Lab Fisika
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    Akan Datang
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHART GRAFIK --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                     <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-6 bg-purple-600 rounded-full"></span>
                        Tren Kehadiran Siswa
                    </h2>
                    <select class="text-sm border-none bg-gray-50 rounded-lg text-gray-600 font-medium focus:ring-0 cursor-pointer hover:bg-gray-100 px-3 py-1">
                        <option>7 Hari Terakhir</option>
                        <option>Bulan Ini</option>
                    </select>
                </div>
                <div class="h-64 sm:h-80 w-full relative">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- AKTIVITAS TERBARU / FEED --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-orange-500 rounded-full"></span>
                    Aktivitas & Notifikasi
                </h2>
                
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent">
                    
                    {{-- Item 1 --}}
                    <div class="relative flex items-start group">
                        <div class="absolute h-full w-full left-0 top-0 overflow-hidden rounded-xl bg-orange-50 opacity-0 group-hover:opacity-100 transition-opacity -z-10"></div>
                        <div class="h-10 w-10 flex items-center justify-center rounded-full bg-white border-2 border-orange-100 shadow-sm z-10 shrink-0 mt-1">
                            <span class="font-bold text-orange-500 text-xs">TGS</span>
                        </div>
                        <div class="ml-4 flex-1 py-1">
                            <div class="flex justify-between items-start">
                                <h4 class="text-sm font-bold text-gray-900">4 Tugas Menunggu</h4>
                                <span class="text-xs text-gray-400">2j yang lalu</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">Tugas "Aljabar Linear" kelas X IPA 1 belum dinilai.</p>
                            <button class="mt-2 text-xs font-bold text-orange-600 hover:underline">Nilai Sekarang</button>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="relative flex items-start group">
                        <div class="absolute h-full w-full left-0 top-0 overflow-hidden rounded-xl bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity -z-10"></div>
                        <div class="h-10 w-10 flex items-center justify-center rounded-full bg-white border-2 border-blue-100 shadow-sm z-10 shrink-0 mt-1">
                            <span class="font-bold text-blue-500 text-xs">IZN</span>
                        </div>
                        <div class="ml-4 flex-1 py-1">
                             <div class="flex justify-between items-start">
                                <h4 class="text-sm font-bold text-gray-900">Izin Siswa</h4>
                                <span class="text-xs text-gray-400">08:30</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1"><span class="font-semibold text-gray-800">Budi Santoso</span> (X IPA 1) mengajukan izin sakit.</p>
                            <div class="flex gap-2 mt-2">
                                <button class="px-3 py-1 rounded-lg bg-green-100 text-green-700 text-xs font-bold hover:bg-green-200">Terima</button>
                                <button class="px-3 py-1 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold hover:bg-gray-200">Tolak</button>
                            </div>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="relative flex items-start group">
                        <div class="absolute h-full w-full left-0 top-0 overflow-hidden rounded-xl bg-purple-50 opacity-0 group-hover:opacity-100 transition-opacity -z-10"></div>
                        <div class="h-10 w-10 flex items-center justify-center rounded-full bg-white border-2 border-purple-100 shadow-sm z-10 shrink-0 mt-1">
                            <span class="font-bold text-purple-500 text-xs">INFO</span>
                        </div>
                        <div class="ml-4 flex-1 py-1">
                             <div class="flex justify-between items-start">
                                <h4 class="text-sm font-bold text-gray-900">Rapat Guru</h4>
                                <span class="text-xs text-gray-400">Kemarin</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">Pengumuman rapat evaluasi bulanan hari Jumat, 13:00 di Ruang Guru.</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- QUICK LINKS --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg shadow-blue-200 p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Butuh Bantuan?</h3>
                    <p class="text-blue-100 text-sm mb-4">Panduan penggunaan sistem EduGo untuk guru.</p>
                    <button class="w-full bg-white text-blue-600 font-bold py-2 rounded-lg text-sm hover:bg-blue-50 transition-colors shadow-sm">
                        Buka Pusat Bantuan
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardPage', () => ({
            init() {
                this.$nextTick(() => {
                    this.initChart();
                });
            },

            initChart() {
                const ctx = document.getElementById('attendanceChart');
                if(!ctx) return;

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                        datasets: [{
                            label: 'Kehadiran (%)',
                            data: [92, 94, 89, 95, 96, 0, 0], // Mock Data
                            borderColor: '#2563eb', // Blue 600
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
                                gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');
                                return gradient;
                            },
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#2563eb',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 13 },
                                bodyFont: { size: 14, weight: 'bold' },
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: (context) => context.parsed.y + '%'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 50,
                                max: 100,
                                grid: {
                                    borderDash: [5, 5],
                                    color: '#f1f5f9'
                                },
                                ticks: {
                                    color: '#64748b',
                                    callback: (value) => value + '%'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });
            }
        }));
    });
</script>
@endpush
@endsection
