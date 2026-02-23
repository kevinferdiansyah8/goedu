@extends('layouts.admin')

@section('title', 'Input Nilai Rapor')

@php
    // Default mock data if $students is not provided
    $defaultStudents = [
        ['id' => 1, 'name' => 'Ahmad Fauzi', 'nis' => '20230101', 'score' => 88],
        ['id' => 2, 'name' => 'Budi Santoso', 'nis' => '20230103', 'score' => 72],
        ['id' => 3, 'name' => 'Citra Dewi', 'nis' => '20230105', 'score' => 95],
        ['id' => 4, 'name' => 'Dimas Pratama', 'nis' => '20230107', 'score' => 78],
        ['id' => 5, 'name' => 'Eka Putri', 'nis' => '20230109', 'score' => 65],
        ['id' => 6, 'name' => 'Fajar Nugraha', 'nis' => '20230111', 'score' => 82],
    ];
    $studentsData = $students ?? $defaultStudents;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-32" x-data="inputRaporPage()">
    
    {{-- PAGE HEADER--}}
    <div class="mb-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Input Nilai Rapor</h1>
                <p class="text-sm text-gray-500 mt-1">Masukkan nilai akhir rapor siswa semester ini.</p>
            </div>
            <div class="flex gap-3">
                <button @click="addStudent" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Siswa
                </button>
                <button @click="exportData" class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export Data
                </button>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Siswa --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1" x-text="students.length"></h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- Rata-rata --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1" x-text="classAverage"></h3>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-xl group-hover:bg-green-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
                </div>
            </div>
        </div>

        {{-- Tertinggi --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Tertinggi</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-1" x-text="highestScore"></h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"/></svg>
                </div>
            </div>
        </div>

        {{-- Terendah --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Terendah</p>
                    <h3 class="text-3xl font-bold text-red-600 mt-1" x-text="lowestScore"></h3>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-xl group-hover:bg-red-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <input type="text" x-model="searchQuery" placeholder="Cari nama atau NIS siswa..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-1 md:pb-0 w-full md:w-auto">
                <template x-for="grade in ['Semua', 'A', 'B', 'C', 'D']">
                    <button 
                        @click="filterGrade = grade"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-all whitespace-nowrap"
                        :class="filterGrade === grade ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        x-text="grade === 'Semua' ? 'Semua Predikat' : 'Predikat ' + grade"
                    ></button>
                </template>
            </div>
        </div>
    </div>

    {{-- MAIN TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-16">No</th>
                        <th class="px-6 py-4 font-semibold cursor-pointer hover:text-indigo-600 group" @click="sortBy('name')">
                            Nama Siswa <span class="text-gray-400 group-hover:text-indigo-600 ml-1">↕</span>
                        </th>
                        <th class="px-6 py-4 font-semibold">NIS</th>
                        <th class="px-6 py-4 font-semibold w-32 cursor-pointer hover:text-indigo-600 group" @click="sortBy('score')">
                            Nilai <span class="text-gray-400 group-hover:text-indigo-600 ml-1">↕</span>
                        </th>
                        <th class="px-6 py-4 font-semibold text-center w-24">Predikat</th>
                        <th class="px-6 py-4 font-semibold w-48">Progress</th>
                        <th class="px-6 py-4 font-semibold text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(student, index) in filteredStudents" :key="student.id">
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4 text-gray-500" x-text="index + 1"></td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900" x-text="student.name"></div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-mono" x-text="student.nis"></td>
                            <td class="px-6 py-4">
                                <input 
                                    type="number" 
                                    x-model.number="student.score"
                                    min="0" max="100"
                                    class="w-full px-3 py-2 text-center font-bold rounded-lg border-2 focus:outline-none transition-all"
                                    :class="{
                                        'border-gray-200 focus:border-indigo-500': student.score >= 0 && student.score <= 100,
                                        'border-red-300 bg-red-50 text-red-600 animate-pulse': student.score < 0 || student.score > 100
                                    }"
                                    @input="validateScore(student)"
                                >
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset"
                                    :class="getGradeColor(student.score)"
                                    x-text="calculateGrade(student.score)">
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-2.5 rounded-full transition-all duration-500"
                                        :style="`width: ${Math.min(100, Math.max(0, student.score))}%`"
                                        :class="{
                                            'bg-green-500': student.score >= 90,
                                            'bg-blue-500': student.score >= 80 && student.score < 90,
                                            'bg-yellow-400': student.score >= 70 && student.score < 80,
                                            'bg-red-500': student.score < 70
                                        }"
                                    ></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button @click="deleteStudent(student.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    
                    {{-- Empty State --}}
                    <tr x-show="filteredStudents.length === 0">
                        <td colspan="7" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-lg font-medium text-gray-500">Tidak ada siswa ditemukan</p>
                                <p class="text-sm">Coba ubah filter atau kata kunci pencarian</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- FOOTER ACTIONS --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-40 md:pl-64">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <button @click="resetAll" class="px-6 py-2.5 text-gray-600 hover:text-red-600 bg-gray-50 hover:bg-red-50 rounded-xl transition-all font-medium border border-gray-200">
                🔄 Reset Semua
            </button>
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="saveDraft" class="flex-1 md:flex-none px-6 py-2.5 bg-yellow-500 text-white font-bold rounded-xl hover:bg-yellow-600 hover:shadow-lg hover:shadow-yellow-200 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Simpan Draft
                </button>
                <button @click="saveFinal" class="flex-1 md:flex-none px-8 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 hover:shadow-lg hover:shadow-blue-200 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Simpan Final
                </button>
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
        class="fixed bottom-24 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-md"
        :class="{
            'bg-green-600/90 text-white': toast.type === 'success',
            'bg-yellow-500/90 text-white': toast.type === 'warning',
            'bg-blue-600/90 text-white': toast.type === 'info',
            'bg-red-600/90 text-white': toast.type === 'error'
        }"
        style="display: none;"
    >
        <span x-text="toast.message" class="font-medium"></span>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inputRaporPage', () => ({
            searchQuery: '',
            filterGrade: 'Semua',
            sortCol: 'name',
            sortAsc: true,
            toast: { visible: false, message: '', type: 'success' },

            // Using pure JSON data from PHP
            students: @json($studentsData),

            get filteredStudents() {
                let result = this.students.filter(s => {
                    const matchesSearch = s.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                          s.nis.includes(this.searchQuery);
                    const grade = this.calculateGrade(s.score);
                    const matchesGrade = this.filterGrade === 'Semua' || grade === this.filterGrade;
                    return matchesSearch && matchesGrade;
                });

                return result.sort((a, b) => {
                    let valA = a[this.sortCol];
                    let valB = b[this.sortCol];
                    
                    if (typeof valA === 'string') valA = valA.toLowerCase();
                    if (typeof valB === 'string') valB = valB.toLowerCase();

                    if (valA < valB) return this.sortAsc ? -1 : 1;
                    if (valA > valB) return this.sortAsc ? 1 : -1;
                    return 0;
                });
            },

            // Stats Getters
            get classAverage() {
                if (this.students.length === 0) return 0;
                const sum = this.students.reduce((acc, s) => acc + (parseInt(s.score) || 0), 0);
                return (sum / this.students.length).toFixed(1);
            },
            get highestScore() {
                if (this.students.length === 0) return 0;
                return Math.max(...this.students.map(s => parseInt(s.score) || 0));
            },
            get lowestScore() {
                if (this.students.length === 0) return 0;
                return Math.min(...this.students.map(s => parseInt(s.score) || 0));
            },

            // Logic
            calculateGrade(score) {
                if (score >= 90) return 'A';
                if (score >= 80) return 'B';
                if (score >= 70) return 'C';
                if (score < 70) return 'D';
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

            validateScore(student) {
                if (student.score > 100) student.score = 100;
                if (student.score < 0) student.score = 0;
            },

            sortBy(col) {
                if (this.sortCol === col) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }
            },

            // Actions
            addStudent() {
                const name = prompt("Nama Siswa:");
                if(name) {
                    const nis = prompt("NIS:");
                    this.students.push({
                        id: Date.now(),
                        name: name,
                        nis: nis || '2023xxxx',
                        score: 75
                    });
                    this.showToast(`Siswa ${name} ditambahkan`, 'success');
                }
            },

            deleteStudent(id) {
                if(confirm('Hapus siswa ini?')) {
                    this.students = this.students.filter(s => s.id !== id);
                    this.showToast('Siswa dihapus', 'info');
                }
            },

            resetAll() {
                if(confirm('Reset semua nilai ke 0?')) {
                    this.students.forEach(s => s.score = 0);
                    this.showToast('Semua nilai direset', 'warning');
                }
            },

            saveDraft() {
                this.showToast('Draft berhasil disimpan', 'warning');
                // Simulate API call
            },

            saveFinal() {
                this.showToast('Data Rapor berhasil disimpan permanen! 🎉', 'success');
                // Simulate API call
            },

            exportData() {
                this.showToast('Mengekspor data ke Excel...', 'info');
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
