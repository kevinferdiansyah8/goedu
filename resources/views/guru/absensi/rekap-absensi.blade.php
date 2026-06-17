@extends('layouts.sidebar-guru')

@section('title', 'Rekap Absensi Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="rekapPage()">
    
    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Absensi Siswa</h1>
        <p class="text-sm text-gray-500 mt-1">Analisis kehadiran siswa secara real-time dari database.</p>
    </div>

    {{-- CLASS FILTER --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('guru.absensi.rekap') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Kelas</label>
                <select name="class_id" onchange="this.form.submit()" class="text-sm border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white px-4 py-2.5">
                    @foreach($classes as $kls)
                        <option value="{{ $kls->id }}" {{ $selectedClassId == $kls->id ? 'selected' : '' }}>{{ $kls->tingkat }} {{ $kls->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal (Harian)</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()" class="text-sm border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white px-4 py-2.5">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Bulan (Bulanan)</label>
                <input type="month" name="bulan" value="{{ $bulan }}" onchange="this.form.submit()" class="text-sm border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white px-4 py-2.5">
            </div>
            <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
        </form>
    </div>

    {{-- ANALYTICS CARDS (Realtime) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Total Siswa</div>
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalSiswa }}</div>
            <div class="text-xs text-green-600 flex items-center mt-1"><span>Di kelas ini</span></div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Hadir</div>
                <div class="p-1.5 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $statsHadir }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $tanggal }}</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Sakit</div>
                <div class="p-1.5 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $statsSakit }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $tanggal }}</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Izin</div>
                <div class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $statsIzin }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $tanggal }}</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Alpha</div>
                <div class="p-1.5 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $statsAlpha }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $tanggal }}</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs font-medium text-gray-500 uppercase">Kehadiran</div>
                <div class="p-1.5 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $pctKehadiran }}%</div>
            <div class="text-xs text-gray-500 mt-1">{{ $tanggal }}</div>
        </div>
    </div>

    {{-- CHARTS SECTION (Realtime data) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Distribusi Kehadiran ({{ $tanggal }})</h3>
            <div class="relative h-64 overflow-hidden">
                <canvas id="attendanceDonutChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Tren Kehadiran (7 Hari Terakhir)</h3>
            <div class="relative h-64">
                <canvas id="attendanceLineChart"></canvas>
            </div>
        </div>
    </div>

    {{-- TAB CONTENT --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
            <div class="flex bg-gray-100/80 p-1 rounded-xl w-full lg:w-auto">
                <button @click="activeTab = 'harian'" :class="activeTab === 'harian' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">Rekap Harian</button>
                <button @click="activeTab = 'bulanan'" :class="activeTab === 'bulanan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">Rekap Bulanan</button>
                <button @click="activeTab = 'individu'" :class="activeTab === 'individu' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="flex-1 lg:flex-none px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">Per Siswa</button>
            </div>
        </div>

        {{-- 1. REKAP HARIAN --}}
        <div x-show="activeTab === 'harian'" x-transition class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rekapHarian as $d)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">{{ substr($d['nama'], 0, 2) }}</div>
                                <div class="text-sm font-medium text-gray-900">{{ $d['nama'] }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d['kelas'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($d['status'] === 'Hadir') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                            @elseif($d['status'] === 'Sakit') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Sakit</span>
                            @elseif($d['status'] === 'Izin') <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Izin</span>
                            @elseif(in_array($d['status'], ['Alpha', 'Tanpa Keterangan'])) <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Alpha</span>
                            @else <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Belum Absen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $d['jam_masuk'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data absensi untuk tanggal ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 2. REKAP BULANAN --}}
        <div x-show="activeTab === 'bulanan'" style="display: none;" x-transition class="overflow-x-auto">
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
                    @forelse($rekapBulanan as $d)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $d['nama'] }}</div></td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['hadir'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['sakit'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $d['izin'] }}</td>
                        <td class="px-6 py-4 text-center text-sm text-red-600 font-medium">{{ $d['alpha'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center">
                                <span class="text-sm font-bold {{ $d['persen'] < 75 ? 'text-red-600' : 'text-green-600' }}">{{ $d['persen'] }}%</span>
                                <div class="w-16 h-1.5 bg-gray-200 rounded-full ml-2 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $d['persen'] < 75 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $d['persen'] }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data absensi untuk bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 3. PER SISWA (Detail) --}}
        <div x-show="activeTab === 'individu'" style="display: none;" x-transition class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- List Siswa --}}
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 h-[500px] overflow-y-auto">
                    <h3 class="font-semibold text-gray-700 mb-3">Pilih Siswa</h3>
                    <ul class="space-y-2">
                        @foreach($individuSiswa as $idx => $siswa)
                        <li @click="selectStudent({{ $idx }})" 
                            :class="selectedStudentIdx === {{ $idx }} ? 'bg-white border-blue-500 ring-1 ring-blue-500' : 'bg-white border-transparent hover:border-gray-300'"
                            class="p-3 rounded-lg border shadow-sm cursor-pointer transition-all flex items-center justify-between group">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ $siswa['nama'] }}</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Detail Content --}}
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div x-show="selectedStudentIdx === null" class="h-full flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <p>Pilih siswa dari daftar untuk melihat detail.</p>
                    </div>

                    <div x-show="selectedStudentIdx !== null" style="display: none;">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900" x-text="siswaData[selectedStudentIdx]?.nama"></h2>
                                <p class="text-gray-500"><span x-text="'Kelas ' + (siswaData[selectedStudentIdx]?.kelas || '-')"></span> • <span x-text="'NIS: ' + (siswaData[selectedStudentIdx]?.nis || '-')"></span></p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-green-600" x-text="(siswaData[selectedStudentIdx]?.persen || 0) + '%'"></div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Kehadiran</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-8">
                            <div class="bg-green-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-green-600 font-medium">Hadir</div>
                                <div class="text-xl font-bold text-green-700" x-text="siswaData[selectedStudentIdx]?.hadir || 0"></div>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-yellow-600 font-medium">Sakit</div>
                                <div class="text-xl font-bold text-yellow-700" x-text="siswaData[selectedStudentIdx]?.sakit || 0"></div>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-indigo-600 font-medium">Izin</div>
                                <div class="text-xl font-bold text-indigo-700" x-text="siswaData[selectedStudentIdx]?.izin || 0"></div>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg text-center">
                                <div class="text-sm text-red-600 font-medium">Alpha</div>
                                <div class="text-xl font-bold text-red-700" x-text="siswaData[selectedStudentIdx]?.alpha || 0"></div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 mb-3">Riwayat Terbaru</h3>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                <template x-for="(r, i) in (siswaData[selectedStudentIdx]?.riwayat || [])" :key="i">
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <span class="text-sm text-gray-600" x-text="r.tanggal"></span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-800': r.status === 'Hadir',
                                                'bg-yellow-100 text-yellow-800': r.status === 'Sakit',
                                                'bg-indigo-100 text-indigo-800': r.status === 'Izin',
                                                'bg-red-100 text-red-800': r.status === 'Alpha' || r.status === 'Tanpa Keterangan'
                                            }" x-text="r.status"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rekapPage', () => ({
            activeTab: 'harian',
            selectedStudentIdx: null,
            siswaData: @json($individuSiswa),

            selectStudent(idx) {
                this.selectedStudentIdx = idx;
            },

            init() {
                this.$nextTick(() => { this.initCharts(); });
            },

            initCharts() {
                // Donut Chart (realtime data)
                const ctxDonut = document.getElementById('attendanceDonutChart');
                if (ctxDonut) {
                    new Chart(ctxDonut.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Hadir', 'Sakit', 'Izin', 'Alpha'],
                            datasets: [{
                                data: @json($donutData),
                                backgroundColor: ['#10B981', '#F59E0B', '#6366F1', '#EF4444'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } } },
                            cutout: '75%'
                        }
                    });
                }

                // Line Chart (realtime 7-day data)
                const ctxLine = document.getElementById('attendanceLineChart');
                if (ctxLine) {
                    new Chart(ctxLine.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Tingkat Kehadiran (%)',
                                data: @json($chartData),
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true, tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, max: 100, grid: { borderDash: [2, 4] } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
            }
        }));
    });
</script>
@endpush
@endsection
