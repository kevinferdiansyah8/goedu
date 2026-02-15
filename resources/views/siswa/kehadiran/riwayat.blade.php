@extends('layouts.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
        <p class="text-gray-600">Catatan kehadiran harian siswa.</p>
    </div>

    <!-- Filter (Dummy) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-4 items-center">
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-700">Bulan:</span>
            <select class="border border-gray-300 rounded-md text-sm px-3 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                <option>Oktober 2023</option>
                <option>September 2023</option>
            </select>
        </div>
        <button class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">Tampilkan</button>
    </div>

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
                    @foreach($riwayat as $log)
                    <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($log['tanggal'])->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">{{ $log['jam_masuk'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $log['jam_pulang'] }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($log['status'] == 'Hadir')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Hadir</span>
                            @elseif($log['status'] == 'Izin')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Izin</span>
                            @elseif($log['status'] == 'Sakit')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Sakit</span>
                            @elseif($log['status'] == 'Terlambat')
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Terlambat</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Alpha</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $log['keterangan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
