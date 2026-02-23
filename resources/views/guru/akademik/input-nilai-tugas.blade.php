@extends('layouts.admin')

@section('title', 'Input Nilai Tugas')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="inputNilaiPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Input Nilai Tugas / Ulangan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola penilaian siswa dengan sistem validasi otomatis.</p>
    </div>

    {{-- ANALYTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Card 1: Total Siswa --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-gray-900" x-text="students.length"></h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        {{-- Card 2: Sudah Dinilai --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sudah Dinilai</p>
                    <h3 class="text-2xl font-bold text-green-600" x-text="gradedCount"></h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                <div class="bg-green-500 h-1.5 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
            </div>
        </div>

         {{-- Card 3: Belum Dinilai --}}
         <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Belum Dinilai</p>
                    <h3 class="text-2xl font-bold text-red-600" x-text="students.length - gradedCount"></h3>
                </div>
                <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                <div class="bg-red-500 h-1.5 rounded-full transition-all duration-300" :style="`width: ${100 - progress}%`"></div>
            </div>
        </div>

        {{-- Card 4: Rata-Rata --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-Rata Kelas</p>
                    <h3 class="text-2xl font-bold text-indigo-600" x-text="averageScore"></h3>
                </div>
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">
                KKM: <span class="font-bold text-gray-700">75</span>
            </div>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-center">
             {{-- Basic Filters --}}
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                <select class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 cursor-pointer hover:bg-white transition-colors">
                    <option>X IPA 1</option>
                    <option>X IPA 2</option>
                </select>
                <select class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 cursor-pointer hover:bg-white transition-colors">
                    <option>Tugas Harian</option>
                    <option>Ulangan Harian</option>
                    <option>UTS</option>
                    <option>UAS</option>
                </select>
                <input type="date" class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 cursor-pointer hover:bg-white transition-colors">
            </div>

            {{-- Advanced Tools --}}
            <div class="flex flex-wrap gap-3 w-full lg:w-auto items-center justify-end">
                {{-- Search --}}
                 <div class="relative w-full lg:w-48">
                    <input type="text" x-model="searchQuery" placeholder="Cari Siswa..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                {{-- Fill All --}}
                <div class="flex rounded-xl shadow-sm">
                    <input type="number" x-model="fillValue" placeholder="Nilai..." class="w-20 px-3 py-2 text-sm border border-gray-200 rounded-l-xl focus:ring-blue-500 focus:border-blue-500">
                    <button @click="fillAll()" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-200 rounded-r-xl transition-colors">
                        Isi Semua
                    </button>
                </div>

                 {{-- Reset --}}
                 <button @click="resetScores()" class="p-2 text-gray-500 hover:text-red-600 bg-gray-50 hover:bg-red-50 rounded-xl transition-colors border border-gray-200" title="Reset Nilai">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MAIN FORM --}}
    <form method="POST" action="">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-20">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider cursor-pointer hover:text-gray-900 group" @click="sortBy('name')">
                                Nama Siswa <span class="text-gray-400 group-hover:text-gray-600 transition-colors">↕</span>
                            </th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider w-32">NIS</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider w-40 cursor-pointer hover:text-gray-900 group" @click="sortBy('score')">
                                Nilai <span class="text-gray-400 group-hover:text-gray-600 transition-colors">↕</span>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider w-40">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(student, index) in filteredStudents" :key="student.id">
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4 text-gray-500" x-text="index + 1"></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs">
                                            <span x-text="student.name.substring(0,2).toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900" x-text="student.name"></div>
                                        </div>
                                    </div>
                                    <!-- HIDDEN INPUTS FOR BACKEND -->
                                    <input type="hidden" name="siswa_id[]" :value="student.id">
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-mono" x-text="student.nis"></td>
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            name="nilai[]" 
                                            x-model.number="student.score" 
                                            min="0" 
                                            max="100"
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-opacity-50 transition-all font-semibold text-center"
                                            :class="{
                                                'border-gray-200 focus:border-blue-500 focus:ring-blue-500': !student.score && student.score !== 0,
                                                'border-green-500 text-green-700 bg-green-50 focus:border-green-600 focus:ring-green-200': student.score >= 75,
                                                'border-red-500 text-red-700 bg-red-50 focus:border-red-600 focus:ring-red-200': student.score < 75 && (student.score || student.score === 0)
                                            }"
                                        >
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span 
                                        class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1 transition-all"
                                        :class="{
                                            'bg-gray-100 text-gray-500': !student.score && student.score !== 0,
                                            'bg-green-100 text-green-700': student.score >= 75,
                                            'bg-red-100 text-red-700': student.score < 75 && (student.score || student.score === 0)
                                        }"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full" :class="{
                                            'bg-gray-400': !student.score && student.score !== 0,
                                            'bg-green-500': student.score >= 75,
                                            'bg-red-500': student.score < 75 && (student.score || student.score === 0)
                                        }"></span>
                                        <span x-text="getStatus(student.score)"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                        
                         {{-- Empty State --}}
                        <tr x-show="filteredStudents.length === 0">
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <p>Tidak ada siswa ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FLOATING ACTION BUTTON --}}
        <div class="fixed bottom-6 right-6 z-40 transition-transform duration-300" :class="{'translate-y-24': gradedCount === 0 && false}"> 
            {{-- Note: Always show for now, functionality first --}}
            <button 
                type="submit" 
                class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl hover:scale-105 transition-all focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="gradedCount === 0"
                @click="showToast = true"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                <span>Simpan Nilai</span>
                <span class="bg-blue-800 text-xs px-2 py-0.5 rounded-full ml-1" x-text="gradedCount + '/' + students.length"></span>
            </button>
        </div>
    </form>
    
    {{-- TOAST NOTIFICATION COPY --}}
    <div 
        x-show="showToast" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        class="fixed bottom-6 left-6 z-50 bg-gray-900/90 text-white px-6 py-3 rounded-xl shadow-2xl backdrop-blur-sm flex items-center gap-3"
        style="display: none;"
    >
        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <div>
            <p class="text-sm font-semibold">Menyimpan Nilai...</p>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inputNilaiPage', () => ({
            searchQuery: '',
            fillValue: '',
            showToast: false,
            sortDir: 'asc',
            
            @if(isset($students))
            students: @json($students),
            @else
            students: [
                { id: 1, name: 'Ahmad Fauzi', nis: '20230101', score: 85 },
                { id: 2, name: 'Budi Santoso', nis: '20230102', score: null },
                { id: 3, name: 'Citra Kirana', nis: '20230103', score: 92 },
                { id: 4, name: 'Dewi Lestari', nis: '20230104', score: 70 },
                { id: 5, name: 'Eko Kurniawan', nis: '20230105', score: null },
                { id: 6, name: 'Fajar Nugraha', nis: '20230106', score: 78 },
            ],
            @endif

            get filteredStudents() {
                let result = this.students;

                // Search
                if (this.searchQuery) {
                    const lower = this.searchQuery.toLowerCase();
                    result = result.filter(s => s.name.toLowerCase().includes(lower) || s.nis.includes(lower));
                }
                
                return result;
            },

            get gradedCount() {
                return this.students.filter(s => s.score !== null && s.score !== '').length;
            },

            get averageScore() {
                const graded = this.students.filter(s => s.score !== null && s.score !== '');
                if (graded.length === 0) return 0;
                const total = graded.reduce((acc, curr) => acc + parseInt(curr.score), 0);
                return Math.round(total / graded.length);
            },

            get progress() {
                if (this.students.length === 0) return 0;
                return Math.round((this.gradedCount / this.students.length) * 100);
            },

            getStatus(score) {
                if (score === null || score === '') return 'Belum Dinilai';
                if (score >= 75) return 'Lulus (KKM)';
                return 'Remedial';
            },

            fillAll() {
                if (!this.fillValue) return;
                this.filteredStudents.forEach(s => {
                    if (s.score === null || s.score === '') {
                        s.score = parseInt(this.fillValue);
                    }
                });
                this.fillValue = '';
            },

            resetScores() {
                if(confirm('Apakah Anda yakin ingin mereset semua nilai?')) {
                    this.students.forEach(s => s.score = null);
                }
            },
            
            sortBy(col) {
                // Simple sort toggle
                this.students.sort((a, b) => {
                    let valA = a[col];
                    let valB = b[col];
                    
                    // Handle nulls for score sort
                    if(col === 'score') {
                        valA = valA || -1;
                        valB = valB || -1;
                    }

                    if (valA < valB) return this.sortDir === 'asc' ? -1 : 1;
                    if (valA > valB) return this.sortDir === 'asc' ? 1 : -1;
                    return 0;
                });
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            }
        }));
    });
</script>
@endpush
@endsection