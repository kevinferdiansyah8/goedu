@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')


<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Tugas</h1>
            <p class="text-gray-600">Kelola dan pantau tugas-tugas yang diberikan kepada siswa</p>
        </div>
        <button id="createTaskBtn" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Buat Tugas Baru
        </button>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-5 border border-blue-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-blue-200">
                <span class="text-xs text-blue-600 font-medium">+2 dari minggu lalu</span>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-5 border border-green-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">8</p>
                </div>
                <div class="bg-green-500 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-green-200">
                <span class="text-xs text-green-600 font-medium">Deadline mendatang</span>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-5 border border-yellow-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">Deadline Minggu Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">3</p>
                </div>
                <div class="bg-yellow-500 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-yellow-200">
                <span class="text-xs text-yellow-600 font-medium">Perlu perhatian</span>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-5 border border-purple-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Pengumpulan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">85%</p>
                </div>
                <div class="bg-purple-500 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-purple-200">
                <span class="text-xs text-purple-600 font-medium">+5% dari bulan lalu</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="mb-6 bg-gradient-to-br from-white to-gray-50 rounded-2xl p-5 border border-gray-100 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="relative">
                <select class="px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-300 appearance-none outline-none hover:border-gray-300 text-sm">
                    <option>Semua Kelas</option>
                    <option>X IPA 1</option>
                    <option>X IPA 2</option>
                    <option>X IPA 3</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            
            <div class="relative">
                <select class="px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-300 appearance-none outline-none hover:border-gray-300 text-sm">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Selesai</option>
                    <option>Mendatang</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            
            <div class="relative">
                <input type="text" placeholder="Cari tugas..." class="px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-300 placeholder-gray-400 text-sm w-48">
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition-all duration-300 flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            <button class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition-all duration-300 flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Ekspor
            </button>
        </div>
    </div>
</div>

<!-- Tabel Tugas -->
<div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-lg">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <th class="py-4 px-6 text-left">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-700">Judul Tugas</span>
                            <button class="ml-2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </div>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-700">Kelas</span>
                            <button class="ml-2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </div>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-700">Deadline</span>
                            <button class="ml-2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </div>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-700">Status</span>
                        </div>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-700">Pengumpulan</span>
                        </div>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <span class="font-semibold text-gray-700">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <!-- Task 1 -->
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2.5 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Latihan Persamaan Kuadrat</p>
                                <p class="text-sm text-gray-500 mt-1">Matematika - Bab 3</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">X IPA 1</span>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-900">20 Feb 2026</span>
                            <span class="text-sm text-gray-500 ml-2">(3 hari lagi)</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1.5 bg-green-100 text-green-800 text-xs font-medium rounded-full flex items-center w-fit">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="py-5 px-6">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">24/30 siswa</span>
                                <span class="font-medium text-gray-900">80%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Task 2 -->
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2.5 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Praktikum Kimia Dasar</p>
                                <p class="text-sm text-gray-500 mt-1">Kimia - Reaksi Asam Basa</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1.5 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">X IPA 2</span>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-900">18 Feb 2026</span>
                            <span class="text-sm text-yellow-600 font-medium ml-2">(Besok)</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full flex items-center w-fit">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            Deadline Dekat
                        </span>
                    </td>
                    <td class="py-5 px-6">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">28/32 siswa</span>
                                <span class="font-medium text-gray-900">88%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 88%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Task 3 -->
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <div class="bg-red-100 p-2.5 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Proyek Fisika: Hukum Newton</p>
                                <p class="text-sm text-gray-500 mt-1">Fisika - Dinamika Partikel</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">X IPA 1</span>
                            <span class="px-3 py-1.5 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">X IPA 3</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-900">15 Feb 2026</span>
                            <span class="text-sm text-gray-500 ml-2">(Selesai)</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-800 text-xs font-medium rounded-full flex items-center w-fit">
                            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                            Selesai
                        </span>
                    </td>
                    <td class="py-5 px-6">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">58/62 siswa</span>
                                <span class="font-medium text-gray-900">94%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 94%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200" title="Lihat Nilai">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="py-5 px-6 border-t border-gray-100 flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Menampilkan <span class="font-medium">1-3</span> dari <span class="font-medium">12</span> tugas
        </div>
        <div class="flex items-center space-x-2">
            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 


@endsection
