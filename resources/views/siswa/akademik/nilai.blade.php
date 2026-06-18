@extends('layouts.sidebar-siswa')

@section('title', 'Nilai & Rapor')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Nilai & Rapor</h1>
        <p class="text-gray-600">Rekapitulasi nilai akademik semester ini.</p>
    </div>

    <!-- Summary Cards (Dynamic from DB) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg shadow-blue-200">
            <p class="text-blue-100 mb-1">Rata-rata Nilai</p>
            <h2 class="text-4xl font-bold">{{ $rataRata > 0 ? $rataRata : '-' }}</h2>
            <div class="mt-4 text-sm bg-white/20 inline-block px-3 py-1 rounded-lg">
                @if($trend == 'Meningkat')
                    <i data-lucide="trending-up" class="w-4 h-4 inline mr-1"></i>
                @elseif($trend == 'Perlu Ditingkatkan')
                    <i data-lucide="trending-down" class="w-4 h-4 inline mr-1"></i>
                @else
                    <i data-lucide="minus" class="w-4 h-4 inline mr-1"></i>
                @endif
                {{ $trend }}
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <p class="text-gray-500 mb-1">Peringkat Kelas</p>
            <h2 class="text-4xl font-bold text-gray-800">{{ $peringkat }} <span class="text-lg text-gray-400 font-normal">/ {{ $totalSiswaKelas }}</span></h2>
            @if(is_numeric($peringkat) && $totalSiswaKelas > 0)
                @php $percentile = round(($peringkat / $totalSiswaKelas) * 100); @endphp
                <p class="{{ $percentile <= 25 ? 'text-green-500' : ($percentile <= 50 ? 'text-blue-500' : 'text-yellow-500') }} text-sm mt-2">
                    Top {{ $percentile }}%
                </p>
            @else
                <p class="text-gray-400 text-sm mt-2">Belum ada data</p>
            @endif
        </div>
         <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <p class="text-gray-500 mb-1">Total SKS/Mapel</p>
            <h2 class="text-4xl font-bold text-gray-800">{{ $totalMapel }} <span class="text-lg text-gray-400 font-normal">Mapel</span></h2>
            <p class="text-blue-500 text-sm mt-2">Aktif</p>
        </div>
    </div>

    <!-- Table Nilai -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-800">Transkrip Nilai Sementara</h3>
            <button class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i> Cetak Rapor
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                        <th class="px-6 py-4 font-semibold text-center">UH</th>
                        <th class="px-6 py-4 font-semibold text-center">UTS</th>
                        <th class="px-6 py-4 font-semibold text-center">UAS</th>
                        <th class="px-6 py-4 font-semibold text-center">Nilai Akhir</th>
                        <th class="px-6 py-4 font-semibold text-center">Grade</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($nilai as $row)
                    <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $row['mapel'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uh'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uts'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uas'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $row['akhir'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($row['akhir'] !== null)
                                @if($row['akhir'] >= 90) <span class="text-green-600 font-bold">A</span>
                                @elseif($row['akhir'] >= 80) <span class="text-blue-600 font-bold">B</span>
                                @elseif($row['akhir'] >= 75) <span class="text-yellow-600 font-bold">C</span>
                                @else <span class="text-red-600 font-bold">D</span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                         <td class="px-6 py-4 text-center">
                            @if($row['akhir'] !== null)
                                @if($row['akhir'] >= 75)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lulus</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Remedial</span>
                                @endif
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-semibold">Belum Dinilai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i data-lucide="file-x" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                            <p class="font-medium">Belum ada data nilai.</p>
                            <p class="text-xs mt-1">Nilai akan muncul setelah guru menginput nilai UH/UTS/UAS.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
