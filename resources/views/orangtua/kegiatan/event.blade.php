@extends('layouts.admin')

@section('title', 'Event Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Event Sekolah</h1>
        <p class="text-gray-600">Dokumentasi dan informasi event yang akan datang.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Event Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
            <div class="h-48 bg-gray-200 relative overflow-hidden">
                <!-- Placeholder Image -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-600">Akan Datang</span>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-2 text-xs text-blue-600 font-medium mb-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i> 20 Feb 2024
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">GOEDU Art Festival 2024</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">Saksikan kreativitas siswa-siswi dalam festival seni tahunan terbesar sekolah.</p>
                <a href="#" class="text-blue-600 font-medium text-sm flex items-center gap-1 hover:gap-2 transition-all">
                    Lihat Detail <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

         <!-- Event Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
            <div class="h-48 bg-gray-200 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                 <span class="absolute top-4 right-4 bg-gray-900/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
            </div>
            <div class="p-5">
                 <div class="flex items-center gap-2 text-xs text-gray-500 font-medium mb-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i> 15 Jan 2024
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Study Tour: Museum Geologi</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">Kunjungan edukatif ke Museum Geologi Bandung untuk siswa kelas 5.</p>
                <a href="#" class="text-blue-600 font-medium text-sm flex items-center gap-1 hover:gap-2 transition-all">
                    Lihat Galeri <i data-lucide="image" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

         <!-- Event Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
            <div class="h-48 bg-gray-200 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                 <span class="absolute top-4 right-4 bg-gray-900/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
            </div>
            <div class="p-5">
                 <div class="flex items-center gap-2 text-xs text-gray-500 font-medium mb-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i> 10 Des 2023
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Class Meeting Semester Ganjil</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">Perlombaan antar kelas untuk mengisi waktu pasca ujian.</p>
                <a href="#" class="text-blue-600 font-medium text-sm flex items-center gap-1 hover:gap-2 transition-all">
                    Lihat Galeri <i data-lucide="image" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
