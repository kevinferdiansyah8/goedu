@extends('layouts.admin')

@section('title', 'Nilai Terbaru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Nilai Terbaru</h1>
        <p class="text-gray-600">Pantau perkembangan akademik siswa.</p>
    </div>

    <!-- Filter/Semester Selection -->
     <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <label for="semester" class="text-sm font-medium text-gray-700">Pilih Semester:</label>
        <select id="semester" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
            <option>Semester Ganjil 2023/2024</option>
            <option>Semester Genap 2023/2024</option>
        </select>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nilai Tugas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i data-lucide="book-open" class="w-4 h-4 text-blue-500"></i> Nilai Tugas Harian
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    <!-- Item -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Matematika</p>
                            <p class="text-xs text-gray-500">Tugas 1 - Aljabar</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">90</span>
                    </div>
                     <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Bahasa Indonesia</p>
                            <p class="text-xs text-gray-500">Puisi</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">85</span>
                    </div>
                     <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">IPA</p>
                            <p class="text-xs text-gray-500">Praktikum</p>
                        </div>
                        <span class="text-lg font-bold text-blue-600">88</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Ujian -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                     <i data-lucide="file-text" class="w-4 h-4 text-purple-500"></i> Nilai Ujian (UTS/UAS)
                </h3>
            </div>
            <div class="p-4">
               <div class="space-y-4">
                    <!-- Item -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Matematika</p>
                            <p class="text-xs text-gray-500">UTS</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">85</span>
                    </div>
                     <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Bahasa Inggris</p>
                            <p class="text-xs text-gray-500">UTS</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">92</span>
                    </div>
                     <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">IPS</p>
                            <p class="text-xs text-gray-500">UTS</p>
                        </div>
                        <span class="text-lg font-bold text-yellow-600">78</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
