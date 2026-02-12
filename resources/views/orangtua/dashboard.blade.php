@extends('layouts.admin')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, Bapak/Ibu</h1>
        <p class="text-gray-600">Pantau perkembangan pendidikan putra-putri Anda dengan mudah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- 1. Monitoring Anak -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Monitoring Anak</h2>
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <ul class="space-y-3 text-gray-600">
                <li>
                    <a href="{{ route('orangtua.monitoring.presensi') }}" class="flex items-center hover:text-blue-600 transition-colors">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Ringkasan Kehadiran
                    </a>
                </li>
                <li>
                    <a href="{{ route('orangtua.monitoring.nilai') }}" class="flex items-center hover:text-blue-600 transition-colors">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Nilai Terbaru
                    </a>
                </li>
                <li>
                    <a href="{{ route('orangtua.monitoring.spp') }}" class="flex items-center hover:text-blue-600 transition-colors">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>Status SPP
                    </a>
                </li>
                <li class="flex items-center"><span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>Notifikasi Penting</li>
            </ul>
        </div>

        <!-- 2. Monitoring Akademik -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Monitoring Akademik</h2>
                <div class="p-2 bg-green-100 rounded-lg text-green-600">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 19.477 5.754 19 7.5 19s3.332.477 4.5 1.253v-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 19.477 18.247 19 16.5 19c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
             <ul class="space-y-3 text-gray-600">
                <li>
                     <a href="{{ route('orangtua.akademik.tugas') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Nilai Tugas & Ulangan
                    </a>
                </li>
                <li>
                    <a href="{{ route('orangtua.akademik.rapor') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Rapor
                    </a>
                </li>
                <li>
                    <a href="{{ route('orangtua.akademik.jadwal') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Jadwal Pelajaran
                    </a>
                </li>
            </ul>
        </div>

        <!-- 3. Absensi Anak -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Absensi Anak</h2>
                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
             <ul class="space-y-3 text-gray-600">
                <li>
                    <a href="{{ route('orangtua.absensi.riwayat') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Riwayat Absensi
                    </a>
                </li>
                <li>
                     <a href="{{ route('orangtua.absensi.izin') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Izin / Sakit
                    </a>
                </li>
                <li>
                     <a href="{{ route('orangtua.absensi.rekap') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Rekap Bulanan
                    </a>
                </li>
            </ul>
        </div>

        <!-- 4. Keuangan -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
             <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Keuangan</h2>
                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <ul class="space-y-3 text-gray-600">
                <li>
                    <a href="{{ route('orangtua.keuangan.tagihan') }}" class="flex items-center hover:text-yellow-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Tagihan SPP
                    </a>
                </li>
                 <li>
                    <a href="{{ route('orangtua.keuangan.riwayat') }}" class="flex items-center hover:text-yellow-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Riwayat Pembayaran
                    </a>
                </li>
                 <li>
                    <a href="{{ route('orangtua.keuangan.bukti') }}" class="flex items-center hover:text-yellow-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Bukti Pembayaran
                    </a>
                </li>
            </ul>
        </div>

        <!-- 5. Kegiatan & Pengumuman -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Kegiatan & Info</h2>
                 <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
            </div>
             <ul class="space-y-3 text-gray-600">
                <li class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Agenda</li>
                <li class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Event</li>
                <li class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Pengumuman Resmi</li>
            </ul>
        </div>

        <!-- 6. Profil Orang Tua -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-gray-500 hover:shadow-lg transition-shadow">
             <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Profil Saya</h2>
                <div class="p-2 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
             <ul class="space-y-3 text-gray-600">
                <li>
                    <a href="{{ route('orangtua.profil.datadiri') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Data Diri
                    </a>
                </li>
                <li>
                    <a href="{{ route('orangtua.profil.dataanak') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Data Anak
                    </a>
                </li>
                 <li>
                    <a href="{{ route('orangtua.profil.password') }}" class="flex items-center hover:text-green-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>Ganti Password
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
@endsection
