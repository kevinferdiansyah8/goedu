@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
        <p class="text-gray-600">Jadwal kegiatan belajar mengajar minggu ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($jadwal as $hari => $mapels)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-3 font-semibold text-lg flex justify-between items-center">
                {{ $hari }}
                <i data-lucide="calendar" class="w-5 h-5 opacity-80"></i>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @foreach($mapels as $mapel)
                    <div class="relative pl-6 border-l-2 border-blue-200">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-blue-100 border-2 border-blue-500"></div>
                        <div class="mb-1">
                            <h3 class="font-bold text-gray-800">{{ $mapel['mapel'] }}</h3>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $mapel['jam'] }}</span>
                        </div>
                        <div class="text-sm text-gray-500 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i> {{ $mapel['guru'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
