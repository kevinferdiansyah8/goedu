@extends('layouts.admin')

@section('title', 'Data Orang Tua')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Orang Tua / Wali</h1>
        <p class="text-gray-600">Informasi mengenai orang tua atau wali siswa.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Data Ayah -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Data Ayah</h3>
                    <p class="text-xs text-gray-500">Kepala Keluarga</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ayah']['nama'] }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pekerjaan</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ayah']['pekerjaan'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">No. Telepon</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ayah']['telepon'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ayah']['alamat'] }}</p>
                </div>
            </div>
        </div>

        <!-- Data Ibu -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center text-pink-600">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Data Ibu</h3>
                    <p class="text-xs text-gray-500">Ibu Kandung</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ibu']['nama'] }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pekerjaan</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ibu']['pekerjaan'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">No. Telepon</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ibu']['telepon'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['ibu']['alamat'] }}</p>
                </div>
            </div>
        </div>

        <!-- Data Wali -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Data Wali</h3>
                    <p class="text-xs text-gray-500">Jika ada</p>
                </div>
            </div>
            
            <div class="space-y-4">
                @if($orangtua['wali']['nama'] != '-')
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['wali']['nama'] }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pekerjaan</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['wali']['pekerjaan'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">No. Telepon</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['wali']['telepon'] }}</p>
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</label>
                    <p class="text-gray-800 font-medium">{{ $orangtua['wali']['alamat'] }}</p>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                    <i data-lucide="minus-circle" class="w-12 h-12 mb-2 opacity-50"></i>
                    <p>Tidak ada data wali</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
