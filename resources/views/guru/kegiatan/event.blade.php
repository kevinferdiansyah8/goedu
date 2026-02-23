@extends('layouts.admin')

@section('title', 'Event Sekolah')

@php
// Mock Data for Events
$mockEvents = [
    [
        'id' => 1,
        'title' => 'Upacara Peringatan Hari Guru',
        'category' => 'Upacara',
        'date' => date('Y-m-d', strtotime('+3 days')),
        'time' => '07:00 - 09:00',
        'location' => 'Lapangan Utama',
        'description' => 'Seluruh guru wajib hadir mengenakan seragam PGRI lengkap. Diharapkan hadir 15 menit sebelum acara dimulai.',
        'status' => 'upcoming',
        'color' => 'blue'
    ],
    [
        'id' => 2,
        'title' => 'Workshop Kurikulum Merdeka',
        'category' => 'Workshop',
        'date' => date('Y-m-d', strtotime('+10 days')),
        'time' => '08:00 - 15:00',
        'location' => 'Aula Serbaguna',
        'description' => 'Pelatihan lanjutan implementasi Kurikulum Merdeka untuk guru mata pelajaran eksakta.',
        'status' => 'upcoming',
        'color' => 'purple'
    ],
    [
        'id' => 3,
        'title' => 'Rapat Evaluasi Bulanan',
        'category' => 'Rapat',
        'date' => date('Y-m-d'),
        'time' => '13:00 - 15:00',
        'location' => 'Ruang Guru',
        'description' => 'Evaluasi kinerja bulan Januari dan persiapan Ujian Tengah Semester.',
        'status' => 'today',
        'color' => 'orange'
    ],
    [
        'id' => 4,
        'title' => 'Porseni Sekolah',
        'category' => 'Akademik',
        'date' => date('Y-m-d', strtotime('-5 days')),
        'time' => '08:00 - 16:00',
        'location' => 'Area Sekolah',
        'description' => 'Pekan Olahraga dan Seni antar kelas.',
        'status' => 'done',
        'color' => 'green'
    ],
    [
        'id' => 5,
        'title' => 'Webinar Pendidikan Karakter',
        'category' => 'Workshop',
        'date' => date('Y-m-d', strtotime('+15 days')),
        'time' => '09:00 - 12:00',
        'location' => 'Online (Zoom)',
        'description' => 'Pentingnya pendidikan karakter di era digital.',
        'status' => 'upcoming',
        'color' => 'purple'
    ],
    [
        'id' => 6,
        'title' => 'Pembagian Raport Siswa',
        'category' => 'Akademik',
        'date' => date('Y-m-d', strtotime('+30 days')),
        'time' => '08:00 - 12:00',
        'location' => 'Kelas Masing-masing',
        'status' => 'upcoming',
        'color' => 'red'
    ],
];

$eventsData = $events ?? $mockEvents;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="eventPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Event Sekolah</h1>
            <p class="text-sm text-gray-500 mt-1">Jadwal kegiatan penting dan agenda sekolah yang perlu Anda ikuti.</p>
        </div>
        
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Toggle View --}}
            <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 flex">
                <button @click="viewMode = 'grid'" :class="{ 'bg-blue-50 text-blue-600 shadow-sm': viewMode === 'grid', 'text-gray-500 hover:bg-gray-50': viewMode !== 'grid' }" class="p-2 rounded-lg transition-all" title="Grid View">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
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
                <select x-model="filterCategory" class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                    <option value="all">Semua Kategori</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Akademik">Akademik</option>
                    <option value="Rapat">Rapat</option>
                    <option value="Upacara">Upacara</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            {{-- Add Button --}}
            <button class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow hover:bg-blue-700 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Event
            </button>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        {{-- Total --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Event</span>
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="events.length"></h3>
                <p class="text-xs text-gray-500 mt-1">Bulan Ini</p>
            </div>
        </div>

        {{-- Hari Ini --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Hari Ini</span>
                <span class="p-1.5 bg-orange-50 text-orange-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="todayCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Acara Aktif</p>
            </div>
        </div>

        {{-- Mendatang --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Mendatang</span>
                <span class="p-1.5 bg-purple-50 text-purple-600 rounded-lg">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900" x-text="upcomingCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Segera</p>
            </div>
        </div>

         {{-- Selesai --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between h-28 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Selesai</span>
                <span class="p-1.5 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-green-600" x-text="doneCount"></h3>
                <p class="text-xs text-gray-500 mt-1">Terlaksana</p>
            </div>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="mb-6 relative">
        <input type="text" x-model="searchQuery" placeholder="Cari event, lokasi..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-all">
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>

    {{-- GRID VIEW --}}
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <template x-for="event in filteredEvents" :key="event.id">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group flex flex-col h-full">
                
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        {{-- Date Badge --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-center min-w-[70px]">
                            <div class="text-sm font-bold text-red-500 uppercase tracking-wider" x-text="formatDateMonth(event.date)"></div>
                            <div class="text-2xl font-bold text-gray-900 leading-none mt-0.5" x-text="formatDateDay(event.date)"></div>
                        </div>
                        
                        {{-- Status Badge --}}
                        <div>
                             <template x-if="event.status === 'today'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200 animate-pulse">Hari Ini</span>
                            </template>
                             <template x-if="event.status === 'upcoming'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">Akan Datang</span>
                            </template>
                             <template x-if="event.status === 'done'">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">Selesai</span>
                            </template>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors" x-text="event.title"></h3>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-medium border"
                            :class="{
                                'bg-purple-50 text-purple-700 border-purple-100': event.category === 'Workshop',
                                'bg-blue-50 text-blue-700 border-blue-100': event.category === 'Upacara',
                                'bg-orange-50 text-orange-700 border-orange-100': event.category === 'Rapat',
                                'bg-green-50 text-green-700 border-green-100': event.category === 'Akademik',
                            }"
                            x-text="event.category">
                        </span>
                    </div>

                    <div class="space-y-1.5 text-sm text-gray-500 mb-4">
                         <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="event.time"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span x-text="event.location"></span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 line-clamp-2" x-text="event.description"></p>
                </div>

                <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center mt-auto">
                    <button class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">Lihat Detail</button>
                    <div class="flex gap-1">
                        <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-white rounded-lg transition-all" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                         <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-white rounded-lg transition-all" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </template>
    </div>

    {{-- LIST VIEW --}}
    <div x-show="viewMode === 'list'" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
        <template x-for="event in filteredEvents" :key="event.id">
            <div class="group p-5 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row gap-4 sm:items-center">
                 {{-- Date Badge --}}
                <div class="flex-shrink-0 w-full sm:w-16 text-center bg-gray-50 p-2 rounded-lg border border-gray-100">
                     <div class="text-xs font-bold text-gray-500 uppercase" x-text="formatDateMonth(event.date)"></div>
                    <div class="text-xl font-bold text-gray-900" x-text="formatDateDay(event.date)"></div>
                </div>

                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                         <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors" x-text="event.title"></h3>
                         <span class="px-2 py-0.5 rounded text-xs font-medium border w-fit"
                            :class="{
                                'bg-purple-50 text-purple-700 border-purple-100': event.category === 'Workshop',
                                'bg-blue-50 text-blue-700 border-blue-100': event.category === 'Upacara',
                                'bg-orange-50 text-orange-700 border-orange-100': event.category === 'Rapat',
                                'bg-green-50 text-green-700 border-green-100': event.category === 'Akademik',
                            }"
                            x-text="event.category">
                        </span>
                    </div>
                     <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
                        <span x-text="event.time"></span>
                        <span class="text-gray-300">|</span>
                        <span x-text="event.location"></span>
                        <span class="text-gray-300">|</span>
                         <span x-text="event.description" class="truncate max-w-xs"></span>
                    </div>
                </div>

                 <div class="flex items-center gap-3">
                     <template x-if="event.status === 'today'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">Hari Ini</span>
                    </template>
                        <template x-if="event.status === 'upcoming'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">Akan Datang</span>
                    </template>
                        <template x-if="event.status === 'done'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">Selesai</span>
                    </template>
                    
                    <button class="p-2 text-gray-400 hover:text-blue-600 rounded-lg" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>
                </div>
            </div>
        </template>
    </div>

    {{-- CALENDAR VIEW --}}
    <div x-show="viewMode === 'calendar'" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6" style="display: none;">
         <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Maret 2026</h2>
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

            {{-- Mock Days --}}
             <template x-for="i in 35">
                <div class="bg-white min-h-[120px] p-2 hover:bg-gray-50 transition-colors group relative border-t border-l border-transparent">
                     <span class="text-sm font-medium text-gray-700" :class="{'text-gray-300': i > 31}" x-text="i > 31 ? i - 31 : i"></span>
                     
                     <template x-if="i === 5">
                        <div class="mt-2 p-1.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold cursor-pointer hover:bg-blue-200 truncate">
                            Upacara Hari Guru
                        </div>
                     </template>
                      <template x-if="i === 12">
                        <div class="mt-2 p-1.5 rounded bg-purple-100 text-purple-700 text-xs font-semibold cursor-pointer hover:bg-purple-200 truncate">
                            Workshop Kurikulum
                        </div>
                     </template>
                </div>
             </template>
        </div>
    </div>

    {{-- Empty State --}}
    <div x-show="filteredEvents.length === 0" class="p-16 text-center">
        <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900">Belum ada event</h3>
        <p class="text-gray-500">Tidak ada event yang sesuai dengan filter Anda.</p>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('eventPage', () => ({
            viewMode: 'grid',
            searchQuery: '',
            filterCategory: 'all',
            
            events: @json($eventsData),

            get filteredEvents() {
                let filtered = this.events;

                if (this.searchQuery) {
                    const lowerQuery = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(item => 
                        item.title.toLowerCase().includes(lowerQuery) || 
                        item.location.toLowerCase().includes(lowerQuery)
                    );
                }

                if (this.filterCategory !== 'all') {
                    filtered = filtered.filter(item => item.category === this.filterCategory);
                }

                return filtered;
            },

            // Stats
             get todayCount() {
                const today = new Date().toISOString().slice(0, 10);
                return this.events.filter(a => a.date === today).length;
            },
            get upcomingCount() {
                 return this.events.filter(a => a.status === 'upcoming').length;
            },
            get doneCount() {
                 return this.events.filter(a => a.status === 'done').length;
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
