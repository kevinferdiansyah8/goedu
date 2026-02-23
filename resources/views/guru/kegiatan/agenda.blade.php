@extends('layouts.admin')

@section('title', 'Agenda Guru')

@php
// Mock Data for Agenda
$mockAgendas = [
    [
        'id' => 1,
        'title' => 'Rapat Guru Semester Genap',
        'type' => 'Sekolah',
        'date' => date('Y-m-d', strtotime('+2 days')),
        'start_time' => '08:00',
        'end_time' => '10:00',
        'location' => 'Ruang Meeting Lt. 2',
        'status' => 'upcoming',
        'description' => 'Pembahasan kurikulum baru dan evaluasi semester ganjil.'
    ],
    [
        'id' => 2,
        'title' => 'Ulangan Harian Bab 3',
        'type' => 'Mengajar',
        'date' => date('Y-m-d'),
        'start_time' => '10:30',
        'end_time' => '12:00',
        'location' => 'Kelas X IPA 1',
        'status' => 'today',
        'description' => 'Materi Biologi: Sistem Pencernaan Manusia.'
    ],
    [
        'id' => 3,
        'title' => 'Input Nilai Tugas',
        'type' => 'Administrasi',
        'date' => date('Y-m-d', strtotime('-1 day')),
        'start_time' => '13:00',
        'end_time' => '15:00',
        'location' => 'Ruang Guru',
        'status' => 'done',
        'description' => 'Deadline pengisian nilai tugas harian ke-2.'
    ],
    [
        'id' => 4,
        'title' => 'Pelatihan Canva untuk Pembelajaran',
        'type' => 'Pelatihan',
        'date' => date('Y-m-d', strtotime('+5 days')),
        'start_time' => '09:00',
        'end_time' => '14:00',
        'location' => 'Lab Komputer 1',
        'status' => 'upcoming',
        'description' => 'Wajib bagi guru yang belum mengikuti pelatihan tahap 1.'
    ],
    [
        'id' => 5,
        'title' => 'Penerimaan Raport Tengah Semester',
        'type' => 'Sekolah',
        'date' => date('Y-m-d', strtotime('+10 days')),
        'start_time' => '08:00',
        'end_time' => '12:00',
        'location' => 'Kelas Masing-masing',
        'status' => 'upcoming',
        'description' => 'Wali kelas harap mempersiapkan berkas administrasi.'
    ],
];

// PHP Fallback logic
$agendaData = $agendas ?? $mockAgendas;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="agendaPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Agenda Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola jadwal kegiatan mengajar dan aktivitas sekolah Anda.</p>
        </div>
        
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Toggle View --}}
            <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 flex">
                <button @click="viewMode = 'list'" :class="{ 'bg-blue-50 text-blue-600 shadow-sm': viewMode === 'list', 'text-gray-500 hover:bg-gray-50': viewMode !== 'list' }" class="p-2 rounded-lg transition-all" title="List View">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </button>
                <button @click="viewMode = 'calendar'" :class="{ 'bg-blue-50 text-blue-600 shadow-sm': viewMode === 'calendar', 'text-gray-500 hover:bg-gray-50': viewMode !== 'calendar' }" class="p-2 rounded-lg transition-all" title="Calendar View">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </button>
            </div>

            <div class="w-px h-8 bg-gray-300 mx-1 hidden sm:block"></div>

            {{-- Filter --}}
            <div class="relative">
                <select x-model="filterType" class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                    <option value="all">Semua Kategori</option>
                    <option value="Mengajar">Mengajar</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Rapat">Rapat</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            {{-- Add Button --}}
            <button class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow hover:bg-blue-700 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Agenda
            </button>
        </div>
    </div>

    {{-- SUMMARY STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Agenda</span>
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="agendas.length"></h3>
                <p class="text-xs text-gray-500 mt-1">Bulan Ini</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Hari Ini</span>
                <span class="p-1.5 bg-orange-50 text-orange-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="todayCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Perlu diselesaikan</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
             <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Mendatang</span>
                <span class="p-1.5 bg-gray-50 text-gray-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="upcomingCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Agenda Terjadwal</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
             <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Selesai</span>
                <span class="p-1.5 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-green-600" x-text="doneCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Agenda Tuntas</p>
            </div>
        </div>
    </div>

    {{-- LIST VIEW --}}
    <div x-show="viewMode === 'list'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        
        {{-- Search & Sort Bar --}}
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-t-2xl border-x border-t border-gray-200 gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" x-model="searchQuery" placeholder="Cari nama agenda atau lokasi..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span>Urutkan:</span>
                <select x-model="sortOrder" class="border-none bg-transparent font-semibold text-gray-700 focus:ring-0 cursor-pointer p-0 pr-6">
                    <option value="asc">Terbaru (Hari Ini)</option>
                    <option value="desc">Terlama</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-b-2xl shadow-sm border border-gray-200 overflow-hidden">
            <template x-for="(agenda, index) in filteredAgendas" :key="agenda.id">
                <div class="group p-5 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row gap-4 sm:items-center">
                    
                    {{-- Date Badge --}}
                    <div class="flex-shrink-0 w-full sm:w-20 text-center sm:text-left flex sm:flex-col items-center sm:items-start justify-center sm:justify-center gap-2 sm:gap-0 bg-gray-50 sm:bg-transparent p-2 sm:p-0 rounded-lg">
                        <span class="text-2xl font-bold text-gray-800" x-text="formatDateDay(agenda.date)"></span>
                        <span class="text-xs font-bold text-red-500 uppercase tracking-wide" x-text="formatDateMonth(agenda.date)"></span>
                    </div>

                    {{-- Agenda Details --}}
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors" x-text="agenda.title"></h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border"
                                :class="{
                                    'bg-blue-50 text-blue-700 border-blue-100': agenda.type === 'Mengajar',
                                    'bg-purple-50 text-purple-700 border-purple-100': agenda.type === 'Sekolah',
                                    'bg-orange-50 text-orange-700 border-orange-100': agenda.type !== 'Mengajar' && agenda.type !== 'Sekolah'
                                }"
                                x-text="agenda.type">
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-1">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span x-text="agenda.start_time + ' - ' + agenda.end_time + ' WIB'"></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span x-text="agenda.location"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Status & Actions --}}
                    <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                        <div class="flex-shrink-0">
                            <template x-if="agenda.status === 'today'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm animate-pulse">Hari Ini</span>
                            </template>
                            <template x-if="agenda.status === 'upcoming'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">Akan Datang</span>
                            </template>
                            <template x-if="agenda.status === 'done'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Selesai</span>
                            </template>
                        </div>
                        
                        <div class="flex items-center gap-1 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-all">
                            <button class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </template>

            {{-- Empty State --}}
             <div x-show="filteredAgendas.length === 0" class="p-12 text-center text-gray-500">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Tidak ada agenda ditemukan</h3>
                <p class="text-sm">Coba ubah filter atau kata kunci pencarian Anda.</p>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-between items-center text-sm text-gray-500">
            <span>Menampilkan <strong x-text="filteredAgendas.length"></strong> dari <strong x-text="agendas.length"></strong> agenda</span>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-50 shadow-sm" disabled>Previous</button>
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 shadow-sm">Next</button>
            </div>
        </div>
    </div>

    {{-- CALENDAR VIEW (Mock) --}}
    <div x-show="viewMode === 'calendar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Februari 2026</h2>
                <div class="flex gap-2">
                    <button class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                    <button class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-px bg-gray-200 rounded-xl overflow-hidden border border-gray-200">
                {{-- Headers --}}
                <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']">
                    <div class="bg-gray-50 p-4 text-center text-sm font-semibold text-gray-600" x-text="day"></div>
                </template>

                {{-- Mock Calendar Days (28 days + padding) --}}
                {{-- Padding --}}
                <div class="bg-white min-h-[120px] p-2 text-gray-300">26</div>
                <div class="bg-white min-h-[120px] p-2 text-gray-300">27</div>
                <div class="bg-white min-h-[120px] p-2 text-gray-300">28</div>
                <div class="bg-white min-h-[120px] p-2 text-gray-300">29</div>
                <div class="bg-white min-h-[120px] p-2 text-gray-300">30</div>
                <div class="bg-white min-h-[120px] p-2 text-gray-300">31</div>
                
                {{-- Days 1-28 --}}
                <template x-for="i in 28">
                    <div class="bg-white min-h-[120px] p-2 hover:bg-gray-50 transition-colors group relative border-t border-l border-transparent">
                        <span class="text-sm font-medium text-gray-700" :class="{'bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full': i === 12}" x-text="i"></span>
                        
                        {{-- Mock Events --}}
                        <template x-if="i === 12">
                            <div class="mt-2 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-medium truncate cursor-pointer hover:bg-blue-200">
                                Rapat Guru
                            </div>
                        </template>
                        <template x-if="i === 15">
                            <div class="mt-2 text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded font-medium truncate cursor-pointer hover:bg-orange-200">
                                Ulangan Harian
                            </div>
                        </template>
                         <template x-if="i === 22">
                            <div class="mt-2 text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded font-medium truncate cursor-pointer hover:bg-purple-200">
                                Pelatihan
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('agendaPage', () => ({
            viewMode: 'list',
            searchQuery: '',
            filterType: 'all',
            sortOrder: 'asc',
            
            agendas: @json($agendaData),

            get filteredAgendas() {
                let filtered = this.agendas;

                // Search
                if (this.searchQuery) {
                    const lowerQuery = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(item => 
                        item.title.toLowerCase().includes(lowerQuery) || 
                        item.location.toLowerCase().includes(lowerQuery)
                    );
                }

                // Filter Type
                if (this.filterType !== 'all') {
                    filtered = filtered.filter(item => item.type === this.filterType);
                }

                // Sort
                return filtered.sort((a, b) => {
                    const dateA = new Date(a.date);
                    const dateB = new Date(b.date);
                    return this.sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
                });
            },

            // Stats
            get todayCount() {
                const today = new Date().toISOString().slice(0, 10);
                return this.agendas.filter(a => a.date === today).length;
            },
            get upcomingCount() {
                 return this.agendas.filter(a => a.status === 'upcoming').length;
            },
            get doneCount() {
                 return this.agendas.filter(a => a.status === 'done').length;
            },

            // Format Helpers
            formatDateDay(dateStr) {
                const date = new Date(dateStr);
                return date.getDate();
            },
            formatDateMonth(dateStr) {
                const date = new Date(dateStr);
                const months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
                return months[date.getMonth()];
            }
        }));
    });
</script>
@endpush
@endsection
