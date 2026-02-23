@extends('layouts.admin')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{ selectedChild: 0 }">
    
    <!-- Welcome Section -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, Bapak/Ibu</h1>
        <p class="text-gray-600">Pantau perkembangan pendidikan putra-putri Anda dengan mudah.</p>
    </div>

    <!-- Child Picker -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
          <i data-lucide="users" class="w-4 h-4 text-primary"></i>
          <span class="text-sm font-bold text-gray-700 uppercase tracking-wider">Pilih Anak</span>
        </div>
        <span class="text-xs text-gray-400">2 anak terdaftar</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

        <!-- Child 1 -->
        <button @click="selectedChild = 0" :class="selectedChild === 0 ? 'ring-2 ring-primary border-primary bg-blue-50/50' : 'border-gray-100 bg-white hover:border-gray-200 hover:shadow-md'" class="relative flex items-center gap-4 p-4 rounded-2xl border shadow-sm transition-all duration-200 text-left cursor-pointer">
          <!-- Active Badge -->
          <div x-show="selectedChild === 0" class="absolute top-2.5 right-2.5">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center">
              <i data-lucide="check" class="w-3 h-3 text-white"></i>
            </div>
          </div>
          <!-- Avatar -->
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0 shadow-md shadow-blue-200">
            <span class="text-white font-extrabold text-lg">AR</span>
          </div>
          <!-- Info -->
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-800 truncate">Ahmad Rizky Pratama</p>
            <p class="text-[11px] text-gray-400">NISN: 0012345678</p>
            <div class="flex items-center gap-2 mt-1">
              <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">SMP — Kelas 7A</span>
            </div>
          </div>
        </button>

        <!-- Child 2 -->
        <button @click="selectedChild = 1" :class="selectedChild === 1 ? 'ring-2 ring-primary border-primary bg-blue-50/50' : 'border-gray-100 bg-white hover:border-gray-200 hover:shadow-md'" class="relative flex items-center gap-4 p-4 rounded-2xl border shadow-sm transition-all duration-200 text-left cursor-pointer">
          <!-- Active Badge -->
          <div x-show="selectedChild === 1" class="absolute top-2.5 right-2.5">
            <div class="w-5 h-5 rounded-full bg-primary flex items-center justify-center">
              <i data-lucide="check" class="w-3 h-3 text-white"></i>
            </div>
          </div>
          <!-- Avatar -->
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center shrink-0 shadow-md shadow-pink-200">
            <span class="text-white font-extrabold text-lg">SA</span>
          </div>
          <!-- Info -->
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-800 truncate">Siti Aisyah Pratama</p>
            <p class="text-[11px] text-gray-400">NISN: 0098765432</p>
            <div class="flex items-center gap-2 mt-1">
              <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">SD — Kelas 4B</span>
            </div>
          </div>
        </button>

      </div>
    </div>

    <!-- Active Child Summary -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-8">
      <div class="flex items-center gap-4 flex-wrap">
        <!-- Child 1 summary -->
        <template x-if="selectedChild === 0">
          <div class="flex items-center gap-4 w-full flex-wrap">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0">
              <span class="text-white font-extrabold">AR</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-bold text-gray-800">Menampilkan data: <span class="text-primary">Ahmad Rizky Pratama</span></p>
              <p class="text-xs text-gray-400">SMP Kelas 7A — Wali Kelas: Ibu Sri Wahyuni, S.Pd.</p>
            </div>
            <div class="flex gap-4 ml-auto">
              <div class="text-center">
                <p class="text-lg font-extrabold text-emerald-600">95%</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Kehadiran</p>
              </div>
              <div class="text-center">
                <p class="text-lg font-extrabold text-blue-600">82.5</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Rata-rata</p>
              </div>
              <div class="text-center">
                <p class="text-lg font-extrabold text-amber-500">Lunas</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">SPP</p>
              </div>
            </div>
          </div>
        </template>
        <!-- Child 2 summary -->
        <template x-if="selectedChild === 1">
          <div class="flex items-center gap-4 w-full flex-wrap">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center shrink-0">
              <span class="text-white font-extrabold">SA</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-bold text-gray-800">Menampilkan data: <span class="text-pink-600">Siti Aisyah Pratama</span></p>
              <p class="text-xs text-gray-400">SD Kelas 4B — Wali Kelas: Bapak Hadi Santoso, S.Pd.</p>
            </div>
            <div class="flex gap-4 ml-auto">
              <div class="text-center">
                <p class="text-lg font-extrabold text-emerald-600">98%</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Kehadiran</p>
              </div>
              <div class="text-center">
                <p class="text-lg font-extrabold text-blue-600">88.2</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Rata-rata</p>
              </div>
              <div class="text-center">
                <p class="text-lg font-extrabold text-red-500">Belum</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">SPP</p>
              </div>
            </div>
          </div>
        </template>
      </div>
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
