@extends('layouts.admin')

@section('title', 'Penilaian')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i data-lucide="award" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Penilaian</h1>
                    <p class="text-gray-400 text-xs">Data nilai siswa dari database</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                </div>
                <span class="text-2xl font-extrabold text-gray-900">{{ $grades->count() }}</span>
            </div>
            <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Data</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                </div>
                <span class="text-2xl font-extrabold text-emerald-600">{{ $totalLulus }}</span>
            </div>
            <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Lulus</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
                </div>
                <span class="text-2xl font-extrabold text-amber-500">{{ $totalRemedial }}</span>
            </div>
            <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Remedial</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-600"></i>
                </div>
                <span class="text-2xl font-extrabold text-indigo-600">{{ $rataRata }}</span>
            </div>
            <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Rata-rata</p>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.akademik.penilaian') }}" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama siswa..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all">
            </div>
            <select name="kelas" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all min-w-[150px]">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option {{ request('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <select name="mapel" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all min-w-[180px]">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $m)
                    <option {{ request('mapel') === $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-bold text-sm shadow-lg transition-all active:scale-95">
                <i data-lucide="search" class="w-4 h-4"></i> Filter
            </button>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-500"></i>
                <span class="text-sm font-bold text-gray-700">Data Penilaian</span>
            </div>
            <span class="text-xs text-gray-400">KKM: <strong class="text-gray-600">75</strong></span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tugas</th>
                        <th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UTS</th>
                        <th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UAS</th>
                        <th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rata²</th>
                        <th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody id="nilaiTable" class="divide-y divide-gray-50">
                    @forelse($grades as $n)
                    <tr class="hover:bg-emerald-50/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $n['status'] === 'Lulus' ? 'from-emerald-400 to-teal-500' : 'from-amber-400 to-orange-500' }} flex items-center justify-center">
                                    <span class="text-white text-[10px] font-extrabold">{{ strtoupper(substr($n['nama'], 0, 2)) }}</span>
                                </div>
                                <span class="font-semibold text-gray-800">{{ $n['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold">{{ $n['kelas'] }}</span>
                        </td>
                        <td class="px-5 py-3.5"><span class="text-xs text-gray-600">{{ $n['mapel'] }}</span></td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-sm font-medium {{ $n['tugas'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['tugas'] }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-sm font-medium {{ $n['uts'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['uts'] }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-sm font-medium {{ $n['uas'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['uas'] }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-extrabold {{ $n['rata'] >= 85 ? 'bg-emerald-100 text-emerald-700' : ($n['rata'] >= 75 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600') }}">
                                {{ $n['rata'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($n['status'] === 'Lulus')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lulus
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Remedial
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                            <i data-lucide="clipboard-x" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                            <p class="font-semibold">Belum ada data penilaian</p>
                            <p class="text-xs mt-1">Data nilai siswa akan tampil setelah guru mengisi nilai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100">
            <p class="text-xs text-gray-400">Menampilkan {{ $grades->count() }} data</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
