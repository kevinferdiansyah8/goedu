@extends('layouts.sidebar-siswa')

@section('title', 'Dashboard Siswa - EDUGO')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ $studentInfo['nama'] }}!</h1>
        <p class="text-gray-600">Terus semangat belajar dan raih prestasimu. <span class="text-sm text-gray-400">({{ $studentInfo['kelas'] }} — NIS: {{ $studentInfo['nis'] }})</span></p>
    </div>

    <!-- 1. Ringkasan Aktivitas (Stats Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Kehadiran -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Kehadiran</p>
                <div class="text-2xl font-bold text-gray-800">{{ $kehadiran['hadir'] }}%</div>
                <p class="text-xs text-green-500">Semester ini ({{ $kehadiran['total'] }} hari)</p>
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
        <!-- Tugas Aktif -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Tugas Aktif</p>
                <div class="text-2xl font-bold text-gray-800">{{ $tugasBelum }}</div>
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
                <div class="text-2xl font-bold text-gray-800">{{ $totalPengumuman }}</div>
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
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                        <a href="{{ route('siswa.akademik.jadwal') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                </div>
                
                @if(count($jadwal_hari_ini) > 0)
                <div class="space-y-4">
                    @foreach($jadwal_hari_ini as $jadwal)
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="min-w-[100px] text-center mr-4 border-r border-gray-200 pr-4">
                            <span class="block text-lg font-bold text-blue-600">{{ trim(explode('-', $jadwal['jam'])[0]) }}</span>
                            <span class="text-xs text-gray-500">s.d</span>
                            <span class="block text-sm font-semibold text-gray-600">{{ trim(explode('-', $jadwal['jam'])[1] ?? '') }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $jadwal['mapel'] }}</h3>
                            <p class="text-gray-600 flex items-center gap-1 text-sm mt-1">
                                <i data-lucide="user" class="w-3 h-3"></i> {{ $jadwal['guru'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i data-lucide="calendar-off" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    <p>Tidak ada jadwal hari ini.</p>
                </div>
                @endif
            </div>

            <!-- 3. Tugas Aktif -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-5 h-5 text-indigo-500"></i> Tugas Aktif
                    </h2>
                    <a href="{{ route('siswa.akademik.tugas') }}" class="text-sm text-indigo-600 hover:underline">Lihat Semua</a>
                </div>

                @if(count($tugas_aktif) > 0)
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
                            @foreach($tugas_aktif->take(5) as $tugas)
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50">
                                <td class="py-3">{{ $tugas['mapel'] }}</td>
                                <td class="py-3 font-medium">{{ $tugas['judul'] }}</td>
                                <td class="py-3 text-sm">
                                    @php
                                        $deadlineDate = \Carbon\Carbon::parse($tugas['deadline']);
                                        $isOverdue = $deadlineDate->isPast();
                                        $daysLeft = now()->diffInDays($deadlineDate, false);
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $isOverdue ? 'bg-red-50 text-red-600' : ($daysLeft <= 3 ? 'bg-yellow-50 text-yellow-600' : 'bg-green-50 text-green-600') }}">
                                        {{ $deadlineDate->format('d M Y') }}
                                        @if($isOverdue)
                                            <span class="font-semibold">(Terlambat)</span>
                                        @elseif($daysLeft <= 3)
                                            <span class="font-semibold">({{ ceil($daysLeft) }} hari lagi)</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($tugas['status'] == 'Belum')
                                        <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded-full">Belum Dikerjakan</span>
                                    @elseif($tugas['status'] == 'Proses')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Sedang Dikerjakan</span>
                                    @elseif($tugas['status'] == 'Terkumpul')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Terkumpul</span>
                                    @elseif($tugas['status'] == 'Dinilai')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Dinilai</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $tugas['status'] }}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($tugas['status'] == 'Belum' || $tugas['status'] == 'Proses')
                                        <a href="{{ route('siswa.pembelajaran.tugas') }}" class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700 transition-colors inline-block">
                                            Kerjakan
                                        </a>
                                    @elseif($tugas['status'] == 'Terkumpul')
                                        <span class="px-3 py-1 bg-green-50 text-green-700 text-xs rounded inline-block">
                                            <i data-lucide="check" class="w-3 h-3 inline"></i> Selesai
                                        </span>
                                    @elseif($tugas['status'] == 'Dinilai')
                                        <a href="{{ route('siswa.pembelajaran.nilai') }}" class="px-3 py-1 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition-colors inline-block">
                                            Lihat Nilai
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($tugas_aktif) > 5)
                <div class="mt-3 text-center">
                    <a href="{{ route('siswa.akademik.tugas') }}" class="text-sm text-indigo-600 hover:underline">+ {{ count($tugas_aktif) - 5 }} tugas lainnya</a>
                </div>
                @endif
                @else
                <div class="text-center py-8 text-gray-500">
                    <i data-lucide="check-circle" class="w-12 h-12 mx-auto mb-3 text-green-300"></i>
                    <p>Tidak ada tugas aktif saat ini. 🎉</p>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column (Stats & Info) -->
        <div class="lg:col-span-1 space-y-8">
            
            <!-- 4. Statistik Kehadiran -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="pie-chart" class="w-5 h-5 text-green-500"></i> Statistik
                    </h2>
                    <a href="{{ route('siswa.kehadiran.rekap') }}" class="text-xs text-blue-600 hover:underline">Detail</a>
                </div>
                <div class="space-y-4">
                    <!-- Hadir -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Hadir</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['hadir'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $kehadiran['hadir'] }}%"></div>
                        </div>
                    </div>
                    <!-- Izin -->
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Izin</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['izin'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full transition-all duration-500" style="width: {{ $kehadiran['persen_izin'] }}%"></div>
                        </div>
                    </div>
                    <!-- Sakit -->
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Sakit</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['sakit'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                             <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $kehadiran['persen_sakit'] }}%"></div>
                        </div>
                    </div>
                    <!-- Alpha -->
                    <div>
                         <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Alpha</span>
                            <span class="font-bold text-gray-800">{{ $kehadiran['alpha'] }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                             <div class="bg-red-500 h-2 rounded-full transition-all duration-500" style="width: {{ $kehadiran['persen_alpha'] }}%"></div>
                        </div>
                    </div>
                </div>
                @if($kehadiran['total'] > 0)
                <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Total {{ $kehadiran['total'] }} hari tercatat</p>
                </div>
                @endif
            </div>

            <!-- 5. Rata-rata Nilai -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="trophy" class="w-5 h-5 text-amber-500"></i> Nilai
                    </h2>
                    <a href="{{ route('siswa.akademik.nilai') }}" class="text-xs text-blue-600 hover:underline">Detail</a>
                </div>
                <div class="text-center py-2">
                    <div class="text-4xl font-bold {{ $rataRataNilai >= 75 ? 'text-green-600' : ($rataRataNilai > 0 ? 'text-yellow-600' : 'text-gray-400') }}">
                        {{ $rataRataNilai > 0 ? $rataRataNilai : '-' }}
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Rata-rata Nilai</p>
                    @if($rataRataNilai >= 75)
                        <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                            <i data-lucide="trending-up" class="w-3 h-3 inline"></i> Baik
                        </span>
                    @elseif($rataRataNilai > 0)
                        <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">
                            <i data-lucide="trending-down" class="w-3 h-3 inline"></i> Perlu Ditingkatkan
                        </span>
                    @else
                        <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-500 text-xs rounded-full">
                            Belum ada data nilai
                        </span>
                    @endif
                </div>
            </div>

            <!-- 6. Info Terbaru / Pengumuman -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="megaphone" class="w-5 h-5 text-purple-500"></i> Info Terbaru
                    </h2>
                </div>
                @if(count($pengumuman) > 0)
                <div class="space-y-4">
                    @foreach($pengumuman as $info)
                    <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                        <span class="text-xs font-semibold text-purple-600 bg-purple-200 px-2 py-0.5 rounded-full mb-2 inline-block">Pengumuman</span>
                        <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $info['judul'] }}</h3>
                        <p class="text-gray-600 text-xs mb-2 line-clamp-2">{{ $info['isi'] }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-gray-400">{{ $info['waktu_lalu'] }}</span>
                            <span class="text-[10px] text-gray-500">{{ $info['tanggal'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6 text-gray-500">
                    <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 text-gray-300"></i>
                    <p class="text-sm">Belum ada pengumuman.</p>
                </div>
                @endif
                @if($totalPengumuman > 3)
                <div class="mt-4 text-center">
                    <a href="{{ route('siswa.kegiatan.event') }}" class="text-sm text-purple-600 font-semibold hover:underline">Lihat Semua Pengumuman ({{ $totalPengumuman }})</a>
                </div>
                @endif
            </div>

            <!-- 7. Agenda Mendatang -->
            @if(count($upcomingEvents) > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="calendar-days" class="w-5 h-5 text-teal-500"></i> Agenda
                    </h2>
                    <a href="{{ route('siswa.kegiatan.agenda') }}" class="text-xs text-blue-600 hover:underline">Semua</a>
                </div>
                <div class="space-y-3">
                    @foreach($upcomingEvents as $event)
                    <div class="flex items-start gap-3 p-3 bg-teal-50 rounded-lg border border-teal-100">
                        <div class="min-w-[45px] text-center">
                            <div class="text-lg font-bold text-teal-600">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d') }}</div>
                            <div class="text-[10px] text-teal-500 uppercase">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->locale('id')->isoFormat('MMM') }}</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm text-gray-800 truncate">{{ $event->judul }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">
                                @if($event->lokasi)
                                    <i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $event->lokasi }}
                                @endif
                                @if($event->waktu_pelaksanaan)
                                    · {{ $event->waktu_pelaksanaan }}
                                @endif
                            </p>
                        </div>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full {{ $event->tipe_info === 'Event' ? 'bg-blue-100 text-blue-700' : 'bg-teal-100 text-teal-700' }}">
                            {{ $event->tipe_info }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
