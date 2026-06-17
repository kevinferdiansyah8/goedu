@extends('layouts.admin')

@section('title', 'Absensi Guru')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-white to-blue-100 py-10 px-2 md:px-0">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Absensi Guru</h1>
                <p class="text-base text-gray-500">Monitoring kehadiran guru (admin)</p>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('admin.absensi.guru') }}" class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                   class="border border-blue-200 rounded-lg px-4 py-2 w-full md:w-56 focus:ring-2 focus:ring-blue-200">
            <select name="status" id="filterStatus" class="border border-blue-200 rounded-lg px-4 py-2 w-full md:w-56">
                <option value="">Semua Status</option>
                <option value="Hadir"  {{ $filterStatus === 'Hadir'  ? 'selected' : '' }}>Hadir</option>
                <option value="Izin"   {{ $filterStatus === 'Izin'   ? 'selected' : '' }}>Izin</option>
                <option value="Sakit"  {{ $filterStatus === 'Sakit'  ? 'selected' : '' }}>Sakit</option>
            </select>
            <button type="submit" class="bg-blue-700 text-white font-bold px-6 py-2 rounded-xl shadow hover:bg-blue-800 transition">
                <i class="fa fa-search mr-1"></i> Tampilkan
            </button>
        </form>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="flex flex-col items-center bg-white/80 border-2 border-gray-200 rounded-2xl shadow p-6">
                <span class="text-gray-300 text-2xl"><i class="fa fa-users"></i></span>
                <span class="text-3xl font-extrabold text-gray-800 mb-1">{{ $absensiGuru->count() }}</span>
                <span class="font-semibold text-gray-500 text-lg">Total Guru</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-green-200 rounded-2xl shadow p-6">
                <span class="text-green-300 text-2xl"><i class="fa fa-user-check"></i></span>
                <span class="text-3xl font-extrabold text-green-700 mb-1">{{ $totalHadir }}</span>
                <span class="font-semibold text-green-700 text-lg">Hadir</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-yellow-200 rounded-2xl shadow p-6">
                <span class="text-yellow-300 text-2xl"><i class="fa fa-user-clock"></i></span>
                <span class="text-3xl font-extrabold text-yellow-700 mb-1">{{ $totalIzin }}</span>
                <span class="font-semibold text-yellow-700 text-lg">Izin</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-red-200 rounded-2xl shadow p-6">
                <span class="text-red-300 text-2xl"><i class="fa fa-user-times"></i></span>
                <span class="text-3xl font-extrabold text-red-700 mb-1">{{ $totalSakit }}</span>
                <span class="font-semibold text-red-700 text-lg">Sakit</span>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
            <table class="min-w-full text-base mb-8">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-slate-100 text-blue-900">
                        <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Guru</th>
                        <th class="px-5 py-3 text-left font-bold">NIP</th>
                        <th class="px-5 py-3 text-center font-bold">Tanggal</th>
                        <th class="px-5 py-3 text-center font-bold">Jam</th>
                        <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Status</th>
                    </tr>
                </thead>
                <tbody id="tableAbsensi">
                    @forelse($absensiGuru as $a)
                    @if(!$filterStatus || $a['status'] === $filterStatus)
                    <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition rounded-xl" data-status="{{ $a['status'] }}">
                        <td class="px-5 py-3 flex items-center gap-3">
                            <span class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow text-sm">
                                {{ collect(explode(' ', $a['nama']))->map(fn($n)=>$n[0])->join('') }}
                            </span>
                            <span class="font-medium text-gray-800">{{ $a['nama'] }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $a['nip'] }}</td>
                        <td class="px-5 py-3 text-center text-gray-700">{{ $a['tanggal'] }}</td>
                        <td class="px-5 py-3 text-center text-gray-700">{{ $a['jam'] }}</td>
                        <td class="px-5 py-3 text-center">
                            @if($a['status'] === 'Hadir')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-check-circle'></i> Hadir</span>
                            @elseif($a['status'] === 'Izin')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-clock'></i> Izin</span>
                            @elseif($a['status'] === 'Sakit')
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-times-circle'></i> Sakit</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-info-circle'></i> {{ $a['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            <i class="fa fa-chalkboard-teacher text-3xl mb-2"></i>
                            <p>Belum ada data guru terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
