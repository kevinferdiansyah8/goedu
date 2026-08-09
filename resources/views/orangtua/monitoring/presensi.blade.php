@extends('layouts.admin')

@section('title', 'Ringkasan Kehadiran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ringkasan Kehadiran</h1>
            <p class="text-gray-600">Laporan kehadiran siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span> semester ini secara realtime.</p>
        </div>
        <a href="{{ route('orangtua.absensi.rekap') }}" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all flex items-center gap-2 self-start">
            <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Lihat Rekap Bulanan
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Persentase Hadir</div>
                <div class="text-2xl font-extrabold text-green-600">{{ $kehadiran['hadir'] }}%</div>
                <div class="text-xs text-gray-400 mt-1">{{ $kehadiran['count_hadir'] }} hari dari {{ $kehadiran['total'] }} hari</div>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sakit</div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $kehadiran['sakit'] }} Hari</div>
                <div class="text-xs text-gray-400 mt-1">Total izin sakit</div>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <i data-lucide="stethoscope" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Izin</div>
                <div class="text-2xl font-extrabold text-amber-600">{{ $kehadiran['izin'] }} Hari</div>
                <div class="text-xs text-gray-400 mt-1">Total izin acara</div>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alpha</div>
                <div class="text-2xl font-extrabold text-rose-600">{{ $kehadiran['alpha'] }} Hari</div>
                <div class="text-xs text-gray-400 mt-1">Tanpa keterangan</div>
            </div>
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                <i data-lucide="alert-circle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 text-base">Riwayat Kehadiran Realtime</h3>
            <a href="{{ route('orangtua.absensi.riwayat') }}" class="text-xs font-semibold text-primary hover:underline">Lihat Semua History &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 text-gray-800 font-medium">
                            {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="p-4">
                            @if($r->status === 'Hadir')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Hadir</span>
                            @elseif($r->status === 'Sakit')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Sakit</span>
                            @elseif($r->status === 'Izin')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Izin</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold">Alpha</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600">{{ $r->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500 font-medium">Belum ada riwayat absensi tercatat di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
