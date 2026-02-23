@extends('layouts.admin')

@section('title', 'Rekap Nilai Kelas')

@php
// Robust Mock Data Definition in PHP
$mockStudents = [
    ['id' => 1, 'name' => 'Ahmad Fauzi', 'nis' => '20230101', 'score' => 95, 'class' => 'X IPA 1'],
    ['id' => 2, 'name' => 'Budi Santoso', 'nis' => '20230102', 'score' => 78, 'class' => 'X IPA 1'],
    ['id' => 3, 'name' => 'Citra Kirana', 'nis' => '20230103', 'score' => 88, 'class' => 'X IPA 1'],
    ['id' => 4, 'name' => 'Dewi Lestari', 'nis' => '20230104', 'score' => 92, 'class' => 'X IPA 1'],
    ['id' => 5, 'name' => 'Eko Prasetyo', 'nis' => '20230105', 'score' => 65, 'class' => 'X IPA 1'],
    ['id' => 6, 'name' => 'Fina Anindya', 'nis' => '20230106', 'score' => 85, 'class' => 'X IPA 1'],
    ['id' => 7, 'name' => 'Gilang Ramadhan', 'nis' => '20230107', 'score' => 72, 'class' => 'X IPA 1'],
    ['id' => 8, 'name' => 'Hana Pertiwi', 'nis' => '20230108', 'score' => 90, 'class' => 'X IPA 1'],
    ['id' => 9, 'name' => 'Indra Wijaya', 'nis' => '20230109', 'score' => 81, 'class' => 'X IPA 1'],
    ['id' => 10, 'name' => 'Joko Susilo', 'nis' => '20230110', 'score' => 68, 'class' => 'X IPA 1'],
    ['id' => 11, 'name' => 'Kurnia Sari', 'nis' => '20230111', 'score' => 98, 'class' => 'X IPA 1'],
    ['id' => 12, 'name' => 'Lukman Hakim', 'nis' => '20230112', 'score' => 75, 'class' => 'X IPA 1'],
];

// Use isset safely for production fallback
$studentsData = $students ?? $mockStudents;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="rekapNilaiPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Rekap Nilai Kelas</h1>
                <p class="text-sm text-gray-500 mt-1">Analisis dan ringkasan performa akademik siswa semester ini.</p>
            </div>
            
            <div class="flex flex-wrap gap-3 items-center">
                {{-- Filter Kelas --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                        <option>Kelas X IPA 1</option>
                        <option>Kelas X IPA 2</option>
                        <option>Kelas XI IPA 1</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Filter Semester --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                        <option>Semester Ganjil 2023/2024</option>
                        <option>Semester Genap 2023/2024</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <div class="w-px h-8 bg-gray-300 mx-1 hidden sm:block"></div>

                {{-- Export Buttons --}}
                <button @click="showToast('Export PDF berhasil', 'success')" class="p-2.5 bg-white border border-gray-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-200 transition-all shadow-sm tooltip" title="Export PDF">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </button>
                <button @click="showToast('Export Excel berhasil', 'success')" class="p-2.5 bg-white border border-gray-200 text-green-600 rounded-xl hover:bg-green-50 hover:border-green-200 transition-all shadow-sm tooltip" title="Export Excel">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Rata-rata --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-l-blue-500 border-y border-r border-gray-100/50 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Kelas</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-gray-900" x-text="stats.average"></h3>
                    <span class="text-xs font-medium text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded-md">
                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        +2.4%
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-2">vs Semester Lalu</p>
            </div>
        </div>

        {{-- Tertinggi --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-l-emerald-500 border-y border-r border-gray-100/50 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nilai Tertinggi</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-emerald-600" x-text="stats.highest"></h3>
                </div>
                <p class="text-xs text-gray-400 mt-2" x-text="'Oleh: ' + stats.highestStudent"></p>
            </div>
        </div>

        {{-- Terendah --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-l-red-500 border-y border-r border-gray-100/50 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nilai Terendah</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-red-600" x-text="stats.lowest"></h3>
                    <span class="text-xs font-medium text-red-600 flex items-center bg-red-50 px-1.5 py-0.5 rounded-md">
                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        -1.2%
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-2">Perlu Bimbingan</p>
            </div>
        </div>

        {{-- Jumlah Siswa --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-l-purple-500 border-y border-r border-gray-100/50 hover:shadow-md transition-all group relative overflow-hidden">
             <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Siswa</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-gray-900" x-text="students.length"></h3>
                    <span class="text-xs font-medium text-gray-500">Siswa</span>
                </div>
                <p class="text-xs text-green-600 mt-2 font-medium">100% Data Masuk</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- CHART SECTION --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 lg:col-span-1 flex flex-col justify-center items-center">
            <h3 class="text-lg font-bold text-gray-800 mb-6 w-full text-left">Distribusi Predikat</h3>
            <div class="w-64 h-64 relative">
                <canvas id="gradeDistributionChart"></canvas>
            </div>
        </div>

        {{-- MAIN TABLE SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 lg:col-span-2 flex flex-col">
            {{-- Table Filter Header --}}
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-lg font-bold text-gray-800">Peringkat Kelas</h3>
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="searchQuery" placeholder="Cari siswa..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-6 py-4 font-semibold w-16 text-center">Rank</th>
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold text-center">Nilai</th>
                            <th class="px-6 py-4 font-semibold text-center">Predikat</th>
                            <th class="px-6 py-4 font-semibold w-48">Progress</th>
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(student, index) in filteredStudents" :key="student.id">
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center">
                                        <template x-if="index === 0">
                                            <span class="w-8 h-8 flex items-center justify-center bg-yellow-100 text-yellow-700 rounded-full font-bold ring-2 ring-yellow-400/30 shadow-sm">1</span>
                                        </template>
                                        <template x-if="index === 1">
                                            <span class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-700 rounded-full font-bold ring-2 ring-gray-400/30 shadow-sm">2</span>
                                        </template>
                                        <template x-if="index === 2">
                                            <span class="w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-800 rounded-full font-bold ring-2 ring-orange-400/30 shadow-sm">3</span>
                                        </template>
                                        <template x-if="index > 2">
                                            <span class="text-gray-500 font-medium" x-text="index + 1"></span>
                                        </template>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900" x-text="student.name"></div>
                                    <div class="text-xs text-gray-400 font-mono mt-0.5" x-text="student.nis"></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-base font-bold text-gray-900" x-text="student.score"></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset"
                                        :class="getGradeColor(student.score)"
                                        x-text="calculateGrade(student.score)">
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500"
                                            :style="`width: ${Math.min(100, Math.max(0, student.score))}%`"
                                            :class="getProgressColor(student.score)"
                                        ></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <template x-if="student.score >= 70">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Lulus</span>
                                    </template>
                                    <template x-if="student.score < 70">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Remedial</span>
                                    </template>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button @click="openDetail(student)" class="text-blue-600 hover:text-blue-800 font-medium text-xs hover:underline">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        </template>
                        
                        <tr x-show="filteredStudents.length === 0">
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                Tidak ada data siswa ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                <span>Menampilkan <strong x-text="filteredStudents.length"></strong> siswa</span>
                <div class="flex gap-2">
                     <button class="px-3 py-1 rounded-lg border border-gray-200 hover:bg-gray-50 disabled:opacity-50" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL MODAL --}}
    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="modalOpen = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="modalOpen" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start justify-between">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2">Detail Nilai Siswa</h3>
                            <div class="border-t border-gray-100 pt-4" x-data="{ tabs: 'detail' }">
                                <template x-if="selectedStudent">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                                                <span x-text="selectedStudent.name.charAt(0)"></span>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900" x-text="selectedStudent.name"></h4>
                                                <p class="text-sm text-gray-500" x-text="selectedStudent.nis"></p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <div class="text-2xl font-bold" :class="studentColor(selectedStudent.score)" x-text="selectedStudent.score"></div>
                                                <div class="text-xs text-gray-500">Nilai Akhir</div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                <p class="text-xs text-gray-500 mb-1">Tugas</p>
                                                <p class="font-bold text-gray-800" x-text="Math.min(100, selectedStudent.score + 5)">85</p>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                <p class="text-xs text-gray-500 mb-1">UTS</p>
                                                <p class="font-bold text-gray-800" x-text="selectedStudent.score">80</p>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                <p class="text-xs text-gray-500 mb-1">UAS</p>
                                                <p class="font-bold text-gray-800" x-text="Math.max(0, selectedStudent.score - 5)">75</p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="modalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Tutup
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cetak Rapor
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- TOAST --}}
    <div 
        x-show="toast.visible" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        class="fixed bottom-6 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-md"
        :class="{
            'bg-green-600/90 text-white': toast.type === 'success',
            'bg-blue-600/90 text-white': toast.type === 'info',
        }"
        style="display: none;"
    >
        <span x-text="toast.message" class="font-medium"></span>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rekapNilaiPage', () => ({
            searchQuery: '',
            modalOpen: false,
            selectedStudent: null,
            chartInstance: null,
            toast: { visible: false, message: '', type: 'success' },
            
            students: @json($studentsData),

            init() {
                this.$nextTick(() => {
                    this.initChart();
                });
                
                // Refresh chart when data changes (mock simulation)
                this.$watch('students', () => {
                    this.updateChart();
                });
            },

            get filteredStudents() {
                let sorted = [...this.students].sort((a, b) => b.score - a.score); // Default Rank Sort
                if (this.searchQuery) {
                    sorted = sorted.filter(s => s.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
                }
                return sorted;
            },

            // stats
            get stats() {
                if (this.students.length === 0) return { average: 0, highest: 0, lowest: 0, highestStudent: '-' };
                const scores = this.students.map(s => s.score);
                const highest = Math.max(...scores);
                const highestStudent = this.students.find(s => s.score === highest)?.name || '-';
                
                return {
                    average: (scores.reduce((a, b) => a + b, 0) / scores.length).toFixed(1),
                    highest: highest,
                    lowest: Math.min(...scores),
                    highestStudent: highestStudent
                };
            },

            // chart
            get gradeDistribution() {
                const distribution = { 'A': 0, 'B': 0, 'C': 0, 'D': 0 };
                this.students.forEach(s => {
                    distribution[this.calculateGrade(s.score)]++;
                });
                return Object.values(distribution);
            },

            initChart() {
                const ctx = document.getElementById('gradeDistributionChart');
                if(!ctx) return;

                this.chartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['A (Sangat Baik)', 'B (Baik)', 'C (Cukup)', 'D (Kurang)'],
                        datasets: [{
                            data: this.gradeDistribution,
                            backgroundColor: [
                                '#10B981', // Green A
                                '#3B82F6', // Blue B
                                '#F59E0B', // Yellow C
                                '#EF4444'  // Red D
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            }
                        },
                        cutout: '70%',
                    }
                });
            },

            updateChart() {
                if(this.chartInstance) {
                    this.chartInstance.data.datasets[0].data = this.gradeDistribution;
                    this.chartInstance.update();
                }
            },

            // helpers
            calculateGrade(score) {
                if (score >= 90) return 'A';
                if (score >= 80) return 'B';
                if (score >= 70) return 'C';
                return 'D';
            },

            getGradeColor(score) {
                const grade = this.calculateGrade(score);
                const colors = {
                    'A': 'bg-green-100 text-green-700 ring-green-600/20',
                    'B': 'bg-blue-100 text-blue-700 ring-blue-600/20',
                    'C': 'bg-yellow-100 text-yellow-700 ring-yellow-600/20',
                    'D': 'bg-red-100 text-red-700 ring-red-600/20',
                };
                return colors[grade];
            },

            getProgressColor(score) {
                if (score >= 90) return 'bg-green-500';
                if (score >= 80) return 'bg-blue-500';
                if (score >= 70) return 'bg-yellow-400';
                return 'bg-red-500';
            },

            studentColor(score) {
                if (score >= 90) return 'text-green-600';
                if (score >= 80) return 'text-blue-600';
                if (score >= 70) return 'text-yellow-600';
                return 'text-red-600';
            },

            // actions
            openDetail(student) {
                this.selectedStudent = student;
                this.modalOpen = true;
            },

            showToast(msg, type = 'success') {
                this.toast.message = msg;
                this.toast.type = type;
                this.toast.visible = true;
                setTimeout(() => this.toast.visible = false, 3000);
            }
        }));
    });
</script>
@endpush
@endsection