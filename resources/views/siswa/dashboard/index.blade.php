@extends('layouts.admin')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, Siswa!</h1>
        <p class="text-gray-600">Terus semangat belajar dan raih prestasimu.</p>
    </div>

    <!-- 1. Ringkasan Aktivitas (Stats Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Hadir -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Kehadiran</p>
                <div class="text-2xl font-bold text-gray-800">{{ $kehadiran['hadir'] }}%</div>
                <p class="text-xs text-green-500">Semester ini</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>
         <!-- Izin/Sakit -->
         <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Izin / Sakit</p>
                <div class="text-2xl font-bold text-gray-800">{{ $kehadiran['izin'] + $kehadiran['sakit'] }} Hari</div>
                 <p class="text-xs text-yellow-500">Total Absen</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Tugas -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Tugas Aktif</p>
                <div class="text-2xl font-bold text-gray-800">{{ count($tugas_aktif) }}</div>
                <p class="text-xs text-blue-500">Perlu dikerjakan</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i data-lucide="book" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Pengumuman -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 flex items-center justify-between">
             <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Pengumuman</p>
                <div class="text-2xl font-bold text-gray-800">{{ count($pengumuman) }}</div>
                 <p class="text-xs text-purple-500">Terbaru</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i data-lucide="bell" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Jadwal & Tugas) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- 2. Jadwal Hari Ini -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-blue-500"></i> Jadwal Hari Ini
                    </h2>
                    <span class="text-sm text-gray-500">{{ date('l, d F Y') }}</span>
                </div>
                
                @if(count($jadwal_hari_ini) > 0)
                <div class="space-y-4">
                    @foreach($jadwal_hari_ini as $jadwal)
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="min-w-[100px] text-center mr-4 border-r border-gray-200 pr-4">
                            <span class="block text-lg font-bold text-blue-600">{{ explode('-', $jadwal['jam'])[0] }}</span>
                            <span class="text-xs text-gray-500">s.d</span>
                            <span class="block text-sm font-semibold text-gray-600">{{ explode('-', $jadwal['jam'])[1] }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $jadwal['mapel'] }}</h3>
                            <p class="text-gray-600 flex items-center gap-1 text-sm mt-1">
                                <i data-lucide="user" class="w-3 h-3"></i> {{ $jadwal['guru'] }}
                            </p>
                        </div>
                        <div class="ml-auto">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Hadir</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    Tidak ada jadwal hari ini.
                </div>
                @endif
            </div>

            <!-- 4. Tugas Aktif -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-5 h-5 text-indigo-500"></i> Tugas Aktif
                    </h2>
                    <a href="#" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 text-sm border-b border-gray-200">
                                <th class="pb-2">Mata Pelajaran</th>
                                <th class="pb-2">Judul Tugas</th>
                                <th class="pb-2">Deadline</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($tugas_aktif as $tugas)
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50">
                                <td class="py-3">{{ $tugas['mapel'] }}</td>
                                <td class="py-3 font-medium">{{ $tugas['judul'] }}</td>
                                <td class="py-3 text-red-500 text-sm">
                                    <span class="bg-red-50 px-2 py-1 rounded">{{ $tugas['deadline'] }}</span>
                                </td>
                                <td class="py-3">
                                    @if($tugas['status'] == 'Belum')
                                        <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded-full">Belum Dikerjakan</span>
                                    @elseif($tugas['status'] == 'Proses')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Sedang Dikerjakan</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <button class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700 transition-colors">
                                        Kerjakan
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column (Kehadiran & Pengumuman) -->
        <div class="lg:col-span-1 space-y-8">
            
            <!-- 3. Ringkasan Kehadiran Details -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="pie-chart" class="w-5 h-5 text-green-500"></i> Statistik
                    </h2>
                </div>
                <!-- Simple Donut Chart Representation using CSS Conic Gradient for simplicity or just bars -->
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Hadir</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['hadir'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $kehadiran['hadir'] }}%"></div>
                        </div>
                    </div>
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Izin</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['izin'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 5%"></div>
                        </div>
                    </div>
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Sakit</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['sakit'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                             <div class="bg-blue-500 h-2 rounded-full" style="width: 8%"></div>
                        </div>
                    </div>
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Alpha</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['alpha'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                             <div class="bg-red-500 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Pengumuman Terbaru -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="megaphone" class="w-5 h-5 text-purple-500"></i> Info Terbaru
                    </h2>
                </div>
                <div class="space-y-4">
                    @foreach($pengumuman as $info)
                    <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                        <span class="text-xs font-semibold text-purple-600 bg-purple-200 px-2 py-0.5 rounded-full mb-2 inline-block">Pengumuman</span>
                        <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $info['judul'] }}</h3>
                        <p class="text-gray-600 text-xs mb-2 line-clamp-2">{{ $info['isi'] }}</p>
                        <div class="text-right">
                            <span class="text-[10px] text-gray-500">{{ $info['tanggal'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm text-purple-600 font-semibold hover:underline">Lihat Semua Pengumuman</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
