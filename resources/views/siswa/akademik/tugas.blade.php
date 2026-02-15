@extends('layouts.admin')

@section('title', 'Tugas & PR')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tugas & PR</h1>
            <p class="text-gray-600">Daftar tugas pekerjaan rumah dan proyek.</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1 flex">
            <button class="px-4 py-1.5 text-sm font-medium bg-blue-50 text-blue-600 rounded-md">Semua</button>
            <button class="px-4 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">Belum</button>
            <button class="px-4 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">Selesai</button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @foreach($tugas as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 
                        {{ $item['status'] == 'Selesai' ? 'bg-green-100 text-green-600' : ($item['status'] == 'Proses' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                        <i data-lucide="{{ $item['status'] == 'Selesai' ? 'check-circle' : 'book-open' }}" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">{{ $item['mapel'] }}</span>
                            @if($item['status'] == 'Belum')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Belum Dikerjakan</span>
                            @elseif($item['status'] == 'Proses')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">Dalam Pengerjaan</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-600">Selesai</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $item['judul'] }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $item['deskripsi'] }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 border-t md:border-t-0 pt-4 md:pt-0 pl-0 md:pl-6 border-gray-100">
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Deadline</p>
                        <p class="text-sm font-semibold text-red-500">{{ \Carbon\Carbon::parse($item['deadline'])->format('d M Y') }}</p>
                    </div>
                    <button class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors">
                        {{ $item['status'] == 'Selesai' ? 'Lihat Detail' : 'Kerjakan' }}
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
