@extends('layouts.admin')

@section('title', 'Pengumuman')

@php
// Mock Data for Announcements
$mockAnnouncements = [
    [
        'id' => 1,
        'title' => 'Perubahan Jadwal Libur Awal Puasa',
        'category' => 'Libur',
        'date' => date('Y-m-d', strtotime('-1 day')),
        'content_summary' => 'Berdasarkan keputusan pemerintah, libur awal puasa diundur satu hari.',
        'content_full' => 'Diberitahukan kepada seluruh warga sekolah bahwa berdasarkan keputusan terbaru dari Kementerian Agama dan Dinas Pendidikan, libur awal puasa yang semula dijadwalkan pada tanggal 10 Maret, diundur menjadi tanggal 11 Maret 2026. Kegiatan belajar mengajar akan tetap berjalan seperti biasa pada tanggal 10 Maret dengan jam pulang lebih awal (pukulu 11.00 WIB).',
        'urgency' => 'high',
        'status' => 'active',
        'author' => 'Kepala Sekolah',
        'target' => 'Semua'
    ],
    [
        'id' => 2,
        'title' => 'Pengumpulan Soal PTS Genap',
        'category' => 'Akademik',
        'date' => date('Y-m-d', strtotime('-3 days')),
        'content_summary' => 'Batas akhir pengumpulan soal PTS adalah tanggal 20 Februari 2026.',
        'content_full' => 'Mengingatkan kepada Bapak/Ibu Guru bahwa batas akhir pengumpulan naskah soal Penilaian Tengah Semester (PTS) Genap Tahun Ajaran 2025/2026 adalah hari Jumat, 20 Februari 2026. Naskah soal mohon dikirimkan dalam format Word (.docx) ke email kurikulum atau melalui link Google Drive yang telah disediakan. Pastikan soal sudah melalui proses editing dan validasi MGMP sekolah.',
        'urgency' => 'medium',
        'status' => 'active',
        'author' => 'Waka Kurikulum',
        'target' => 'Guru'
    ],
    [
        'id' => 3,
        'title' => 'Pembersihan Area Parkir Guru',
        'category' => 'Administrasi',
        'date' => date('Y-m-d', strtotime('-5 days')),
        'content_summary' => 'Akan dilakukan pengecatan ulang area parkir pada hari Sabtu.',
        'content_full' => 'Mohon perhatiannya, pada hari Sabtu, 21 Februari 2026, akan dilakukan pengecatan ulang garis parkir di area parkir khusus guru. Dimohon untuk tidak memarkirkan kendaraan di area tersebut pada hari Sabtu. Parkir dialihkan sementara ke lapangan basket indoor. Terima kasih atas kerjasamanya.',
        'urgency' => 'low',
        'status' => 'active',
        'author' => 'Sarpras',
        'target' => 'Guru & Staff'
    ],
    [
        'id' => 4,
        'title' => 'Workshop Digital Learning Tools',
        'category' => 'Event',
        'date' => date('Y-m-d', strtotime('-10 days')),
        'content_summary' => 'Undangan workshop penggunaan AI dalam pembelajaran.',
        'content_full' => 'Mengundang Bapak/Ibu Guru untuk menghadiri workshop "Digital Learning Tools & AI integration" yang akan dilaksanakan pada tanggal 28 Februari 2026 di Aula Sekolah. Materi akan mencakup penggunaan ChatGPT, Canva Edu, dan Quizizz AI. Pendaftaran dapat dilakukan melalui TU.',
        'urgency' => 'low',
        'status' => 'active',
        'author' => 'Panitia Workshop',
        'target' => 'Guru'
    ],
    [
        'id' => 5,
        'title' => 'Hasil Rapat Evaluasi Bulanan',
        'category' => 'Administrasi',
        'date' => date('Y-m-d', strtotime('-20 days')),
        'content_summary' => 'Notulensi rapat evaluasi bulan Januari telah tersedia.',
        'content_full' => 'Berikut kami lampirkan notulensi hasil rapat evaluasi kinerja guru dan karyawan periode Januari 2026. Mohon untuk dibaca dan ditindaklanjuti poin-poin yang menjadi catatan perbaikan bersama.',
        'urgency' => 'low',
        'status' => 'archived',
        'author' => 'Sekretaris Sekolah',
        'target' => 'Guru'
    ]
];

$announcementsData = $announcements ?? $mockAnnouncements;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="announcementPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pengumuman</h1>
            <p class="text-sm text-gray-500 mt-1">Papan informasi resmi dan pemberitahuan sekolah.</p>
        </div>
        
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Filter --}}
            <div class="relative">
                <select x-model="filterCategory" class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                    <option value="all">Semua Kategori</option>
                    <option value="Akademik">Akademik</option>
                    <option value="Libur">Libur</option>
                    <option value="Administrasi">Administrasi</option>
                    <option value="Event">Event</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

             {{-- Sort --}}
            <div class="relative">
                <select x-model="sortOrder" class="appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium shadow-sm transition-all cursor-pointer hover:bg-gray-50">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="urgent">Paling Penting</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                </div>
            </div>

            {{-- Add Button --}}
            <button class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow hover:bg-blue-700 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Pengumuman
            </button>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        {{-- Total --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-gray-50 text-gray-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Pengumuman</p>
                <h3 class="text-2xl font-bold text-gray-900" x-text="announcements.length"></h3>
            </div>
        </div>

        {{-- Aktif --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Pengumuman Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900" x-text="activeCount"></h3>
            </div>
        </div>

        {{-- Mendesak --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Mendesak</p>
                <h3 class="text-2xl font-bold text-red-600" x-text="urgentCount"></h3>
            </div>
        </div>
    </div>

    {{-- SEARCH BAR --}}
    <div class="mb-6 relative">
        <input type="text" x-model="searchQuery" placeholder="Cari judul pengumuman..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-all">
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>

    {{-- ANNOUNCEMENT LIST --}}
    <div class="space-y-4">
        {{-- Pinned / Urgent Section --}}
        <template x-if="urgentAnnouncements.length > 0">
             <div class="mb-6">
                <h3 class="text-sm font-bold text-red-600 uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Penting & Mendesak
                </h3>
                <div class="space-y-4">
                    <template x-for="item in urgentAnnouncements" :key="item.id">
                         <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-red-500 border-y border-r border-gray-200 p-5 hover:shadow-md transition-all relative overflow-hidden">
                            <div class="absolute right-0 top-0 p-3 opacity-5">
                                <svg class="w-24 h-24 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            </div>
                            
                            <div class="relative z-10">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 gap-2">
                                     <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-700 uppercase" x-text="item.category"></span>
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700 uppercase animate-pulse">Mendesak</span>
                                     </div>
                                      <span class="text-xs text-gray-400 font-medium" x-text="formatDate(item.date)"></span>
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-900 mb-1" x-text="item.title"></h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2" x-text="item.content_summary"></p>
                                
                                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                    <div class="text-xs text-gray-400">
                                        Oleh: <span class="font-semibold text-gray-600" x-text="item.author"></span> · Untuk: <span class="font-semibold text-gray-600" x-text="item.target"></span>
                                    </div>
                                    <button @click="openModal(item)" class="text-sm font-bold text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                                        Baca Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
             </div>
        </template>

        {{-- Normal List --}}
        <template x-for="item in filteredAnnouncements" :key="item.id">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:border-blue-300 hover:shadow-md transition-all group">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 gap-2">
                    <span class="px-2.5 py-0.5 rounded text-xs font-bold w-fit"
                        :class="{
                            'bg-green-50 text-green-700': item.category === 'Akademik',
                            'bg-yellow-50 text-yellow-700': item.category === 'Libur',
                            'bg-purple-50 text-purple-700': item.category === 'Event',
                            'bg-gray-100 text-gray-700': item.category === 'Administrasi'
                        }"
                        x-text="item.category">
                    </span>
                    <span class="text-xs text-gray-400 font-medium" x-text="formatDate(item.date)"></span>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors" x-text="item.title"></h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2" x-text="item.content_summary"></p>

                <div class="flex justify-between items-center pt-3 border-t border-gray-50 bg-gray-50/30 -mx-5 -mb-5 px-5 py-3 mt-auto">
                     <div class="text-xs text-gray-400 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span x-text="item.author"></span>
                    </div>
                    <div class="flex items-center gap-3">
                         <button class="text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button @click="openModal(item)" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </template>
        
        <div x-show="filteredAnnouncements.length === 0 && urgentAnnouncements.length === 0" class="p-12 text-center text-gray-500">
             <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Tidak ada pengumuman</h3>
            <p class="text-sm">Silakan ubah filter atau kata kunci pencarian Anda.</p>
        </div>
    </div>

    {{-- DETAIL MODAL --}}
    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="modalOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="modalOpen" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative" x-data>
                    <button @click="modalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors rounded-full p-1 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <template x-if="selectedAnnouncement">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase"
                                     :class="{
                                        'bg-green-100 text-green-700': selectedAnnouncement.category === 'Akademik',
                                        'bg-yellow-100 text-yellow-700': selectedAnnouncement.category === 'Libur',
                                        'bg-purple-100 text-purple-700': selectedAnnouncement.category === 'Event',
                                        'bg-gray-100 text-gray-700': selectedAnnouncement.category === 'Administrasi'
                                    }"
                                    x-text="selectedAnnouncement.category"></span>
                                <span class="text-sm text-gray-500" x-text="formatDate(selectedAnnouncement.date)"></span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900 mb-6 leading-tight" x-text="selectedAnnouncement.title"></h2>

                            <div class="prose prose-blue max-w-none text-gray-700 mb-8 border-t border-gray-100 pt-6">
                                <p x-text="selectedAnnouncement.content_full"></p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex flex-col sm:flex-row justify-between gap-4 text-sm">
                                <div>
                                    <span class="block text-gray-400 text-xs uppercase font-bold mb-1">Diterbitkan Oleh</span>
                                    <div class="font-semibold text-gray-900 flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">A</div>
                                        <span x-text="selectedAnnouncement.author"></span>
                                    </div>
                                </div>
                                <div>
                                     <span class="block text-gray-400 text-xs uppercase font-bold mb-1">Target Audiens</span>
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="selectedAnnouncement.target"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <button type="button" @click="modalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('announcementPage', () => ({
            modalOpen: false,
            selectedAnnouncement: null,
            searchQuery: '',
            filterCategory: 'all',
            sortOrder: 'newest',
            
            announcements: @json($announcementsData),

            get filteredAnnouncements() {
                let filtered = this.announcements.filter(item => item.urgency !== 'high'); // Separate list excludes urgent

                // Search
                if (this.searchQuery) {
                    const lowerQuery = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(item => 
                        item.title.toLowerCase().includes(lowerQuery) || 
                        item.content_summary.toLowerCase().includes(lowerQuery)
                    );
                }

                // Filter Category
                if (this.filterCategory !== 'all') {
                    filtered = filtered.filter(item => item.category === this.filterCategory);
                }

                // Sort
                return this.sortList(filtered);
            },

            get urgentAnnouncements() {
                let urgent = this.announcements.filter(item => item.urgency === 'high');
                 // Apply search/filter to urgent as well
                if (this.searchQuery) {
                    const lowerQuery = this.searchQuery.toLowerCase();
                    urgent = urgent.filter(item => 
                        item.title.toLowerCase().includes(lowerQuery) || 
                        item.content_summary.toLowerCase().includes(lowerQuery)
                    );
                }
                if (this.filterCategory !== 'all') {
                    urgent = urgent.filter(item => item.category === this.filterCategory);
                }
                return urgent;
            },

            sortList(list) {
                 return list.sort((a, b) => {
                    const dateA = new Date(a.date);
                    const dateB = new Date(b.date);
                    if (this.sortOrder === 'newest') return dateB - dateA;
                    if (this.sortOrder === 'oldest') return dateA - dateB;
                    return 0; // Urgent sorting handled by separation
                });
            },

            // Stats
            get activeCount() {
                return this.announcements.filter(a => a.status === 'active').length;
            },
            get urgentCount() {
                 return this.announcements.filter(a => a.urgency === 'high').length;
            },

            // Actions
            openModal(item) {
                this.selectedAnnouncement = item;
                this.modalOpen = true;
            },

            // Helpers
            formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            }
        }));
    });
</script>
@endpush
@endsection
