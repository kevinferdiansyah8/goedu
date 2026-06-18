@extends('layouts.sidebar-siswa')

@section('title', 'Status Penilaian')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Status Penilaian</h1>
        <p class="text-gray-600">Riwayat tugas yang dikumpulkan, ulangan, dan hasil penilaiannya.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
         <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Nilai</th>
                        <th class="px-6 py-4">Feedback Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($semua_nilai as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($item['tipe'] == 'Tugas')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">{{ $item['tipe'] }}</span>
                            @elseif($item['tipe'] == 'Ulangan Harian')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-600">UH</span>
                            @elseif($item['tipe'] == 'UTS')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-600">UTS</span>
                            @elseif($item['tipe'] == 'UAS')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">UAS</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item['mapel'] }}</td>
                        <td class="px-6 py-4">{{ $item['judul'] }}</td>
                        <td class="px-6 py-4">
                            @if($item['tanggal_kumpul'])
                                {{ \Carbon\Carbon::parse($item['tanggal_kumpul'])->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item['status'] == 'Dinilai')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-600">
                                    {{ $item['status'] }}
                                </span>
                            @elseif($item['status'] == 'Terkumpul')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">
                                    {{ $item['status'] }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">
                                    {{ $item['status'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-lg {{ ($item['nilai'] ?? 0) >= 75 ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $item['nilai'] ?? '-' }}
                        </td>
                        <td class="px-6 py-4 italic text-gray-500">
                            "{{ $item['feedback'] ?? 'Belum ada feedback.' }}"
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i data-lucide="file-x" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                            <p class="font-medium">Belum ada data penilaian.</p>
                            <p class="text-xs mt-1">Data akan muncul setelah guru menginput nilai atau menilai tugas Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
