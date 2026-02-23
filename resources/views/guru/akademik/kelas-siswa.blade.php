@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="kelasSiswaPage()">
    
    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Daftar Kelas & Siswa</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen data siswa dan pemantauan aktivitas kelas.</p>
    </div>

    {{-- ANALYTICS SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        {{-- Card 1: Total Kelas --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kelas</div>
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">3</div>
            <div class="text-xs text-gray-500 mt-1">Kelas Aktif</div>
        </div>

        {{-- Card 2: Total Siswa --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Siswa</div>
                <div class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">108</div>
            <div class="text-xs text-green-600 mt-1 font-medium flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                100% Aktif
            </div>
        </div>

        {{-- Card 3: Izin Hari Ini --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Izin Hari Ini</div>
                <div class="p-1.5 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">4</div>
            <div class="text-xs text-gray-500 mt-1">Siswa</div>
        </div>

        {{-- Card 4: Alpha --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Alpha</div>
                <div class="p-1.5 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">2</div>
            <div class="text-xs text-red-500 mt-1 font-medium">+1 dr kmrn</div>
        </div>

        {{-- Card 5: Kehadiran Mingguan --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Absensi Week</div>
                <div class="p-1.5 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">94%</div>
            <div class="text-xs text-gray-500 mt-1">Rata-rata</div>
        </div>
    </div>

    {{-- CLASS INFO CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full opacity-50 pointer-events-none"></div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-2xl font-bold text-gray-900" x-text="selectedClass"></h2>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full border border-green-200">Aktif</span>
                </div>
                <p class="text-gray-500 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Wali Kelas: Bp. Budi Santoso
                    <span class="text-gray-300">•</span>
                    <span>36 Siswa</span>
                </p>
            </div>
            <div class="flex gap-3">
                <a href="#" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors shadow-sm flex items-center justify-center">
                    Lihat Jadwal
                </a>
                <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200 flex items-center justify-center">
                    Input Nilai
                </a>
            </div>
        </div>
        
        <div class="mt-6">
            <div class="flex justify-between text-xs font-medium text-gray-500 mb-1">
                <span>Kehadiran Hari Ini</span>
                <span class="text-gray-900">32/36 Hadir (89%)</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: 89%"></div>
            </div>
        </div>
    </div>

    {{-- FILTER & CONTROLS --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-6 bg-white p-2 rounded-2xl shadow-sm border border-gray-200">
        
        {{-- Left Filters --}}
        <div class="flex flex-wrap gap-2 items-center w-full lg:w-auto">
            <select x-model="selectedClass" class="text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                <option value="X IPA 1">X IPA 1 (36)</option>
                <option value="X IPA 2">X IPA 2 (35)</option>
                <option value="XI IPA 1">XI IPA 1 (34)</option>
            </select>

            <select x-model="filterStatus" class="text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="izin">Izin/Sakit</option>
                <option value="alpha">Alpha</option>
            </select>

            <div class="relative flex-grow lg:flex-grow-0">
                <input type="text" x-model="searchQuery" placeholder="Cari Siswa..." class="w-full lg:w-48 text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg pl-9 pr-3 py-2 font-medium placeholder-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <button @click="resetFilters()" class="p-2 text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors" title="Reset Filters">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </button>
        </div>

        {{-- Right Controls --}}
        <div class="flex items-center gap-2 w-full lg:w-auto justify-end">
            <div class="bg-gray-100 p-1 rounded-lg flex">
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="p-1.5 rounded-md transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </button>
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="p-1.5 rounded-md transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
            </div>
            <button class="flex items-center gap-2 px-3 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span class="hidden sm:inline">Export</span>
            </button>
        </div>
    </div>

    {{-- TABLE VIEW --}}
    <div x-show="viewMode === 'table'" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" @click="sortBy('name')">
                            Siswa
                            <span x-show="sortCol === 'name'" class="ml-1 inline-block text-gray-400">↓</span>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran (Bulan Ini)</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="(student, index) in filteredStudents" :key="student.id">
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="index + 1"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center cursor-pointer" @click="openModal(student)">
                                    <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs ring-2 ring-white shadow-sm mr-3">
                                        <span x-text="getInitials(student.name)"></span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors" x-text="student.name"></div>
                                        <div class="text-xs text-gray-500">Laki-laki</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-mono" x-text="student.nis"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full"
                                    :class="{
                                        'bg-green-100 text-green-800': student.status === 'Aktif',
                                        'bg-yellow-100 text-yellow-800': student.status === 'Izin',
                                        'bg-red-100 text-red-800': student.status === 'Alpha',
                                        'bg-gray-100 text-gray-800': student.status === 'Tidak Aktif'
                                    }" x-text="student.status">
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <span class="text-xs font-bold mr-2 text-gray-700" x-text="student.attendance + '%'"></span>
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full" 
                                            :class="student.attendance >= 80 ? 'bg-green-500' : (student.attendance >= 50 ? 'bg-yellow-500' : 'bg-red-500')"
                                            :style="`width: ${student.attendance}%`"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openModal(student)" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <div class="text-sm text-gray-500">Menampilkan 1-10 dari 36 siswa</div>
            <div class="flex gap-1">
                <button class="px-3 py-1 text-sm border rounded-lg text-gray-500 hover:bg-gray-50 disabled:opacity-50">Prev</button>
                <button class="px-3 py-1 text-sm border rounded-lg bg-blue-50 text-blue-600 font-medium">1</button>
                <button class="px-3 py-1 text-sm border rounded-lg text-gray-500 hover:bg-gray-50">2</button>
                <button class="px-3 py-1 text-sm border rounded-lg text-gray-500 hover:bg-gray-50">3</button>
                <button class="px-3 py-1 text-sm border rounded-lg text-gray-500 hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>

    {{-- GRID VIEW --}}
    <div x-show="viewMode === 'grid'" x-transition class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <template x-for="student in filteredStudents" :key="student.id">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative group">
                 <div class="absolute top-4 right-4">
                    <button class="text-gray-300 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                    </button>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl mb-4 ring-4 ring-white shadow-sm">
                        <span x-text="getInitials(student.name)"></span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-1" x-text="student.name"></h3>
                    <p class="text-gray-500 text-sm font-mono mb-4" x-text="student.nis"></p>
                    
                    <span class="px-3 py-1 rounded-full text-xs font-semibold mb-6"
                        :class="{
                            'bg-green-100 text-green-700': student.status === 'Aktif',
                            'bg-yellow-100 text-yellow-700': student.status === 'Izin',
                            'bg-red-100 text-red-700': student.status === 'Alpha'
                        }" x-text="student.status">
                    </span>

                    <div class="w-full bg-gray-50 p-3 rounded-xl flex justify-between items-center mb-4">
                        <span class="text-xs text-gray-500 font-medium">Kehadiran</span>
                        <span class="text-sm font-bold text-gray-900" x-text="student.attendance + '%'"></span>
                    </div>

                    <button @click="openModal(student)" class="w-full py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 text-sm transition-colors">
                        Lihat Profil
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- STUDENT DETAIL MODAL --}}
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <div class="relative">
                     {{-- Modal Close Button --}}
                    <button @click="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-white rounded-full p-1 z-10 hover:bg-gray-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>

                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-24 sm:h-32"></div>
                    
                    <div class="px-6 sm:px-8 pb-8">
                        <div class="relative -mt-12 mb-6 flex justify-between items-end">
                            <div class="h-24 w-24 rounded-full bg-white p-1 shadow-lg">
                                <div class="h-full w-full rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl">
                                    <span x-text="selectedStudent ? getInitials(selectedStudent.name) : ''"></span>
                                </div>
                            </div>
                            <div class="flex gap-2 mb-2">
                                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Message Parent
                                </button>
                                <button class="px-4 py-2 bg-blue-600 rounded-lg text-sm font-medium text-white hover:bg-blue-700 shadow-sm">
                                    Edit Profil
                                </button>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-gray-900" x-text="selectedStudent?.name"></h3>
                            <p class="text-gray-500 text-sm">NIS: <span x-text="selectedStudent?.nis"></span> • Kelas X IPA 1</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-xl text-center">
                                <div class="text-xs text-gray-500 uppercase font-semibold mb-1">Kehadiran</div>
                                <div class="text-xl font-bold text-blue-600" x-text="selectedStudent?.attendance + '%'"></div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl text-center">
                                <div class="text-xs text-gray-500 uppercase font-semibold mb-1">Peringkat</div>
                                <div class="text-xl font-bold text-purple-600">5</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl text-center">
                                <div class="text-xs text-gray-500 uppercase font-semibold mb-1">Point Pelanggaran</div>
                                <div class="text-xl font-bold text-red-600">0</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Catatan Guru</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
                                <p>"Siswa sangat aktif di kelas, namun perlu ditingkatkan ketelitiannya dalam mengerjakan tugas matematika."</p>
                                <div class="mt-2 text-xs text-yellow-600 font-semibold">— Bp. Budi Santoso (Wali Kelas)</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kelasSiswaPage', () => ({
            viewMode: 'table', // table, grid
            selectedClass: 'X IPA 1',
            searchQuery: '',
            filterStatus: 'all',
            showModal: false,
            selectedStudent: null,
            sortCol: 'name',

            students: [
                { id: 1, name: 'Ahmad Fauzi', nis: '20230101', status: 'Aktif', attendance: 95 },
                { id: 2, name: 'Budi Santoso', nis: '20230102', status: 'Izin', attendance: 80 },
                { id: 3, name: 'Citra Kirana', nis: '20230103', status: 'Aktif', attendance: 92 },
                { id: 4, name: 'Dewi Lestari', nis: '20230104', status: 'Aktif', attendance: 88 },
                { id: 5, name: 'Eko Kurniawan', nis: '20230105', status: 'Alpha', attendance: 60 },
                { id: 6, name: 'Fajar Nugraha', nis: '20230106', status: 'Aktif', attendance: 98 },
            ],

            get filteredStudents() {
                let result = this.students;
                
                // Filter Status
                if (this.filterStatus !== 'all') {
                    if(this.filterStatus === 'active') result = result.filter(s => s.status === 'Aktif');
                    if(this.filterStatus === 'izin') result = result.filter(s => ['Izin', 'Sakit'].includes(s.status));
                    if(this.filterStatus === 'alpha') result = result.filter(s => s.status === 'Alpha');
                }

                // Search
                if (this.searchQuery) {
                    const lower = this.searchQuery.toLowerCase();
                    result = result.filter(s => s.name.toLowerCase().includes(lower) || s.nis.includes(lower));
                }

                // Sort (Simpel Name Sort)
                if (this.sortCol === 'name') {
                    result = result.sort((a, b) => a.name.localeCompare(b.name));
                }

                return result;
            },

            openModal(student) {
                this.selectedStudent = student;
                this.showModal = true;
            },
            
            closeModal() {
                this.showModal = false;
                setTimeout(() => { this.selectedStudent = null; }, 300);
            },

            getInitials(name) {
                if (!name) return '';
                return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            },

            resetFilters() {
                this.selectedClass = 'X IPA 1';
                this.searchQuery = '';
                this.filterStatus = 'all';
            },
            
            sortBy(col) {
                this.sortCol = col;
            }
        }));
    });
</script>
@endpush
@endsection
