@extends('layouts.admin')

@section('title', 'Manajemen Kelas & Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="{ 
    selectedStudent: null,
    showStudentModal: {{ ($errors->any() && !session('class_error')) ? 'true' : 'false' }},
    isEditStudent: {{ old('id') ? 'true' : 'false' }},
    studentForm: { 
        id: '{{ old('id') }}', 
        nama: '{{ old('nama') }}', 
        nis: '{{ old('nis') }}', 
        email: '{{ old('email') }}', 
        jenis_kelamin: '{{ old('jenis_kelamin', 'L') }}', 
        school_class_id: '{{ old('school_class_id', $selectedClassId) }}' 
    },

    showClassModal: {{ session('class_error') ? 'true' : 'false' }},
    isEditClass: {{ (session('class_error') && old('id')) ? 'true' : 'false' }},
    classForm: { id: '{{ old('id') }}', nama_kelas: '{{ old('nama_kelas') }}', tingkat: '{{ old('tingkat') }}' },

    openStudentModal(student = null) {
        if (student) {
            this.isEditStudent = true;
            this.studentForm = { ...student };
        } else {
            this.isEditStudent = false;
            this.studentForm = { id: '', nama: '', nis: '', email: '', jenis_kelamin: 'L', school_class_id: '{{ $selectedClassId }}' };
        }
        this.showStudentModal = true;
    },

    openClassModal(cls = null) {
        if (cls) {
            this.isEditClass = true;
            this.classForm = { id: cls.id, nama_kelas: cls.nama_kelas, tingkat: cls.tingkat };
        } else {
            this.isEditClass = false;
            this.classForm = { id: '', nama_kelas: '', tingkat: '' };
        }
        this.showClassModal = true;
    }
}">
    
    @if(request('subject_id'))
        <x-academic-flow-nav :active-step="3" :subject-id="request('subject_id')" :class-id="$selectedClassId" />
    @endif
    
    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Kelas & Siswa</h1>
            <p class="text-gray-500 mt-1">Kelola data akademik dan pemantauan aktivitas kelas.</p>
        </div>
        <div class="flex gap-3">
            @if(request('subject_id') && $selectedClassId)
                <a href="{{ route('guru.akademik.nilai.tugas', ['subject_id' => request('subject_id'), 'class_id' => $selectedClassId]) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center gap-2">
                    Lanjut Input Nilai <i data-lucide="arrow-right" class="w-4 h-4 text-white"></i>
                </a>
            @endif
            <button @click="openClassModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                <i data-lucide="plus-square" class="w-4 h-4 text-indigo-600"></i> Tambah Kelas
            </button>
            <button @click="openStudentModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4 text-white"></i> Tambah Siswa
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3 animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-medium">{{ session('success') }}</div>
    </div>
    @endif

    {{-- STATS SECTION --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i data-lucide="school" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Kelas</div>
                <div class="text-2xl font-bold text-gray-900">{{ $classes->count() }}</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><i data-lucide="users" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Siswa (Kelas Ini)</div>
                <div class="text-2xl font-bold text-gray-900">{{ $students->count() }}</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i data-lucide="activity" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Status Kelas</div>
                <div class="text-sm font-bold text-emerald-600 flex items-center gap-1">100% Aktif</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center"><i data-lucide="clipboard-check" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Kehadiran (Minggu Ini)</div>
                <div class="text-2xl font-bold text-gray-900">98%</div>
            </div>
        </div>
    </div>

    {{-- CLASS INFO & FILTERS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1">
             <div class="bg-indigo-600 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden group h-full">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <i data-lucide="school" class="w-40 h-40"></i>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-bold uppercase tracking-widest">Detail Kelas</span>
                            @if($selectedClassId)
                            <div class="flex gap-2">
                                <button @click="openClassModal({{ json_encode($selectedClass) }})" class="p-2 bg-white/10 hover:bg-white/30 rounded-lg transition-colors" title="Edit Kelas">
                                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('guru.akademik.kelas.destroy', $selectedClassId) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Semua siswa di dalamnya akan kehilangan kelas.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/20 hover:bg-red-500/40 rounded-lg transition-colors" title="Hapus Kelas">
                                        <i data-lucide="trash-2" class="w-4 h-4 text-red-100"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        <h2 class="text-3xl font-bold mb-1">{{ $selectedClass->nama_kelas ?? 'Pilih Kelas' }}</h2>
                        <p class="text-white/70 text-sm flex items-center gap-2">
                            <i data-lucide="user-voice" class="w-4 h-4"></i>
                            Wali Kelas: {{ optional($selectedClass)->teacher->nama ?? 'Belum Ditentukan' }}
                        </p>
                    </div>
                    @if($selectedClass)
                    <div class="mt-8 flex gap-3 text-xs">
                        <div class="px-4 py-2 bg-white/10 rounded-xl">
                            <span class="opacity-60 block">Tingkat</span>
                            <span class="font-bold">{{ $selectedClass->tingkat }}</span>
                        </div>
                        <div class="px-4 py-2 bg-white/10 rounded-xl">
                            <span class="opacity-60 block">Siswa</span>
                            <span class="font-bold">{{ $students->count() }} orang</span>
                        </div>
                    </div>
                    @endif
                </div>
             </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 h-full flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Filter & Pencarian</h3>
                    <form method="GET" action="{{ route('guru.akademik.kelas') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Pilih Kelas</label>
                                <select name="class_id" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all appearance-none cursor-pointer">
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 bottom-4"></i>
                            </div>
                            <div class="relative">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Cari Siswa</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama siswa..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-4 bottom-4"></i>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('guru.akademik.kelas') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Reset</a>
                            <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all shadow-lg active:scale-95">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- STUDENT LIST TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-[10px] w-16">No</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-[10px]">Identitas Siswa</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-[10px]">NIS</th>
                        <th class="px-6 py-4 text-center font-bold text-gray-500 uppercase tracking-widest text-[10px]">L/P</th>
                        <th class="px-6 py-4 text-center font-bold text-gray-500 uppercase tracking-widest text-[10px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $index => $s)
                    <tr class="hover:bg-indigo-50/20 transition-colors group">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-4 ring-4 ring-white shadow-sm group-hover:scale-110 transition-transform">
                                    {{ substr($s->nama, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $s->nama }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium lowercase">{{ $s->email ?? 'no-email@goedu.com' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-gray-500 text-xs">{{ $s->nis }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $s->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $s->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button @click="openStudentModal({{ json_encode($s) }})" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('guru.akademik.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini dari database?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-20 text-center text-gray-400 font-medium"><i data-lucide="user-x" class="w-10 h-10 mx-auto mb-2 opacity-20"></i> Data siswa tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL SISWA (Add/Edit) --}}
    <div x-show="showStudentModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showStudentModal = false"></div>
        <div class="bg-white rounded-3xl shadow-2xl relative w-full max-w-lg overflow-hidden" x-transition>
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <i data-lucide="user-cog" class="w-6 h-6"></i>
                    <h3 class="text-xl font-bold uppercase tracking-widest" x-text="isEditStudent ? 'Edit Biodata Siswa' : 'Tambah Siswa Baru'"></h3>
                </div>
                <button @click="showStudentModal = false" class="hover:bg-white/20 p-2 rounded-xl transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form :action="isEditStudent ? '/guru/akademik/siswa/' + studentForm.id : '{{ route('guru.akademik.siswa.store') }}'" method="POST" class="p-8 space-y-4">
                @csrf
                <template x-if="isEditStudent"><input type="hidden" name="_method" value="PUT"></template>
                <template x-if="isEditStudent"><input type="hidden" name="id" :value="studentForm.id"></template>
                
                @if($errors->any() && !session('class_error'))
                <div class="bg-red-50 text-red-700 p-4 rounded-2xl border border-red-100 text-xs shadow-sm shadow-red-50">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Pilih Kelas Tujuan</label>
                        <select name="school_class_id" x-model="studentForm.school_class_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Nama Lengkap Siswa</label>
                    <input type="text" name="nama" x-model="studentForm.nama" required placeholder="Masukkan nama lengkap..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">NIS (Nomor Induk)</label>
                        <input type="text" name="nis" x-model="studentForm.nis" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" x-model="studentForm.jenis_kelamin" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Email (Akun)</label>
                    <input type="email" name="email" x-model="studentForm.email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showStudentModal = false" class="flex-1 py-4 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                    <button type="submit" class="flex-2 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all" x-text="isEditStudent ? 'Update Data' : 'Simpan Siswa'"></button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KELAS (Add/Edit) --}}
    <div x-show="showClassModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showClassModal = false"></div>
        <div class="bg-white rounded-3xl shadow-2xl relative w-full max-w-sm overflow-hidden" x-transition>
            <div class="bg-gray-900 px-8 py-6 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <i data-lucide="layers-3" class="w-6 h-6"></i>
                    <h3 class="text-xl font-bold uppercase tracking-widest" x-text="isEditClass ? 'Edit Kelas' : 'Tambah Kelas'"></h3>
                </div>
                <button @click="showClassModal = false" class="hover:bg-white/20 p-2 rounded-xl transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form :action="isEditClass ? '/guru/akademik/kelas/' + classForm.id : '{{ route('guru.akademik.kelas.store') }}'" method="POST" class="p-8 space-y-4">
                @csrf
                <template x-if="isEditClass"><input type="hidden" name="_method" value="PUT"></template>
                <template x-if="isEditClass"><input type="hidden" name="id" :value="classForm.id"></template>

                @if(session('class_error') && $errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-2xl border border-red-100 text-xs">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Nama / Nama Kelas</label>
                    <input type="text" name="nama_kelas" x-model="classForm.nama_kelas" required placeholder="Contoh: RPL 1, IPA 2..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Tingkat (Grade)</label>
                    <select name="tingkat" x-model="classForm.tingkat" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="X">Sepuluh (X)</option>
                        <option value="XI">Sebelas (XI)</option>
                        <option value="XII">Duabelas (XII)</option>
                    </select>
                </div>

                <div class="pt-4 flex flex-col gap-3">
                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black shadow-lg shadow-gray-200 transition-all" x-text="isEditClass ? 'Simpan Perubahan' : 'Buat Kelas Baru'"></button>
                    <button type="button" @click="showClassModal = false" class="w-full py-2 text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
