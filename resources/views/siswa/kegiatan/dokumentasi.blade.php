@extends('layouts.sidebar-siswa')

@section('title', 'Dokumentasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dokumentasi</h1>
        <p class="text-gray-600">Galeri foto kegiatan sekolah.</p>
    </div>

    <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
        @forelse($dokumentasi as $foto)
        <div class="break-inside-avoid bg-white rounded-xl shadow-md overflow-hidden group cursor-pointer hover:-translate-y-1 transition-transform duration-300">
            <div class="relative overflow-hidden">
                @if($foto->gambar_attachment)
                    <img src="{{ asset('storage/' . $foto->gambar_attachment) }}" alt="{{ $foto->judul }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <img src="https://picsum.photos/600/400?sig={{ $loop->index }}" alt="{{ $foto->judul }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-500">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <div class="text-white">
                        <h3 class="font-bold text-lg mb-1">{{ $foto->judul }}</h3>
                        <p class="text-sm opacity-90">{{ \Carbon\Carbon::parse($foto->tanggal_pelaksanaan)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="images" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada galeri dokumentasi</span>
        </div>
        @endforelse
    </div>
</div>
@endsection
