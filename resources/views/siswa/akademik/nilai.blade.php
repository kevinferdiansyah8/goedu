@extends('layouts.admin')

@section('title', 'Nilai & Rapor')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Nilai & Rapor</h1>
        <p class="text-gray-600">Rekapitulasi nilai akademik semester ini.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg shadow-blue-200">
            <p class="text-blue-100 mb-1">Rata-rata Nilai</p>
            <h2 class="text-4xl font-bold">86.4</h2>
            <div class="mt-4 text-sm bg-white/20 inline-block px-3 py-1 rounded-lg">
                <i data-lucide="trending-up" class="w-4 h-4 inline mr-1"></i> Meningkat
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <p class="text-gray-500 mb-1">Peringkat Kelas</p>
            <h2 class="text-4xl font-bold text-gray-800">5 <span class="text-lg text-gray-400 font-normal">/ 32</span></h2>
            <p class="text-green-500 text-sm mt-2">Top 15%</p>
        </div>
         <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <p class="text-gray-500 mb-1">Total SKS/Mapel</p>
            <h2 class="text-4xl font-bold text-gray-800">{{ count($nilai) }} <span class="text-lg text-gray-400 font-normal">Mapel</span></h2>
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
                    @foreach($nilai as $row)
                    <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $row['mapel'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uh'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uts'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $row['uas'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $row['akhir'] }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($row['akhir'] >= 90) <span class="text-green-600 font-bold">A</span>
                            @elseif($row['akhir'] >= 80) <span class="text-blue-600 font-bold">B</span>
                            @elseif($row['akhir'] >= 75) <span class="text-yellow-600 font-bold">C</span>
                            @else <span class="text-red-600 font-bold">D</span>
                            @endif
                        </td>
                         <td class="px-6 py-4 text-center">
                            @if($row['akhir'] >= 75)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lulus</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Remedial</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
