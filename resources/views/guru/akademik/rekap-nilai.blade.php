@extends('layouts.admin')

@section('title', 'Rekap Nilai Kelas')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="rekapNilaiPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Rekap Nilai Kelas</h1>
            <p class="text-gray-500 mt-1">Analisis performa akademik dan peringkat siswa berdasarkan rata-rata nilai.</p>
        </div>
        
        <div class="flex flex-wrap gap-4 items-center bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
            <form method="GET" action="{{ route('guru.akademik.rekap') }}" class="flex gap-4 items-center">
                <div class="relative">
                    <select name="class_id" onchange="this.form.submit()" class="appearance-none bg-gray-50 border border-transparent text-gray-700 py-2.5 pl-4 pr-10 rounded-xl focus:ring-4 focus:ring-indigo-100 font-bold transition-all cursor-pointer hover:bg-gray-100 outline-none">
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>Kelas {{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-3 top-3.5 pointer-events-none"></i>
                </div>
            </form>

            <div class="flex gap-2">
                <button @click="showStats = !showStats" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Tampilkan Statistik">
                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                </button>
                <button onclick="window.print()" class="p-2.5 bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-900 hover:text-white transition-all shadow-sm" title="Cetak Laporan">
                    <i data-lucide="printer" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- STATS SECTION --}}
    <div x-show="showStats" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i data-lucide="trending-up" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Rata-rata Kelas</div>
                <div class="text-2xl font-bold text-gray-900" x-text="stats.average"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i data-lucide="award" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Nilai Tertinggi</div>
                <div class="text-2xl font-bold text-gray-900" x-text="stats.highest"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center"><i data-lucide="alert-triangle" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Nilai Terendah</div>
                <div class="text-2xl font-bold text-gray-900" x-text="stats.lowest"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center"><i data-lucide="users" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Siswa</div>
                <div class="text-2xl font-bold text-gray-900" x-text="students.length"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- CHART --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-200 lg:col-span-1 flex flex-col items-center">
            <div class="w-full mb-6">
                <h3 class="text-lg font-bold text-gray-900">Distribusi Predikat</h3>
                <p class="text-xs text-gray-400 uppercase tracking-tight font-bold">Berdasarkan Total Rata-rata</p>
            </div>
            <div class="w-64 h-64 relative">
                <canvas id="gradeDistributionChart"></canvas>
            </div>
        </div>

        {{-- TABLE RANKING --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 lg:col-span-2 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Peringkat Kelas</h3>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5"></i>
                    <input type="text" x-model="search" placeholder="Cari siswa..." class="pl-10 pr-4 py-2 bg-gray-50 border border-transparent rounded-xl text-sm font-medium focus:ring-4 focus:ring-indigo-50 outline-none w-48 md:w-64 transition-all">
                </div>
            </div>
            
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">Rank</th>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4 text-center">Rata-rata</th>
                            <th class="px-6 py-4 text-center">Predikat</th>
                            <th class="px-6 py-4 w-40">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="(s, index) in filteredStudents" :key="s.id">
                            <tr class="hover:bg-indigo-50/20 transition-colors group">
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center">
                                        <template x-if="index === 0">
                                            <span class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-700 rounded-xl font-black text-xs ring-4 ring-amber-50">1</span>
                                        </template>
                                        <template x-if="index === 1">
                                            <span class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-600 rounded-xl font-black text-xs ring-4 ring-slate-50">2</span>
                                        </template>
                                        <template x-if="index === 2">
                                            <span class="w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-700 rounded-xl font-black text-xs ring-4 ring-orange-50">3</span>
                                        </template>
                                        <template x-if="index > 2">
                                            <span class="text-gray-300 font-black text-xs" x-text="index + 1"></span>
                                        </template>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900" x-text="s.name"></div>
                                    <div class="text-[10px] text-gray-400 font-mono" x-text="s.nis"></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-base font-black text-gray-900" x-text="s.score.toFixed(1)"></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black tracking-widest"
                                        :class="getGradeColor(s.score)"
                                        x-text="calculateGrade(s.score)"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-100 rounded-full h-2 shadow-inner overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700"
                                            :style="'width: ' + s.score + '%'"
                                            :class="s.score >= 75 ? 'bg-indigo-600' : 'bg-rose-500'"></div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div x-show="filteredStudents.length === 0" class="py-12 text-center text-gray-400 font-bold">
                <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-2 opacity-20"></i> Data tidak ditemukan.
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rekapNilaiPage', () => ({
        search: '',
        showStats: true,
        students: @json($students->values()), // values() to reset keys for JS array
        chartInstance: null,

        init() {
            this.$nextTick(() => this.initChart());
        },

        get filteredStudents() {
            return this.students.filter(s => (s.name || '').toLowerCase().includes(this.search.toLowerCase()));
        },

        get stats() {
            if (this.students.length === 0) return { average: 0, highest: 0, lowest: 0 };
            const scores = this.students.map(s => s.score);
            return {
                average: (scores.reduce((a, b) => a + b, 0) / scores.length).toFixed(1),
                highest: Math.max(...scores).toFixed(1),
                lowest: Math.min(...scores).toFixed(1)
            };
        },

        calculateGrade(score) {
            if (score >= 90) return 'A';
            if (score >= 80) return 'B';
            if (score >= 75) return 'C';
            return 'D';
        },

        getGradeColor(score) {
            const colors = {
                'A': 'bg-emerald-100 text-emerald-700',
                'B': 'bg-blue-100 text-blue-700',
                'C': 'bg-amber-100 text-amber-700',
                'D': 'bg-rose-100 text-rose-700'
            };
            return colors[this.calculateGrade(score)];
        },

        initChart() {
            const ctx = document.getElementById('gradeDistributionChart');
            if(!ctx) return;

            const dist = { A: 0, B: 0, C: 0, D: 0 };
            this.students.forEach(s => dist[this.calculateGrade(s.score)]++);

            this.chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Sangat Baik (A)', 'Baik (B)', 'Cukup (C)', 'Kurang (D)'],
                    datasets: [{
                        data: [dist.A, dist.B, dist.C, dist.D],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f43f5e'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { weight: 'bold', size: 10 } } }
                    },
                    cutout: '75%'
                }
            });
        }
    }));

    if (window.lucide) lucide.createIcons();
});
</script>
@endpush