@extends('layouts.admin')

@section('title', 'Katalog Buku')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Katalog Buku</h1>
            <p class="text-gray-600">Jelajahi koleksi buku perpustakaan sekolah.</p>
        </div>
        <div class="relative">
            <input type="text" placeholder="Cari judul atau penulis..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-64">
            <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach($buku as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group">
            <div class="aspect-[2/3] bg-gray-200 relative overflow-hidden">
                <img src="https://source.unsplash.com/random/300x450/?book,cover&sig={{ $loop->index }}" alt="{{ $item['judul'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow">
                    Stok: {{ $item['stok'] }}
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-gray-800 line-clamp-1 mb-1" title="{{ $item['judul'] }}">{{ $item['judul'] }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $item['penulis'] }}</p>
                <span class="inline-block px-2 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-medium">{{ $item['kategori'] }}</span>
                <a href="{{ route('siswa.perpustakaan.pinjam') }}" class="mt-4 block w-full py-2 bg-blue-50 text-blue-600 font-semibold text-center rounded-lg hover:bg-blue-100 transition-colors text-sm">
                    Pinjam Buku
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
