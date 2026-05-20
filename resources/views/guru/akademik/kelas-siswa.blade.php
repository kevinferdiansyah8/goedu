@extends('layouts.admin')

@section('title', 'Manajemen Kelas & Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20">
    
    @if(request('subject_id'))
        <x-academic-flow-nav :active-step="3" :subject-id="request('subject_id')" :class-id="$selectedClassId" />
    @endif
    
    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Kelas & Siswa</h1>
            <p class="text-gray-500 mt-1">Lihat daftar siswa dari kelas yang Anda ajar.</p>
        </div>
        <div class="flex gap-3">
            @if(request('subject_id') && $selectedClassId)
                <a href="{{ route('guru.akademik.nilai.tugas', ['subject_id' => request('subject_id'), 'class_id' => $selectedClassId]) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center gap-2">
                    Lanjut Input Nilai <i data-lucide="arrow-right" class="w-4 h-4 text-white"></i>
                </a>
            @endif
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
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Kelas Diajar</div>
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
                <div class="text-2xl font-bold text-gray-900">-</div>
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
                                    @forelse($classes as $c)
                                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                                    @empty
                                        <option value="">Belum ada jadwal kelas</option>
                                    @endforelse
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
                        <th class="px-6 py-4 text-center font-bold text-gray-500 uppercase tracking-widest text-[10px]">Catatan Khusus</th>
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
                        <td class="px-6 py-4">
                            <form action="{{ route('guru.akademik.siswa.update-catatan', $s->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="catatan_guru" value="{{ $s->catatan_guru }}" placeholder="Tambah catatan..." class="w-full text-xs border border-gray-200 rounded-lg px-2 py-1 focus:ring-1 focus:ring-indigo-400 outline-none">
                                <button type="submit" class="bg-indigo-50 text-indigo-600 p-1 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-20 text-center text-gray-400 font-medium"><i data-lucide="user-x" class="w-10 h-10 mx-auto mb-2 opacity-20"></i> Data siswa tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
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
