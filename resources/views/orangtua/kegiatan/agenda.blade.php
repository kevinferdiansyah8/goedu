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
            @forelse($agenda as $a)
            <div class="bg-white rounded-xl shadow-sm border-l-4 @if($a->jenis === 'Akademik') border-blue-500 @elseif($a->jenis === 'Non-Akademik') border-green-500 @else border-orange-500 @endif p-5 flex items-start gap-4">
                <div class="w-16 h-16 bg-gray-50 text-gray-600 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($a->tanggal_pelaksanaan)->translatedFormat('M') }}</span>
                    <span class="text-2xl font-bold">{{ \Carbon\Carbon::parse($a->tanggal_pelaksanaan)->format('d') }}</span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ $a->judul }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $a->deskripsi }}</p>
                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> {{ $a->waktu_pelaksanaan }}</span>
                        <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $a->lokasi }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 flex flex-col items-center justify-center text-gray-400 bg-white rounded-xl border border-gray-100">
                <i data-lucide="calendar" class="w-12 h-12 mb-4 text-gray-300"></i>
                <span class="text-lg font-medium">Belum ada agenda sekolah</span>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
