@extends('layouts.admin')

@section('title', 'Status Penilaian')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Status Penilaian</h1>
        <p class="text-gray-600">Riwayat tugas yang dikumpulkan dan hasil penilaiannya.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
         <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Judul Tugas</th>
                        <th class="px-6 py-4">Tanggal Kumpul</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Nilai</th>
                        <th class="px-6 py-4">Feedback Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($nilai_tugas as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item['mapel'] }}</td>
                        <td class="px-6 py-4">{{ $item['judul'] }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item['tanggal_kumpul'])->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item['status'] == 'Dinilai')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-600">
                                    {{ $item['status'] }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">
                                    {{ $item['status'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-lg {{ $item['nilai'] >= 75 ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $item['nilai'] ?? '-' }}
                        </td>
                        <td class="px-6 py-4 italic text-gray-500">
                            "{{ $item['feedback'] ?? 'Belum ada feedback.' }}"
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
