@extends('layouts.sidebar-siswa')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
        <p class="text-gray-600">Catatan kehadiran harian siswa.</p>
    </div>

    <!-- Filter (Realtime Form) -->
    <form method="GET" action="{{ route('siswa.kehadiran.riwayat') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-4 items-center">
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-700">Bulan:</span>
            <select name="bulan" class="border border-gray-300 rounded-md text-sm px-3 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                <option value="all" {{ ($selectedBulan ?? 'all') == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                @foreach(($dropdownOptions ?? []) as $val => $label)
                    <option value="{{ $val }}" {{ ($selectedBulan ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">Tampilkan</button>
    </form>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Pulang</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $log)
                    <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(!empty($log->jam_masuk))
                                {{ substr($log->jam_masuk, 0, 5) }}
                            @elseif(in_array($log->status, ['Hadir', 'Terlambat']) && $log->created_at)
                                {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(!empty($log->jam_pulang))
                                {{ substr($log->jam_pulang, 0, 5) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($log->status == 'Hadir')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Hadir</span>
                            @elseif($log->status == 'Izin')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Izin</span>
                            @elseif($log->status == 'Sakit')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Sakit</span>
                            @elseif($log->status == 'Terlambat')
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Terlambat</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">{{ $log->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $log->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Belum ada catatan absensi untuk periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

