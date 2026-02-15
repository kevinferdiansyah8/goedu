@extends('layouts.admin')

@section('title', 'Rekap Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rekapitulasi Absensi</h1>
        <p class="text-gray-600">Ringkasan kehadiran siswa per bulan.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold">Bulan</th>
                        <th class="px-6 py-4 font-semibold text-center text-green-600">Hadir</th>
                        <th class="px-6 py-4 font-semibold text-center text-yellow-600">Sakit</th>
                        <th class="px-6 py-4 font-semibold text-center text-blue-600">Izin</th>
                        <th class="px-6 py-4 font-semibold text-center text-red-600">Alpha</th>
                        <th class="px-6 py-4 font-semibold text-center text-orange-600">Terlambat</th>
                        <th class="px-6 py-4 font-semibold text-center">Persentase Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rekap as $row)
                    @php
                        $total_hari = $row['hadir'] + $row['sakit'] + $row['izin'] + $row['alpha'];
                        $persentase = $total_hari > 0 ? round(($row['hadir'] / $total_hari) * 100, 1) : 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $row['bulan'] }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $row['hadir'] }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $row['sakit'] }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $row['izin'] }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $row['alpha'] }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $row['terlambat'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="font-bold {{ $persentase >= 90 ? 'text-green-600' : ($persentase >= 75 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $persentase }}%
                                </span>
                                <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full {{ $persentase >= 90 ? 'bg-green-500' : ($persentase >= 75 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
