@extends('layouts.admin')

@section('title', 'Absensi Siswa')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-white to-blue-100 py-10 px-2 md:px-0">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1 tracking-tight">Absensi Siswa</h1>
                <p class="text-base text-gray-500">Kelola kehadiran siswa harian.</p>
            </div>
        </div>

        <!-- Filter Card -->
        <form method="GET" action="{{ route('admin.absensi.siswa') }}">
            <div class="bg-white/90 shadow-xl rounded-2xl p-6 mb-8 border border-blue-100 flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-gray-700 font-semibold mb-1" for="kelasSelect">Kelas</label>
                    <select id="kelasSelect" name="kelas_id" class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-gray-700 font-semibold mb-1" for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}"
                           class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="flex items-end w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:scale-105 hover:bg-blue-800 transition-all duration-200">
                        <i class="fa fa-search mr-2"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>

        <!-- Statistik -->
        @php
            $statHadir = collect($siswaList)->filter(fn($s) => isset($attendanceMap[$s->id]) && $attendanceMap[$s->id]->status === 'Hadir')->count();
            $statIzin  = collect($siswaList)->filter(fn($s) => isset($attendanceMap[$s->id]) && $attendanceMap[$s->id]->status === 'Izin')->count();
            $statSakit = collect($siswaList)->filter(fn($s) => isset($attendanceMap[$s->id]) && $attendanceMap[$s->id]->status === 'Sakit')->count();
            $statAlpha = $siswaList->count() - $statHadir - $statIzin - $statSakit;
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
            <div class="flex flex-col items-center bg-white/80 border-2 border-green-200 rounded-2xl shadow p-6">
                <span class="text-green-400 text-2xl"><i class="fa fa-user-check"></i></span>
                <span class="text-3xl font-extrabold text-green-700 mb-1">{{ $statHadir }}</span>
                <span class="font-semibold text-green-700 text-lg">Hadir</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-yellow-200 rounded-2xl shadow p-6">
                <span class="text-yellow-400 text-2xl"><i class="fa fa-user-clock"></i></span>
                <span class="text-3xl font-extrabold text-yellow-700 mb-1">{{ $statIzin }}</span>
                <span class="font-semibold text-yellow-700 text-lg">Izin</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-blue-200 rounded-2xl shadow p-6">
                <span class="text-blue-400 text-2xl"><i class="fa fa-user-md"></i></span>
                <span class="text-3xl font-extrabold text-blue-700 mb-1">{{ $statSakit }}</span>
                <span class="font-semibold text-blue-700 text-lg">Sakit</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-red-200 rounded-2xl shadow p-6">
                <span class="text-red-400 text-2xl"><i class="fa fa-user-times"></i></span>
                <span class="text-3xl font-extrabold text-red-700 mb-1">{{ $statAlpha }}</span>
                <span class="font-semibold text-red-700 text-lg">Alpha</span>
            </div>
        </div>

        <!-- Tabel Absensi -->
        <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto p-0 md:p-8">
            @if($siswaList->count() > 0)
                <table class="min-w-full text-base mb-8">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-slate-100 text-blue-900">
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">NIS</th>
                            <th class="px-5 py-3 text-left font-bold">Nama Siswa</th>
                            <th class="px-5 py-3 text-left font-bold">Kelas</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Status Hari Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswaList as $siswa)
                        @php
                            $att    = $attendanceMap[$siswa->id] ?? null;
                            $status = $att ? $att->status : 'Alpha';
                        @endphp
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-5 py-3 font-semibold text-blue-900">{{ $siswa->nis ?? '-' }}</td>
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shadow">
                                    {{ strtoupper(substr(preg_replace('/[^A-Za-z\s]/', '', $siswa->nama), 0, 2)) }}
                                </span>
                                <span>{{ $siswa->nama }}</span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $siswa->schoolClass ? ($siswa->schoolClass->tingkat . ' ' . $siswa->schoolClass->nama_kelas) : '-' }}</td>
                            <td class="px-5 py-3 text-center">
                                @if($status === 'Hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">✅ Hadir</span>
                                @elseif($status === 'Izin')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">🟡 Izin</span>
                                @elseif($status === 'Sakit')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">🔵 Sakit</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">❌ Alpha</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16 text-gray-400">
                    <i class="fa fa-users text-4xl mb-3"></i>
                    <p class="font-semibold">Tidak ada data siswa untuk tanggal <strong>{{ $tanggal }}</strong></p>
                    <p class="text-sm mt-1">Pilih kelas dan tanggal lalu klik Tampilkan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
