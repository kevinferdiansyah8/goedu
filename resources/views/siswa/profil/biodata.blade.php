@extends('layouts.admin')

@section('title', 'Biodata Siswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Biodata Diri</h1>
        <p class="text-gray-600">Informasi lengkap data diri siswa.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 bg-gray-50 p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                    <img src="{{ $siswa['foto'] }}" alt="{{ $siswa['nama'] }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-bold text-gray-800 text-center">{{ $siswa['nama'] }}</h2>
                <p class="text-blue-600 font-medium">{{ $siswa['nis'] }} / {{ $siswa['nisn'] }}</p>
                <div class="mt-4 px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                    Kelas {{ $siswa['kelas'] }}
                </div>
            </div>
            <div class="md:w-2/3 p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-medium text-gray-800">{{ $siswa['nama'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jenis Kelamin</p>
                        <p class="font-medium text-gray-800">{{ $siswa['jenis_kelamin'] }}</p>
                    </div>
                    <div>
                         <p class="text-sm text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                         <p class="font-medium text-gray-800">{{ $siswa['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($siswa['tanggal_lahir'])->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Agama</p>
                        <p class="font-medium text-gray-800">{{ $siswa['agama'] }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">Alamat Lengkap</p>
                        <p class="font-medium text-gray-800">{{ $siswa['alamat'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="font-medium text-gray-800">{{ $siswa['telepon'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="font-medium text-gray-800">{{ $siswa['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
