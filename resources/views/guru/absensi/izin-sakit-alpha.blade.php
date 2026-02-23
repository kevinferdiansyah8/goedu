@extends('layouts.admin')

@section('title', 'Izin / Sakit / Alpha Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50" x-data="{
    search: '',
    selectedClass: '',
    date: '',
    selectedRows: [],
    showProofModal: false,
    proofImage: '',
    showConfirmModal: false,
    confirmAction: '', // 'approve', 'reject', 'alpha'
    confirmId: null,
    
    // Mock Data for UI Demo
    rows: [
        { id: 1, date: '10 Feb 2026', name: 'Ahmad Fauzi', class: 'X RPL', type: 'Sakit', reason: 'Demam tinggi', proof: 'https://via.placeholder.com/400x300?text=Surat+Dokter', status: 'Menunggu' },
        { id: 2, date: '10 Feb 2026', name: 'Budi Santoso', class: 'X RPL', type: '-', reason: '-', proof: null, status: 'Alpha' },
        { id: 3, date: '09 Feb 2026', name: 'Citra Kirana', class: 'XI RPL', type: 'Izin', reason: 'Acara Keluarga', proof: 'https://via.placeholder.com/400x300?text=Surat+Izin', status: 'Disetujui' },
        { id: 4, date: '08 Feb 2026', name: 'Dewi Lestari', class: 'X RPL', type: 'Sakit', reason: 'Flu Berat', proof: 'https://via.placeholder.com/400x300?text=Surat+Dokter', status: 'Ditolak' },
    ],

    get filteredRows() {
        return this.rows.filter(row => {
            const matchesSearch = row.name.toLowerCase().includes(this.search.toLowerCase());
            const matchesClass = this.selectedClass === '' || row.class === this.selectedClass;
            // Date filtering omitted for simple demo
            return matchesSearch && matchesClass;
        });
    },

    toggleAll() {
        if (this.selectedRows.length === this.filteredRows.length) {
            this.selectedRows = [];
        } else {
            this.selectedRows = this.filteredRows.map(row => row.id);
        }
    },

    openProof(url) {
        this.proofImage = url;
        this.showProofModal = true;
    },

    askConfirm(action, id) {
        this.confirmAction = action;
        this.confirmId = id;
        this.showConfirmModal = true;
    },

    processAction() {
        // Simulate API call
        console.log(`Processing ${this.confirmAction} for ID ${this.confirmId}`);
        // Close modal
        this.showConfirmModal = false;
        // Show simulated toast (optional)
        alert('Aksi berhasil diproses!'); 
    }
}">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Izin / Sakit / Alpha Siswa</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau kehadiran siswa dengan mudah.</p>
            </div>
            
            {{-- Bulk Actions (Visible when rows selected) --}}
            <div x-show="selectedRows.length > 0" x-transition class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200" style="display: none;">
                <span class="text-sm font-medium text-gray-700" x-text="selectedRows.length + ' dipilih'"></span>
                <div class="h-4 w-px bg-gray-200 mx-2"></div>
                <button class="text-xs font-medium text-green-600 hover:text-green-700 px-3 py-1.5 hover:bg-green-50 rounded-lg transition-colors">
                    Setujui Semua
                </button>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mt-6">
            {{-- Card Template --}}
            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pengajuan</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">1,248</h3>
                    </div>
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Menunggu</p>
                        <h3 class="text-2xl font-bold text-yellow-600 mt-1">24</h3>
                    </div>
                    <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui</p>
                        <h3 class="text-2xl font-bold text-green-600 mt-1">892</h3>
                    </div>
                    <div class="p-2 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Ditolak</p>
                        <h3 class="text-2xl font-bold text-red-600 mt-1">45</h3>
                    </div>
                    <div class="p-2 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alpha</p>
                        <h3 class="text-2xl font-bold text-gray-600 mt-1">287</h3>
                    </div>
                    <div class="p-2 bg-gray-50 text-gray-600 rounded-lg group-hover:bg-gray-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & TABLE SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Toolbar --}}
        <div class="p-5 border-b border-gray-100 bg-white">
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                {{-- Search --}}
                <div class="relative w-full lg:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input x-model="search" type="text" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 sm:text-sm" 
                        placeholder="Cari nama siswa...">
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                    {{-- Class Dropdown --}}
                    <select x-model="selectedClass" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm rounded-xl bg-gray-50 hover:bg-white transition-all cursor-pointer">
                        <option value="">Semua Kelas</option>
                        <option value="X RPL">X RPL</option>
                        <option value="XI RPL">XI RPL</option>
                    </select>

                    {{-- Date Picker --}}
                    <input x-model="date" type="date" class="block w-full sm:w-auto pl-3 pr-3 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm rounded-xl bg-gray-50 hover:bg-white transition-all cursor-pointer text-gray-500">

                    {{-- Reset --}}
                    <button @click="search=''; selectedClass=''; date=''" 
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                        Reset
                    </button>
                    
                    {{-- Export Button (Optional enhancement) --}}
                    <button class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm shadow-blue-500/30 transition-all">
                        Export
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left">
                            <input type="checkbox" @click="toggleAll()" 
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4 bg-gray-50 cursor-pointer">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis & Alasan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="row in filteredRows" :key="row.id">
                        <tr class="hover:bg-gray-50/80 transition-colors duration-150 group">
                            {{-- Checkbox --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" :value="row.id" x-model="selectedRows"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4 cursor-pointer">
                            </td>

                            {{-- Avatar + Name --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md" x-text="row.name.substring(0,2).toUpperCase()"></div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900" x-text="row.name"></div>
                                        <div class="text-xs text-gray-500">NIS: 123456</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Class --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-md bg-gray-100 text-gray-800 border border-gray-200" x-text="row.class">
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600" x-text="row.date"></td>

                            {{-- Type & Reason --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium" x-text="row.type"></div>
                                <div class="text-xs text-gray-500 truncate max-w-[150px]" x-text="row.reason"></div>
                            </td>

                            {{-- Proof --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <template x-if="row.proof">
                                    <button @click="openProof(row.proof)" class="text-blue-600 hover:text-blue-800 flex items-center gap-1.5 font-medium text-xs transition-colors p-1 hover:bg-blue-50 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </button>
                                </template>
                                <template x-if="!row.proof">
                                    <span class="text-gray-400 text-xs italic opacity-70">-</span>
                                </template>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <span :class="{
                                    'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20': row.status === 'Menunggu',
                                    'bg-green-50 text-green-700 ring-1 ring-green-600/20': row.status === 'Disetujui',
                                    'bg-red-50 text-red-700 ring-1 ring-red-600/20': row.status === 'Ditolak',
                                    'bg-gray-50 text-gray-700 ring-1 ring-gray-600/20': row.status === 'Alpha'
                                }" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm">
                                    <span x-text="row.status"></span>
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <button @click="askConfirm('approve', row.id)" title="Setujui" class="p-1.5 text-green-600 hover:bg-green-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button @click="askConfirm('reject', row.id)" title="Tolak" class="p-1.5 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    <button @click="askConfirm('alpha', row.id)" title="Tandai Alpha" class="p-1.5 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    {{-- Empty State --}}
                    <tr x-show="filteredRows.length === 0" style="display: none;">
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="mx-auto h-24 w-24 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                            <p class="mt-1 text-sm text-gray-500">Coba ubah filter atau pencarian Anda.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</button>
                    <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">10</span> dari <span class="font-medium">97</span> hasil
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600 z-10">3</button>
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                            <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- Proof Modal --}}
    <div x-show="showProofModal" style="display: none;" 
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showProofModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showProofModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showProofModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Bukti Izin / Sakit</h3>
                            <div class="mt-4">
                                <img :src="proofImage" alt="Bukti" class="w-full rounded-lg border border-gray-200">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="showProofModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
                    <a :href="proofImage" target="_blank" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Download</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div x-show="showConfirmModal" style="display: none;" 
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showConfirmModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10" 
                            :class="confirmAction === 'approve' ? 'bg-green-100 text-green-600' : (confirmAction === 'reject' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600')">
                            
                            <template x-if="confirmAction === 'approve'">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </template>
                             <template x-if="confirmAction === 'reject'">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </template>
                             <template x-if="confirmAction === 'alpha'">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/></svg>
                            </template>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Aksi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin <span class="font-bold" x-text="confirmAction === 'approve' ? 'Menyetujui' : (confirmAction === 'reject' ? 'Menolak' : 'Menandai Alpha')"></span> pengajuan ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="processAction()" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        :class="confirmAction === 'approve' ? 'bg-green-600 hover:bg-green-700' : (confirmAction === 'reject' ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-600 hover:bg-gray-700')">
                        Ya, Lanjutkan
                    </button>
                    <button type="button" @click="showConfirmModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
{{-- Alpine.js for Interactivity --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@endsection
