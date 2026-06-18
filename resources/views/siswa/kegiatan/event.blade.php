@extends('layouts.sidebar-siswa')

@section('title', 'Event Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{ selectedEvent: null, showModal: false }">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Event Sekolah</h1>
        <p class="text-gray-600">Daftar acara dan kegiatan besar sekolah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col justify-between">
            <div>
                <div class="h-48 bg-gray-200 relative">
                    @if($event->gambar_attachment)
                        <img src="{{ asset('storage/' . $event->gambar_attachment) }}" alt="{{ $event->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-50 flex items-center justify-center text-blue-300">
                            <i data-lucide="image" class="w-12 h-12"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-bold text-blue-600 shadow-sm">
                        {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $event->judul }}</h3>
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>{{ $event->lokasi }}</span>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $event->deskripsi }}</p>
                </div>
            </div>
            <div class="p-6 pt-0">
                <button @click="selectedEvent = @json($event); showModal = true" class="w-full px-4 py-2 border border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                    Lihat Detail
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="calendar" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada event sekolah</span>
        </div>
        @endforelse
    </div>

    {{-- DETAIL MODAL --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 p-4 transition-opacity" style="display: none;">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg overflow-y-auto max-h-[90vh]" @click.away="showModal = false">
            <template x-if="selectedEvent && selectedEvent.gambar_attachment">
                <div class="w-full h-48 rounded-2xl overflow-hidden mb-6 bg-gray-100">
                    <img :src="'/storage/' + selectedEvent.gambar_attachment" :alt="selectedEvent.judul" class="w-full h-full object-cover">
                </div>
            </template>
            
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-bold">
                    <i data-lucide="calendar"></i>
                </span>
                <h3 class="text-2xl font-bold text-gray-950" x-text="selectedEvent ? selectedEvent.judul : ''"></h3>
            </div>

            <div class="mb-6 text-gray-700 text-base leading-relaxed whitespace-pre-wrap" x-text="selectedEvent ? selectedEvent.deskripsi : ''"></div>

            <div class="space-y-3 border-t border-gray-100 pt-4 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                    <span>Lokasi: <strong x-text="selectedEvent ? selectedEvent.lokasi : ''"></strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                    <span>Tanggal: <strong x-text="selectedEvent ? selectedEvent.tanggal_pelaksanaan : ''"></strong></span>
                </div>
                <template x-if="selectedEvent && selectedEvent.waktu_pelaksanaan && selectedEvent.waktu_pelaksanaan !== selectedEvent.tanggal_pelaksanaan">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar-range" class="w-4 h-4 text-gray-400"></i>
                        <span>Sampai Tanggal: <strong x-text="selectedEvent.waktu_pelaksanaan"></strong></span>
                    </div>
                </template>
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-gray-150">
                <button type="button" @click="showModal = false" class="px-7 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-bold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
