@extends('layouts.sidebar-guru')

@section('title', 'Izin / Sakit / Alpha Siswa')

@section('content')
<div class="min-h-screen bg-gray-50/50" x-data="{ search: '', showProofModal: false, proofImage: '' }">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Izin / Sakit / Alpha Siswa</h1>
                <p class="text-sm text-gray-500 mt-1">Data kehadiran non-hadir siswa di kelas yang Anda ajar — realtime dari database.</p>
            </div>
        </div>

        {{-- Stats Cards (Realtime) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tidak Hadir</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalAll) }}</h3>
                    </div>
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</p>
                        <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalIzin }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit</p>
                        <h3 class="text-2xl font-bold text-yellow-600 mt-1">{{ $totalSakit }}</h3>
                    </div>
                    <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alpha</p>
                        <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $totalAlpha }}</h3>
                    </div>
                    <div class="p-2 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & TABLE SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Toolbar --}}
        <div class="p-5 border-b border-gray-100 bg-white">
            <form method="GET" action="{{ route('guru.absensi.izin') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                {{-- Search --}}
                <div class="relative w-full lg:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input name="search" type="text" value="{{ request('search') }}"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 sm:text-sm" 
                        placeholder="Cari nama siswa...">
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                    {{-- Class Dropdown --}}
                    <select name="kelas" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm rounded-xl bg-gray-50 hover:bg-white transition-all cursor-pointer">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $kls)
                            <option value="{{ $kls->id }}" {{ request('kelas') == $kls->id ? 'selected' : '' }}>{{ $kls->tingkat }} {{ $kls->nama_kelas }}</option>
                        @endforeach
                    </select>

                    {{-- Date Picker --}}
                    <input name="tanggal" type="date" value="{{ request('tanggal') }}" class="block w-full sm:w-auto pl-3 pr-3 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm rounded-xl bg-gray-50 hover:bg-white transition-all cursor-pointer text-gray-500">

                    <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm shadow-blue-500/30 transition-all">
                        Filter
                    </button>

                    <a href="{{ route('guru.absensi.izin') }}" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150 group">
                        {{-- Avatar + Name --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ strtoupper(substr($record->student->nama ?? '-', 0, 2)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $record->student->nama ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">NIS: {{ $record->student->nis ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Class --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-md bg-gray-100 text-gray-800 border border-gray-200">
                                {{ $record->student->schoolClass ? ($record->student->schoolClass->tingkat . ' ' . $record->student->schoolClass->nama_kelas) : '-' }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($record->tanggal)->translatedFormat('d M Y') }}
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($record->status === 'Izin')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/20">Izin</span>
                            @elseif($record->status === 'Sakit')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20">Sakit</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-50 text-red-700 ring-1 ring-red-600/20">Alpha</span>
                            @endif
                        </td>

                        {{-- Subject --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $record->schedule && $record->schedule->subject ? $record->schedule->subject->nama : '-' }}
                        </td>

                        {{-- Keterangan --}}
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-[200px] truncate">
                            {{ $record->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="mx-auto h-24 w-24 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada record izin, sakit, atau alpha untuk siswa di kelas Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info --}}
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <p class="text-sm text-gray-700">
                Menampilkan <span class="font-medium">{{ $records->count() }}</span> data
            </p>
        </div>
    </div>

</div>
@endsection
