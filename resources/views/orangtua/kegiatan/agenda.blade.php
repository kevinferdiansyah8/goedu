@extends('layouts.admin')

@section('title', 'Agenda Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Agenda Kegiatan</h1>
        <p class="text-gray-600">Jadwal kegiatan akademik dan non-akademik.</p>
    </div>

    <!-- Calendar & Agenda Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar Widget (Visual Only) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Kalender</h3>
            <div class="grid grid-cols-7 gap-1 text-center text-sm mb-4">
                 <div class="text-gray-400 font-medium pb-2">Min</div>
                 <div class="text-gray-400 font-medium pb-2">Sen</div>
                 <div class="text-gray-400 font-medium pb-2">Sel</div>
                 <div class="text-gray-400 font-medium pb-2">Rab</div>
                 <div class="text-gray-400 font-medium pb-2">Kam</div>
                 <div class="text-gray-400 font-medium pb-2">Jum</div>
                 <div class="text-gray-400 font-medium pb-2">Sab</div>
                 <!-- Calendar Days Placeholder -->
                 <div class="py-2 text-gray-300">28</div>
                 <div class="py-2 text-gray-300">29</div>
                 <div class="py-2 text-gray-300">30</div>
                 <div class="py-2 text-gray-300">31</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">1</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">2</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">3</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">4</div>
                 <div class="py-2 bg-blue-600 text-white rounded-lg shadow-md">5</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">6</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">7</div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span> Hari Ini
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Libur Nasional
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Kegiatan Sekolah
                </div>
            </div>
        </div>

        <!-- Agenda List -->
        <div class="lg:col-span-2 space-y-4">
             <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-5 flex items-start gap-4">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold uppercase">Feb</span>
                    <span class="text-2xl font-bold">12</span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Ujian Tengah Semester (UTS)</h3>
                    <p class="text-gray-600 text-sm mt-1">UTS Semester Genap T.A. 2023/2024 dimulai.</p>
                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> 07:30 - 12:00</span>
                        <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Ruang Kelas</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-5 flex items-start gap-4">
                <div class="w-16 h-16 bg-green-50 text-green-600 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold uppercase">Feb</span>
                    <span class="text-2xl font-bold">20</span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pentas Seni Tahunan</h3>
                    <p class="text-gray-600 text-sm mt-1">Pertunjukan seni siswa-siswi GOEDU.</p>
                     <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> 08:00 - 15:00</span>
                        <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Aula Sekolah</span>
                    </div>
                </div>
            </div>

             <div class="bg-white rounded-xl shadow-sm border-l-4 border-red-500 p-5 flex items-start gap-4">
                <div class="w-16 h-16 bg-red-50 text-red-600 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold uppercase">Feb</span>
                    <span class="text-2xl font-bold">28</span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Libur Isra Mi'raj</h3>
                    <p class="text-gray-600 text-sm mt-1">Libur Nasional peringatan Isra Mi'raj Nabi Muhammad SAW.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
