@extends('layouts.admin')

@section('title', 'Input Nilai Rapor')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-32" x-data="inputRaporPage()">
    
    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Input Nilai Rapor</h1>
            <p class="text-gray-500 mt-1">Kelola nilai akhir semester siswa secara kolektif.</p>
        </div>
        <div class="flex gap-3">
             <button @click="showStats = !showStats" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-600"></i> <span x-text="showStats ? 'Tutup Statistik' : 'Lihat Statistik'"></span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3 animate-fade-in shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-bold">{{ session('success') }}</div>
    </div>
    @endif

    {{-- FILTERS --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6 mb-8 mt-2">
        <form method="GET" action="{{ route('guru.akademik.nilai.rapor') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 ml-1">Pilih Kelas</label>
                <select name="class_id" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all appearance-none cursor-pointer">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                    @endforeach
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 bottom-4"></i>
            </div>
            <div class="relative">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 ml-1">Mata Pelajaran</label>
                <select name="subject_id" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all appearance-none cursor-pointer">
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}" {{ $selectedSubjectId == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                    @endforeach
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 bottom-4"></i>
            </div>
            <div class="relative flex items-end">
                <div class="w-full relative">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 ml-1">Cari Siswa</label>
                    <input type="text" x-model="search" placeholder="Ketik nama siswa..." class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-4 bottom-4"></i>
                </div>
            </div>
        </form>
    </div>

    {{-- STATS --}}
    <div x-show="showStats" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-indigo-600 p-5 rounded-2xl shadow-lg text-white">
            <div class="text-[10px] font-bold opacity-60 uppercase mb-1">Rata-rata Kelas</div>
            <div class="text-3xl font-bold" x-text="classAverage"></div>
        </div>
        <div class="bg-emerald-500 p-5 rounded-2xl shadow-lg text-white">
            <div class="text-[10px] font-bold opacity-60 uppercase mb-1">Nilai Tertinggi</div>
            <div class="text-3xl font-bold" x-text="highestScore"></div>
        </div>
        <div class="bg-amber-500 p-5 rounded-2xl shadow-lg text-white">
            <div class="text-[10px] font-bold opacity-60 uppercase mb-1">Tuntas (>= 75)</div>
            <div class="text-3xl font-bold" x-text="passCount + ' Siswa'"></div>
        </div>
        <div class="bg-rose-500 p-5 rounded-2xl shadow-lg text-white">
            <div class="text-[10px] font-bold opacity-60 uppercase mb-1">Remedial (< 75)</div>
            <div class="text-3xl font-bold" x-text="(students.length - passCount) + ' Siswa'"></div>
        </div>
    </div>

    {{-- TABLE FORM --}}
    <form action="{{ route('guru.akademik.nilai.rapor.store') }}" method="POST" id="raporForm">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest w-16">No</th>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Identitas Siswa</th>
                            <th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIS</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-32">Nilai Akhir</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-32">Predikat</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-40">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="(s, index) in filteredStudents" :key="s.id">
                            <tr class="hover:bg-indigo-50/20 transition-colors group">
                                <td class="px-6 py-4 text-xs font-bold text-gray-300" x-text="index + 1"></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs mr-4 transition-transform group-hover:scale-110 shadow-sm" x-text="(s.name || '').substring(0, 2).toUpperCase()"></div>
                                        <div>
                                            <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors" x-text="s.name"></div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Semester Ganjil</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-gray-400 text-[10px]" x-text="s.nis"></td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <input type="number" :name="'grades[' + s.id + ']'" x-model.number="s.score" min="0" max="100" required
                                            class="w-20 px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-center font-black text-sm focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none"
                                            :class="s.score < 75 ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-indigo-600'">
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-4 py-1.5 rounded-lg text-[10px] font-black tracking-widest"
                                        :class="getGradeColor(s.score)"
                                        x-text="calculateGrade(s.score)"></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <template x-if="s.score >= 75">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-bold">
                                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Tuntas
                                        </span>
                                    </template>
                                    <template x-if="s.score < 75">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold">
                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Remedial
                                        </span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredStudents.length === 0">
                            <td colspan="6" class="px-6 py-20 text-center text-gray-400 font-bold"><i data-lucide="users-2" class="w-12 h-12 mx-auto mb-2 opacity-20"></i> Data siswa tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- STICKY FOOTER ACTION --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-gray-200 p-6 z-40 md:pl-72 lg:pl-80">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-6">
                 <div class="hidden lg:flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-600"></div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Siap Disimpan</span>
                </div>
                <div class="flex -space-x-2">
                    <template x-for="s in filteredStudents.slice(0, 5)">
                        <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-[8px] font-bold text-gray-500" x-text="(s.name || '').substring(0, 1)"></div>
                    </template>
                    <div x-show="students.length > 5" class="w-8 h-8 rounded-full bg-indigo-50 border-2 border-white flex items-center justify-center text-[8px] font-bold text-indigo-600" x-text="'+' + (students.length - 5)"></div>
                </div>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <button type="button" @click="fillMax()" class="flex-1 md:flex-none px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all text-sm flex items-center justify-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i> Set 100
                </button>
                <button type="submit" form="raporForm" class="flex-2 md:flex-none px-12 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black shadow-xl shadow-gray-200 transition-all transform active:scale-95 text-sm flex items-center justify-center gap-3">
                    <i data-lucide="save" class="w-4 h-4"></i> SIMPAN NILAI TOTAL
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('inputRaporPage', () => ({
        search: '',
        showStats: false,
        students: @json($students),

        get filteredStudents() {
            return this.students.filter(s => (s.name || '').toLowerCase().includes(this.search.toLowerCase()));
        },

        get classAverage() {
            if (this.students.length === 0) return 0;
            const sum = this.students.reduce((acc, s) => acc + (parseFloat(s.score) || 0), 0);
            return (sum / this.students.length).toFixed(1);
        },

        get highestScore() {
            if (this.students.length === 0) return 0;
            return Math.max(...this.students.map(s => parseFloat(s.score) || 0));
        },

        get passCount() {
            return this.students.filter(s => s.score >= 75).length;
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

        fillMax() {
            if(confirm('Set semua nilai ke 100?')) {
                this.students.forEach(s => s.score = 100);
            }
        }
    }));

    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
