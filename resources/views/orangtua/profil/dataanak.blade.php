@extends('layouts.admin')

@section('title', 'Data Anak')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Anak</h1>
        <p class="text-gray-600">Informasi siswa (putra/putri).</p>
    </div>

    <!-- Student 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
             <div class="flex items-center gap-4">
                 <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                 </div>
                 <div>
                     <h3 class="font-bold text-gray-800">Muhammad Rizky</h3>
                     <p class="text-xs text-gray-500">NISN: 0012345678</p>
                 </div>
             </div>
             <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Kelas Saat Ini</span>
                    <span class="font-medium text-gray-800">X-RPL-1</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Tempat, Tanggal Lahir</span>
                    <span class="font-medium text-gray-800">Bandung, 10 Jan 2008</span>
                </div>
                 <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Jenis Kelamin</span>
                    <span class="font-medium text-gray-800">Laki-laki</span>
                </div>
                 <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Wali Kelas</span>
                    <span class="font-medium text-gray-800">Ibu Ratna S.Pd.</span>
                </div>
                 <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Tahun Masuk</span>
                    <span class="font-medium text-gray-800">2023</span>
                </div>
                 <div class="flex justify-between border-b border-gray-50 py-2">
                    <span class="text-gray-500">Alamat Email Sekolah</span>
                    <span class="font-medium text-gray-800">rizky@siswa.goedu.ac.id</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Student 2 (Example if multiple children) -->
     <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden opacity-75">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
             <div class="flex items-center gap-4">
                 <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    <i data-lucide="user" class="w-6 h-6"></i>
                 </div>
                 <div>
                     <h3 class="font-bold text-gray-800">Siti Aminah</h3>
                     <p class="text-xs text-gray-500">NISN: - </p>
                 </div>
             </div>
             <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-semibold">Alumni (2020)</span>
        </div>
    </div>
</div>
@endsection
