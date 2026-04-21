@extends('layouts.admin')

@section('title', 'Input Nilai Tugas')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="inputNilaiPage()">
    
    @if(request('subject_id'))
        <x-academic-flow-nav :active-step="4" :subject-id="request('subject_id')" :class-id="$selectedClassId" />
    @endif

    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Input Nilai Tugas / Ulangan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola penilaian siswa dengan sistem validasi otomatis.</p>
        </div>
        @if(request('subject_id') && $selectedClassId)
            <a href="{{ route('guru.akademik.nilai.rapor', ['subject_id' => request('subject_id'), 'class_id' => $selectedClassId]) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center gap-2">
                Lanjut ke Rapor <i data-lucide="arrow-right" class="w-4 h-4 text-white"></i>
            </a>
        @endif
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-medium">{{ session('success') }}</div>
    </div>
    @endif

    {{-- ANALYTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-gray-900" x-text="students.length"></h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2"><div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div></div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sudah Dinilai</p>
                    <h3 class="text-2xl font-bold text-green-600" x-text="gradedCount"></h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2"><div class="bg-green-500 h-1.5 rounded-full" :style="`width: ${progress}%`"></div></div>
        </div>

         <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-Rata</p>
                    <h3 class="text-2xl font-bold text-indigo-600" x-text="averageScore"></h3>
                </div>
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2 text-center font-bold">KKM: 75</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Progress</p>
                    <h3 class="text-2xl font-bold text-gray-900" x-text="progress + '%'"></h3>
                </div>
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                    <i data-lucide="loader-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2"><div class="bg-orange-500 h-1.5 rounded-full" :style="`width: ${progress}%`"></div></div>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <form id="filterForm" method="GET" action="{{ route('guru.akademik.nilai.tugas') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-center">
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                {{-- Kelas --}}
                <select name="class_id" onchange="this.form.submit()" class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                    @endforeach
                </select>
                {{-- Mapel --}}
                <select name="subject_id" onchange="this.form.submit()" class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}" {{ $selectedSubjectId == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                    @endforeach
                </select>
                {{-- Tipe Nilai --}}
                <select name="type" onchange="this.form.submit()" class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-bold">
                    <optgroup label="Periodic / Raport">
                        <option value="nilai_uh" {{ $selectedType == 'nilai_uh' ? 'selected' : '' }}>Tugas / Ulangan Harian</option>
                        <option value="nilai_uts" {{ $selectedType == 'nilai_uts' ? 'selected' : '' }}>UTS (Tengah Semester)</option>
                        <option value="nilai_uas" {{ $selectedType == 'nilai_uas' ? 'selected' : '' }}>UAS (Akhir Semester)</option>
                    </optgroup>
                    @if(count($assignments) > 0)
                        <optgroup label="Tugas Spesifik">
                            @foreach($assignments as $asg)
                                <option value="assignment_{{ $asg->id }}" {{ $selectedType == 'assignment_' . $asg->id ? 'selected' : '' }}>
                                    {{ $asg->judul }} ({{ \Carbon\Carbon::parse($asg->created_at)->format('d/m') }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>

            <div class="flex flex-wrap gap-3 w-full lg:w-auto items-center justify-end">
                 <div class="relative w-full lg:w-48">
                    <input type="text" x-model="searchQuery" placeholder="Cari Siswa..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5"></i>
                </div>
                <div class="flex rounded-xl shadow-sm">
                    <input type="number" x-model="fillValue" placeholder="Isi massal..." class="w-24 px-3 py-2 text-sm border border-gray-200 rounded-l-xl">
                    <button type="button" @click="fillAll()" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-200 rounded-r-xl transition-colors">Isi Semua</button>
                </div>
            </div>
        </div>
    </form>

    {{-- MAIN FORM --}}
    <form method="POST" action="{{ route('guru.akademik.nilai.tugas.store') }}">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
        <input type="hidden" name="type" value="{{ $selectedType }}">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-20">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left w-16 uppercase text-[10px] font-bold">No</th>
                            <th class="px-6 py-4 text-left uppercase text-[10px] font-bold">Nama Siswa</th>
                            <th class="px-6 py-4 text-left uppercase text-[10px] font-bold w-32">NIS</th>
                            <th class="px-6 py-4 text-left uppercase text-[10px] font-bold w-48">Nilai</th>
                            <th class="px-6 py-4 text-center uppercase text-[10px] font-bold w-40">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $index => $student)
                            <tr class="hover:bg-blue-50/30 transition-colors" x-show="isMatch('{{ $student['name'] }}', '{{ $student['nis'] }}')">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[10px]">{{ substr($student['name'], 0, 2) }}</div>
                                        <div class="font-semibold text-gray-900">{{ $student['name'] }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-mono">{{ $student['nis'] }}</td>
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           name="grades[{{ $student['id'] }}]" 
                                           @php $s_id = (string)$student['id']; @endphp
                                           x-model.number="getStudentById({{ $student['id'] }}).score" 
                                           min="0" max="100" 
                                           class="w-full px-4 py-2 border rounded-xl font-bold text-center transition-all focus:ring-2" 
                                           :class="getStudentById({{ $student['id'] }}).score >= 75 ? 'border-green-300 text-green-700 bg-green-50 focus:ring-green-100' : (getStudentById({{ $student['id'] }}).score !== null && getStudentById({{ $student['id'] }}).score !== '' ? 'border-red-300 text-red-700 bg-red-50 focus:ring-red-100' : 'border-gray-200 focus:ring-blue-100')">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold inline-flex items-center gap-1" 
                                          :class="getStudentById({{ $student['id'] }}).score >= 75 ? 'bg-green-100 text-green-700' : (getStudentById({{ $student['id'] }}).score !== null && getStudentById({{ $student['id'] }}).score !== '' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500')">
                                        <span x-text="getStudentById({{ $student['id'] }}).score >= 75 ? 'LULUS' : (getStudentById({{ $student['id'] }}).score !== null && getStudentById({{ $student['id'] }}).score !== '' ? 'REMEDIAL' : '-')"></span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FLOATING ACTION BUTTON --}}
        <div class="fixed bottom-6 right-6 z-40">
            <button type="submit" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white font-bold rounded-full shadow-2xl hover:bg-indigo-700 hover:scale-105 transition-all shadow-indigo-200 flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inputNilaiPage', () => ({
            searchQuery: '',
            fillValue: '',
            students: @json($students),
            
            students: @json($students),
            
            getStudentById(id) {
                return this.students.find(s => s.id == id) || { score: null };
            },

            isMatch(name, nis) {
                if (!this.searchQuery) return true;
                const lower = this.searchQuery.toLowerCase();
                return (name || '').toLowerCase().includes(lower) || (nis || '').includes(lower);
            },

            get gradedCount() {
                return this.students.filter(s => s.score !== null && s.score !== '').length;
            },

            get averageScore() {
                const graded = this.students.filter(s => s.score !== null && s.score !== '');
                if (graded.length === 0) return 0;
                const total = graded.reduce((acc, curr) => acc + (parseInt(curr.score) || 0), 0);
                return Math.round(total / graded.length);
            },

            get progress() {
                if (this.students.length === 0) return 0;
                return Math.round((this.gradedCount / this.students.length) * 100);
            },

            fillAll() {
                if (!this.fillValue) return;
                const lower = this.searchQuery.toLowerCase();
                this.students.forEach(s => {
                    if (!this.searchQuery || s.name.toLowerCase().includes(lower) || s.nis.includes(lower)) {
                        s.score = parseInt(this.fillValue);
                    }
                });
                this.fillValue = '';
            }
        }));
    });
</script>
@endpush
@endsection