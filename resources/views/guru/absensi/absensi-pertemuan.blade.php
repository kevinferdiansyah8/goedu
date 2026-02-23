@extends('layouts.admin')

@section('title', 'Absensi Siswa')

@section('content')
@php
$kelasList = ['X RPL 1', 'X RPL 2', 'XI RPL 1'];

// Simulasi data siswa (biasanya dari DB)
$siswa = [
    'X RPL 1' => [
        ['id' => 1, 'nama' => 'Andi Saputra', 'nis' => '10111'],
        ['id' => 2, 'nama' => 'Budi Hartono', 'nis' => '10112'],
        ['id' => 3, 'nama' => 'Citra Lestari', 'nis' => '10113'],
        ['id' => 4, 'nama' => 'Doni Darmawan', 'nis' => '10114'],
        ['id' => 5, 'nama' => 'Eka Putri', 'nis' => '10115'],
    ],
    'X RPL 2' => [
        ['id' => 6, 'nama' => 'Feri Irawan', 'nis' => '10211'],
        ['id' => 7, 'nama' => 'Gina Astuti', 'nis' => '10212'],
    ],
    'XI RPL 1' => [
        ['id' => 8, 'nama' => 'Hadi Sucipto', 'nis' => '11111'],
        ['id' => 9, 'nama' => 'Indah Permata', 'nis' => '11112'],
    ],
];
@endphp

<div class="min-h-screen bg-[#F3F4F6] font-sans pb-20">
    <!-- Top Navigation / Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Absensi Siswa</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola kehadiran harian kelas Anda</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Laporan
                    </button>
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        Bantuan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1">
            <div class="flex flex-col md:flex-row gap-0 md:divide-x divide-gray-100">
                <div class="flex-1 p-4">
                    <label for="kelasSelect" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kelas</label>
                    <div class="relative">
                        <select id="kelasSelect" class="block w-full pl-3 pr-10 py-2 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition-colors cursor-pointer hover:bg-gray-50 bg-transparent">
                            <option value="">Pilih Kelas...</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}">{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex-1 p-4">
                    <label for="tanggal" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                    <input type="date" id="tanggal" class="block w-full px-3 py-2 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md hover:bg-gray-50 bg-transparent transition-colors">
                </div>
                <div class="p-4 flex items-end">
                    <button onclick="loadSiswa()" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
                        Tampilkan Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="text-center py-20 animate-fade-in">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada data ditampilkan</h3>
            <p class="mt-1 text-sm text-gray-500">Silakan pilih Kelas dan Tanggal untuk mulai melakukan absensi siswa.</p>
        </div>

        <!-- Content Area -->
        <div id="contentArea" class="hidden space-y-6">
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="text-xs font-medium text-gray-500 uppercase">Total Siswa</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900" id="statTotal">10</span>
                        <span class="ml-2 text-sm text-gray-400">orang</span>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-b-2 border-green-500">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-semibold text-green-600 uppercase">Hadir</div>
                        <span class="bg-green-100 text-green-800 text-[10px] px-1.5 py-0.5 rounded-full font-medium">H</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-900" id="statHadir">0</div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-b-2 border-yellow-500">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-semibold text-yellow-600 uppercase">Izin</div>
                        <span class="bg-yellow-100 text-yellow-800 text-[10px] px-1.5 py-0.5 rounded-full font-medium">I</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-900" id="statIzin">0</div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-b-2 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-semibold text-blue-600 uppercase">Sakit</div>
                        <span class="bg-blue-100 text-blue-800 text-[10px] px-1.5 py-0.5 rounded-full font-medium">S</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-900" id="statSakit">0</div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-b-2 border-red-500">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-semibold text-red-600 uppercase">Alpha</div>
                        <span class="bg-red-100 text-red-800 text-[10px] px-1.5 py-0.5 rounded-full font-medium">A</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-900" id="statAlpha">0</div>
                </div>
            </div>

            <!-- Toolbar Actions -->
            <div class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex gap-2 w-full sm:w-auto">
                    <button onclick="setAll('Hadir')" class="flex-1 sm:flex-none inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Hadir Semua
                    </button>
                    <button onclick="resetAll()" class="flex-1 sm:flex-none inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                        <svg class="w-3 h-3 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                </div>
                <div class="w-full sm:w-auto relative">
                    <input type="text" id="searchSiswa" placeholder="Cari siswa..." class="block w-full pl-9 pr-3 py-1.5 border-gray-300 rounded-md leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa Info
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Kehadiran
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                                Ket.
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Rows populated by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Floating / Sticky Footer Action -->
            <div class="fixed bottom-6 right-6 z-40">
                <button id="btnSimpan" onclick="simpanAbsensi()" class="group flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-indigo-600 shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                    <svg id="iconSave" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <svg id="iconLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Simpan Absensi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar for Table if needed */
    .status-btn {
        @apply flex-1 flex items-center justify-center py-2 text-sm font-medium border border-transparent rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500;
    }
    .status-btn-active {
        @apply shadow-sm ring-1 ring-inset;
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
const siswaData = @json($siswa);
let currentData = [];

function loadSiswa() {
    const kelas = document.getElementById('kelasSelect').value;
    const contentArea = document.getElementById('contentArea');
    const emptyState = document.getElementById('emptyState');
    const tableBody = document.getElementById('tableBody');

    if (!kelas) {
        alert('Harap pilih kelas terlebih dahulu');
        return;
    }

    // Reset view
    emptyState.classList.add('hidden');
    contentArea.classList.remove('hidden');
    contentArea.classList.add('animate-fade-in');
    
    // Process Data
    currentData = siswaData[kelas].map(s => ({ ...s, status: '' })); // Initialize with empty status or fetch from DB
    
    renderTable();
    updateStats();
}

function renderTable() {
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';
    
    document.getElementById('statTotal').innerText = currentData.length;

    currentData.forEach((siswa, index) => {
        const rowId = `row-${siswa.id}`;
        
        let rowClass = 'hover:bg-gray-50 transition-colors';
        // Apply row coloring based on status
        if(siswa.status === 'Hadir') rowClass = 'bg-green-50/50 hover:bg-green-50';
        if(siswa.status === 'Izin') rowClass = 'bg-yellow-50/50 hover:bg-yellow-50';
        if(siswa.status === 'Sakit') rowClass = 'bg-blue-50/50 hover:bg-blue-50';
        if(siswa.status === 'Alpha') rowClass = 'bg-red-50/50 hover:bg-red-50';

        const tr = document.createElement('tr');
        tr.className = rowClass;
        tr.id = rowId;
        
        tr.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">${index + 1}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-9 w-9 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-sm">
                        ${siswa.nama.substring(0,2).toUpperCase()}
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold text-gray-900">${siswa.nama}</div>
                        <div class="text-xs text-gray-500">NIS: ${siswa.nis}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="inline-flex bg-gray-100 p-1 rounded-lg border border-gray-200" role="group">
                    ${renderToggleButton(index, 'Hadir', 'text-green-700', 'bg-white shadow-sm ring-1 ring-black/5', 'hover:bg-gray-200')}
                    ${renderToggleButton(index, 'Izin', 'text-yellow-700', 'bg-white shadow-sm ring-1 ring-black/5', 'hover:bg-gray-200')}
                    ${renderToggleButton(index, 'Sakit', 'text-blue-700', 'bg-white shadow-sm ring-1 ring-black/5', 'hover:bg-gray-200')}
                    ${renderToggleButton(index, 'Alpha', 'text-red-700', 'bg-white shadow-sm ring-1 ring-black/5', 'hover:bg-gray-200')}
                </div>
            </td>
             <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </td>
        `;
        tableBody.appendChild(tr);
    });
}

function renderToggleButton(index, type, textClass, activeClass, inactiveClass) {
    const isSelected = currentData[index].status === type;
    const finalClass = isSelected ? activeClass : inactiveClass;
    const label = type === 'Hadir' ? 'H' : type === 'Izin' ? 'I' : type === 'Sakit' ? 'S' : 'A';
    
    // Label long for accessibility, short for display
    let icon = '';
    if(type === 'Hadir') icon = '<svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>';
    if(type === 'Izin') icon = '<span class="text-xs font-bold text-yellow-600">I</span>';
    if(type === 'Sakit') icon = '<span class="text-xs font-bold text-blue-600">S</span>';
    if(type === 'Alpha') icon = '<span class="text-xs font-bold text-red-600">A</span>';

    // If not selected, show gray icons
    if(!isSelected) {
         if(type === 'Hadir') icon = 'H';
         if(type === 'Izin') icon = 'I';
         if(type === 'Sakit') icon = 'S';
         if(type === 'Alpha') icon = 'A';
    }

    return `
        <button type="button" onclick="setStatus(${index}, '${type}')" 
            class="w-10 h-8 rounded-md flex items-center justify-center text-xs font-medium transition-all duration-200 ${isSelected ? 'shadow-sm bg-white font-bold ' + textClass : 'text-gray-500 hover:bg-gray-200/50'}">
            ${isSelected && type === 'Hadir' ? `<svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>` : (isSelected ? type.charAt(0) : type.charAt(0))}
        </button>
    `;
}

function setStatus(index, status) {
    // If clicking same status, maybe toggle off? or keep it on. Let's keep it simple: switch to it.
    // If toggle capability needed:
    if (currentData[index].status === status) {
        currentData[index].status = '';
    } else {
        currentData[index].status = status;
    }
    
    // Re-render ONLY the row would be better for performance, but for list < 50, re-render all is fine
    renderTable();
    updateStats();
}

function updateStats() {
    let counts = { Hadir: 0, Izin: 0, Sakit: 0, Alpha: 0 };
    currentData.forEach(s => {
        if (counts[s.status] !== undefined) counts[s.status]++;
    });

    // Animate Text
    document.getElementById('statHadir').innerText = counts.Hadir;
    document.getElementById('statIzin').innerText = counts.Izin;
    document.getElementById('statSakit').innerText = counts.Sakit;
    document.getElementById('statAlpha').innerText = counts.Alpha;
}

function setAll(status) {
    currentData = currentData.map(s => ({ ...s, status: status }));
    renderTable();
    updateStats();
}

function resetAll() {
    currentData = currentData.map(s => ({ ...s, status: '' }));
    renderTable();
    updateStats();
}

function simpanAbsensi() {
    const btn = document.getElementById('btnSimpan');
    const iconSave = document.getElementById('iconSave');
    const iconLoading = document.getElementById('iconLoading');

    // Loading State
    btn.disabled = true;
    btn.classList.add('opacity-75', 'cursor-not-allowed');
    iconSave.classList.add('hidden');
    iconLoading.classList.remove('hidden');

    // Simulate API Call
    setTimeout(() => {
        btn.disabled = false;
        btn.classList.remove('opacity-75', 'cursor-not-allowed');
        iconSave.classList.remove('hidden');
        iconLoading.classList.add('hidden');
        
        // Success Feedback
        alert('Data absensi berhasil disimpan!');
    }, 1500);
}

// Simple Search Filter
document.getElementById('searchSiswa').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    });
});
</script>
@endsection
