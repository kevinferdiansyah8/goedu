@extends('layouts.admin')

@section('title', 'Event Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Event Sekolah</h1>
        <p class="text-gray-600">Daftar acara dan kegiatan besar sekolah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="h-48 bg-gray-200 relative">
                <!-- Placeholder Image -->
                <img src="https://source.unsplash.com/random/400x300/?school,event&sig={{ $loop->index }}" alt="{{ $event['judul'] }}" class="w-full h-full object-cover">
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-bold text-blue-600 shadow-sm">
                    {{ \Carbon\Carbon::parse($event['tanggal'])->format('d M') }}
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event['judul'] }}</h3>
                <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <span>{{ $event['lokasi'] }}</span>
                </div>
                <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $event['deskripsi'] }}</p>
                <button class="w-full px-4 py-2 border border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                    Lihat Detail
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
