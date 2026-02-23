@extends('layouts.admin')

@section('title', 'Rekap Absensi Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="rekapPage()">
    
    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Absensi Siswa</h1>
        <p class="text-sm text-gray-500 mt-1">Analisis kehadiran siswa secara real-time dan historis.</p>
    </div>

    {{-- ANALYTICS CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        {{-- Card 1: Total Siswa --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Total Siswa</div>
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">36</div>
            <div class="text-xs text-green-600 flex items-center mt-1">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                <span>100% Aktif</span>
            </div>
        </div>

        {{-- Card 2: Hadir --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Hadir</div>
                <div class="p-1.5 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">32</div>
            <div class="text-xs text-gray-500 mt-1">Hari ini</div>
        </div>

        {{-- Card 3: Sakit --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Sakit</div>
                <div class="p-1.5 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">2</div>
            <div class="text-xs text-red-500 flex items-center mt-1">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+1 dr kmrn</span>
            </div>
        </div>

        {{-- Card 4: Izin --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Izin</div>
                <div class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">1</div>
            <div class="text-xs text-gray-500 mt-1">Hari ini</div>
        </div>

        {{-- Card 5: Alpha --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Alpha</div>
                <div class="p-1.5 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">1</div>
            <div class="text-xs text-green-600 flex items-center mt-1">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                <span>-2 dr kmrn</span>
            </div>
        </div>

        {{-- Card 6: Ratio --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Kehadiran</div>
                <div class="p-1.5 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">89%</div>
            <div class="text-xs text-gray-500 mt-1">Avg Bulanan</div>
        </div>
    </div>

    {{-- CHARTS SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Donut Chart --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Distribusi Kehadiran Hari Ini</h3>
            <div class="relative h-64 overflow-hidden">
                <canvas id="attendanceDonutChart"></canvas>
            </div>
        </div>

        {{-- Line Chart --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700">Tren Kehadiran (30 Hari Terakhir)</h3>
                <select class="text-xs border-gray-200 rounded-lg focus:ring-0 text-gray-500">
                    <option>30 Hari</option>
                    <option>7 Hari</option>
                    <option>Semester Ini</option>
                </select>
            </div>
           <div class="relative h-64">
                <canvas id="attendanceLineChart"></canvas>
            </div>
        </div>
    </div>

    {{-- FILTER & TAB SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        
        {{-- Filters Navbar --}}
        <div class="p-4 border-b border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
             {{-- Tabs --}}
            <div class="flex bg-gray-100/80 p-1 rounded-xl w-full lg:w-auto">
                <button @click="activeTab = 'harian'" 
                    :class="activeTab === 'harian' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                    Rekap Harian
                </button>
                <button @click="activeTab = 'bulanan'" 
                    :class="activeTab === 'bulanan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                    Rekap Bulanan
                </button>
                <button @click="activeTab = 'individu'" 
                    :class="activeTab === 'individu' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                    Per Siswa
                </button>
            </div>

            {{-- Filter Controls --}}
            <div class="flex flex-wrap gap-2 lg:gap-3 items-center">
                <select class="text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 hover:bg-white transition-colors">
                    <option>Semua Kelas</option>
                    <option>X RPL</option>
                    <option>XI RPL</option>
                </select>

                <input type="date" class="text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 hover:bg-white transition-colors text-gray-500">

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Cari siswa..." class="pl-9 text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 hover:bg-white transition-colors w-40 lg:w-48">
                </div>

                <div class="h-6 w-px bg-gray-200 mx-1 hidden lg:block"></div>

                <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span class="hidden lg:inline">Export</span>
                </button>
            </div>
        </div>

        {{-- TAB CONTENT --}}
        
        {{-- 1. REKAP HARIAN --}}
        <div x-show="activeTab === 'harian'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Loop Placeholder --}}
                    @foreach(['Rina Putri', 'Dewi Lestari', 'Agus Salim', 'Budi Santoso'] as $index => $nama)
                    @php $status = ['Hadir', 'Sakit', 'Alpha', 'Izin'][$index]; @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">
                                    {{ substr($nama, 0, 2) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">X RPL</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($status === 'Hadir') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                            @elseif($status === 'Sakit') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Sakit</span>
                            @elseif($status === 'Izin') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Izin</span>
                            @else <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Alpha</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            {{ $status === 'Hadir' ? '07:05' : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            {{ $status === 'Hadir' ? '14:00' : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 2. REKAP BULANAN --}}
        <div x-show="activeTab === 'bulanan'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Sakit</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Izin</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Alpha</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach([
                        ['nama' => 'Rina Putri', 'h' => 22, 's' => 1, 'i' => 0, 'a' => 0],
                        ['nama' => 'Dewi Lestari', 'h' => 20, 's' => 2, 'i' => 1, 'a' => 0],
                        ['nama' => 'Agus Salim', 'h' => 18, 's' => 0, 'i' => 0, 'a' => 5],
                    ] as $d)
                    @php $p = round(($d['h']/23)*100); @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $d['nama'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['h'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['s'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['i'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-red-600 font-medium">{{ $d['a'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center">
                                <span class="text-sm font-bold {{ $p < 75 ? 'text-red-600' : 'text-green-600' }}">{{ $p }}%</span>
                                <div class="w-16 h-1.5 bg-gray-200 rounded-full ml-2 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $p < 75 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $p }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 3. PER SISWA (Detail) --}}
        <div x-show="activeTab === 'individu'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- List Siswa --}}
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 h-[500px] overflow-y-auto">
                    <h3 class="font-semibold text-gray-700 mb-3">Pilih Siswa</h3>
                    <ul class="space-y-2">
                        @foreach(['Rina Putri', 'Dewi Lestari', 'Agus Salim', 'Budi Santoso', 'Citra Kirana'] as $nama)
                        <li @click="selectStudent('{{ $nama }}')" 
                            :class="selectedStudent === '{{ $nama }}' ? 'bg-white border-blue-500 ring-1 ring-blue-500' : 'bg-white border-transparent hover:border-gray-300'"
                            class="p-3 rounded-lg border shadow-sm cursor-pointer transition-all flex items-center justify-between group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ $nama }}</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Detail Content --}}
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div x-show="!selectedStudent" class="h-full flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <p>Pilih siswa dari daftar untuk melihat detail.</p>
                    </div>

                    <div x-show="selectedStudent" style="display: none;">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900" x-text="selectedStudent"></h2>
                                <p class="text-gray-500">Kelas X RPL • NIS: 123456</p>
                            </div>
                             <div class="text-right">
                                <div class="text-3xl font-bold text-green-600">95%</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Kehadiran</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-8">
                            <div class="bg-green-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-green-600 font-medium">Hadir</div>
                                <div class="text-xl font-bold text-green-700">22</div>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-yellow-600 font-medium">Sakit</div>
                                <div class="text-xl font-bold text-yellow-700">1</div>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-indigo-600 font-medium">Izin</div>
                                <div class="text-xl font-bold text-indigo-700">0</div>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-red-600 font-medium">Alpha</div>
                                <div class="text-xl font-bold text-red-700">0</div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 mb-3">Grafik Bulanan</h3>
                            <div class="bg-gray-50 rounded-xl p-4 h-48 flex items-center justify-center">
                                <p class="text-gray-400 italic">Chart individual siswa akan tampil di sini...</p>
                                {{-- Placeholder for individual chart --}}
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rekapPage', () => ({
            activeTab: 'harian',
            selectedStudent: null,
            
            selectStudent(name) {
                this.selectedStudent = name;
            },

            init() {
                // Initialize Charts
                this.$nextTick(() => {
                    this.initCharts();
                });
            },

            initCharts() {
                // Donut Chart
                const ctxDonut = document.getElementById('attendanceDonutChart').getContext('2d');
                new Chart(ctxDonut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Sakit', 'Izin', 'Alpha'],
                        datasets: [{
                            data: [32, 2, 1, 1],
                            backgroundColor: ['#10B981', '#F59E0B', '#6366F1', '#EF4444'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } }
                        },
                        cutout: '75%'
                    }
                });

                // Line Chart
                const ctxLine = document.getElementById('attendanceLineChart').getContext('2d');
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: ['1 Feb', '2 Feb', '3 Feb', '4 Feb', '5 Feb', '6 Feb', '7 Feb'],
                        datasets: [{
                            label: 'Tingkat Kehadiran (%)',
                            data: [95, 92, 98, 88, 96, 100, 94],
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: false, min: 80, max: 100, grid: { borderDash: [2, 4] } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        }));
    });
</script>
@endpush
@endsection
