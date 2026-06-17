@extends('layouts.admin')

@section('title', 'Nilai Tugas & Ulangan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Nilai Tugas & Ulangan</h1>
        <p class="text-gray-600">Daftar nilai tugas harian dan ulangan siswa.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Judul / Materi</th>
                        <th class="p-4">Nilai</th>
                        <th class="p-4">Komentar Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($tugas as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-gray-800">{{ $item['mapel'] }}</td>
                        <td class="p-4">
                            @if($item['status'] == 'Belum')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium">Belum Dikerjakan</span>
                            @elseif($item['status'] == 'Terkumpul')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium">Menunggu Nilai</span>
                            @elseif($item['status'] == 'Dinilai' || $item['status'] == 'Selesai')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Selesai</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">{{ $item['status'] }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600">{{ $item['judul'] }} <br><span class="text-xs text-gray-400">Tenggat: {{ \Carbon\Carbon::parse($item['deadline'])->format('d M Y') }}</span></td>
                        <td class="p-4 font-bold {{ $item['nilai'] != '-' ? 'text-green-600' : 'text-gray-400' }}">{{ $item['nilai'] }}</td>
                        <td class="p-4 text-gray-500">{{ $item['feedback'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada tugas atau ulangan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
