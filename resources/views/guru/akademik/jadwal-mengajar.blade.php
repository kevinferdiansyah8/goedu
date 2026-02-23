@extends('layouts.admin')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="jadwalPage()">
    
    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Jadwal Mengajar</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola agenda mengajar Anda dengan mudah dan efisien.</p>
    </div>

    {{-- ANALYTICS SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Card 1: Total Jam Hari Ini --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Hari Ini</div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">4 <span class="text-base font-medium text-gray-400">Jam</span></div>
            <p class="text-xs text-blue-600 mt-1 bg-blue-50 inline-block px-2 py-0.5 rounded-full font-medium">Sedang Berlangsung</p>
        </div>

        {{-- Card 2: Kelas Aktif --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas Aktif</div>
                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">2 <span class="text-base font-medium text-gray-400">Kelas</span></div>
            <p class="text-xs text-gray-500 mt-1">X IPA 1, XI IPA 2</p>
        </div>

        {{-- Card 3: Next Class --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas Berikutnya</div>
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-xl font-bold text-gray-900 truncate">Matematika (XI IPA 2)</div>
            <p class="text-xs text-orange-600 mt-1 font-medium flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Mulai dalam 45 menit
            </p>
        </div>

        {{-- Card 4: Total Minggu Ini --}}
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Mingguan</div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">24 <span class="text-base font-medium text-gray-400">Jam</span></div>
            <p class="text-xs text-green-600 mt-1 font-medium">+2 jam dari minggu lalu</p>
        </div>
    </div>

    {{-- CONTROLS: VIEW SWITCHER & FILTERS --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-6 bg-white p-2 rounded-2xl shadow-sm border border-gray-200">
        
        {{-- View Switcher --}}
        <div class="flex bg-gray-100 p-1 rounded-xl w-full lg:w-auto">
            <button @click="viewMode = 'card'" 
                :class="viewMode === 'card' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 flex items-center gap-2 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Cards
            </button>
            <button @click="viewMode = 'timeline'" 
                :class="viewMode === 'timeline' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 flex items-center gap-2 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Timeline
            </button>
            <button @click="viewMode = 'calendar'" 
                :class="viewMode === 'calendar' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 flex items-center gap-2 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Calendar
            </button>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 items-center w-full lg:w-auto">
            <select x-model="selectedDay" class="text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                <option value="all">Semua Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
            </select>

            <select class="text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg px-3 py-2 font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                <option>Semua Kelas</option>
                <option>X IPA 1</option>
                <option>XI IPA 2</option>
            </select>

            <div class="relative flex-grow lg:flex-grow-0">
                <input type="text" placeholder="Cari Mapel..." class="w-full lg:w-40 text-sm border-transparent focus:border-blue-500 focus:ring-0 bg-gray-50 rounded-lg pl-8 pr-3 py-2 font-medium placeholder-gray-400 hover:bg-gray-100 transition-colors">
                 <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            
            <button class="p-2 text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors" title="Reset Filters">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </button>
        </div>
    </div>

    {{-- VIEW MODES CONTENT --}}
    
    {{-- 1. CARD VIEW --}}
    <div x-show="viewMode === 'card'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <template x-for="schedule in filteredSchedules" :key="schedule.id">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                {{-- Active Indicator --}}
                <div x-show="schedule.isActive" class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-50 text-gray-900 font-bold px-3 py-1.5 rounded-lg text-sm border border-gray-200 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100 transition-colors">
                            <span x-text="schedule.timeStart"></span> - <span x-text="schedule.timeEnd"></span>
                        </div>
                        <span x-show="schedule.isActive" class="animate-pulse flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    </div>
                    <span class="text-xs font-semibold px-2 py-1 rounded-md" 
                        :class="schedule.day === 'Hari Ini' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'" 
                        x-text="schedule.day">
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-1" x-text="schedule.subject"></h3>
                <div class="flex items-center text-sm text-gray-500 mb-6">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span x-text="schedule.class"></span>
                    <span class="mx-2">•</span>
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span x-text="schedule.room"></span>
                </div>

                {{-- Action Buttons (Revealed on Hover) --}}
                <div class="grid grid-cols-3 gap-2 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-200">
                    <button class="px-3 py-2 bg-blue-50 text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                        Absensi
                    </button>
                    <button class="px-3 py-2 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                        Nilai
                    </button>
                    <button class="px-3 py-2 bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-600 hover:text-white transition-colors">
                        Materi
                    </button>
                </div>

                {{-- Progress Bar (Only Active items) --}}
                <div x-show="schedule.isActive" class="absolute bottom-0 left-0 w-full h-1 bg-gray-100">
                    <div class="h-full bg-blue-500" style="width: 45%"></div>
                </div>
            </div>
        </template>
    </div>

    {{-- 2. TIMELINE VIEW --}}
    <div x-show="viewMode === 'timeline'" style="display: none;" class="max-w-3xl mx-auto">
        <div class="relative border-l-2 border-gray-200 ml-4 space-y-8 pl-8 py-4">
            <template x-for="schedule in filteredSchedules" :key="schedule.id">
                <div class="relative group">
                    {{-- Timeline Dot --}}
                    <div class="absolute -left-[41px] top-6 h-5 w-5 rounded-full border-4 border-white shadow-sm"
                        :class="schedule.isActive ? 'bg-blue-500 ring-4 ring-blue-100' : 'bg-gray-300'">
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow relative overflow-hidden" 
                        :class="{'ring-2 ring-blue-500 shadow-lg shadow-blue-500/10': schedule.isActive}">
                        
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-bold px-2 py-0.5 rounded text-gray-500 bg-gray-100 uppercase tracking-wide mb-2 inline-block">
                                    <span x-text="schedule.timeStart"></span> - <span x-text="schedule.timeEnd"></span>
                                </span>
                                <h3 class="text-lg font-bold text-gray-900" x-text="schedule.subject"></h3>
                                <p class="text-sm text-gray-500 mt-1" x-text="schedule.class + ' • ' + schedule.room"></p>
                            </div>
                             <div x-show="schedule.isActive">
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-md animate-pulse">Sedang Berlangsung</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- 3. CALENDAR VIEW (Simple Grid Mockup) --}}
    <div x-show="viewMode === 'calendar'" style="display: none;" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-x-auto">
        <div class="min-w-[800px]">
            {{-- Header Row --}}
            <div class="grid grid-cols-6 border-b border-gray-100 bg-gray-50">
                <div class="p-3 text-xs font-bold text-gray-500 text-center border-r border-gray-100">JAM</div>
                <div class="p-3 text-sm font-bold text-gray-700 text-center border-r border-gray-100">Senin</div>
                <div class="p-3 text-sm font-bold text-gray-700 text-center border-r border-gray-100">Selasa</div>
                <div class="p-3 text-sm font-bold text-gray-700 text-center border-r border-gray-100">Rabu</div>
                <div class="p-3 text-sm font-bold text-gray-700 text-center border-r border-gray-100">Kamis</div>
                <div class="p-3 text-sm font-bold text-gray-700 text-center">Jumat</div>
            </div>

            {{-- Grid Body --}}
            <div class="relative grid grid-rows-[repeat(8,minmax(80px,1fr))]">
                {{-- Time Column --}}
                <div class="absolute left-0 top-0 bottom-0 w-[16.66%] border-r border-gray-100 bg-gray-50/50 flex flex-col justify-between py-4">
                    <div class="text-xs text-center text-gray-400">07:00</div>
                    <div class="text-xs text-center text-gray-400">08:00</div>
                    <div class="text-xs text-center text-gray-400">09:00</div>
                    <div class="text-xs text-center text-gray-400">10:00</div>
                    <div class="text-xs text-center text-gray-400">11:00</div>
                    <div class="text-xs text-center text-gray-400">12:00</div>
                    <div class="text-xs text-center text-gray-400">13:00</div>
                    <div class="text-xs text-center text-gray-400">14:00</div>
                </div>

                {{-- Schedule Blocks (Absolute Positioning Simulation for Demo) --}}
                <div class="col-start-2 col-end-7 relative h-[640px] ml-[16.66%]">
                    {{-- Senin - Mat --}}
                    <div class="absolute top-[20px] left-[0%] w-[19%] h-[120px] bg-blue-100 border-l-4 border-blue-500 rounded p-2 m-1 hover:brightness-95 cursor-pointer shadow-sm">
                        <div class="text-xs font-bold text-blue-800">Matematika</div>
                        <div class="text-[10px] text-blue-600">X IPA 1 • R.101</div>
                        <div class="text-[10px] text-blue-500 mt-1">07:00 - 08:30</div>
                    </div>

                    {{-- Selasa - Fisika --}}
                    <div class="absolute top-[100px] left-[20%] w-[19%] h-[120px] bg-purple-100 border-l-4 border-purple-500 rounded p-2 m-1 hover:brightness-95 cursor-pointer shadow-sm">
                        <div class="text-xs font-bold text-purple-800">Fisika</div>
                        <div class="text-[10px] text-purple-600">XI IPA 2 • R.202</div>
                        <div class="text-[10px] text-purple-500 mt-1">08:00 - 09:30</div>
                    </div>

                    {{-- Rabu - Kimia (Active) --}}
                    <div class="absolute top-[40px] left-[40%] w-[19%] h-[120px] bg-green-100 border-l-4 border-green-500 rounded p-2 m-1 hover:brightness-95 cursor-pointer shadow-md ring-2 ring-green-400/50">
                        <div class="text-xs font-bold text-green-800">Kimia (Active)</div>
                        <div class="text-[10px] text-green-600">X IPA 2 • R.Lab</div>
                        <div class="text-[10px] text-green-500 mt-1">07:20 - 08:50</div>
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
        Alpine.data('jadwalPage', () => ({
            viewMode: 'card', // card, timeline, calendar
            selectedDay: 'all',
            
            schedules: [
                { id: 1, day: 'Hari Ini', timeStart: '07:00', timeEnd: '08:30', subject: 'Matematika Peminatan', class: 'X IPA 1', room: 'Ruang 101', isActive: false },
                { id: 2, day: 'Hari Ini', timeStart: '08:50', timeEnd: '10:20', subject: 'Fisika Dasar', class: 'XI IPA 2', room: 'Lab Fisika', isActive: true },
                { id: 3, day: 'Besok', timeStart: '10:40', timeEnd: '12:10', subject: 'Matematika Wajib', class: 'X IPA 2', room: 'Ruang 102', isActive: false },
                { id: 4, day: 'Besok', timeStart: '13:00', timeEnd: '14:30', subject: 'Kimia', class: 'XII IPA 1', room: 'Lab Kimia', isActive: false },
                { id: 5, day: 'Jumat', timeStart: '07:00', timeEnd: '08:00', subject: 'Wali Kelas', class: 'X IPA 1', room: 'Ruang 101', isActive: false },
            ],

            get filteredSchedules() {
                if (this.selectedDay === 'all') return this.schedules;
                // Simple Mapping for Mock Data "Hari Ini" = Senin for demo purposes
                if (this.selectedDay === 'Senin') return this.schedules.filter(s => s.day === 'Hari Ini');
                if (this.selectedDay === 'Selasa') return this.schedules.filter(s => s.day === 'Besok');
                return this.schedules;
            }
        }));
    });
</script>
@endpush
@endsection
