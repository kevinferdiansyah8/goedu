@extends('layouts.admin')

@section('title', 'Nilai Terbaru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Nilai Terbaru</h1>
        <p class="text-gray-600">Pantau perkembangan nilai akademik siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span> secara realtime.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4 rounded-l-xl">Mata Pelajaran</th>
                        <th class="p-4 text-center">Nilai UH</th>
                        <th class="p-4 text-center">Nilai UTS</th>
                        <th class="p-4 text-center">Nilai UAS</th>
                        <th class="p-4 text-center rounded-r-xl">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($nilai as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="p-4 font-bold text-gray-800">
                            {{ $item->subject->nama_pelajaran ?? $item->subject->nama ?? 'Mata Pelajaran' }}
                        </td>
                        <td class="p-4 text-center font-semibold text-blue-600">
                            {{ $item->nilai_uh ?? '-' }}
                        </td>
                        <td class="p-4 text-center font-semibold text-purple-600">
                            {{ $item->nilai_uts ?? '-' }}
                        </td>
                        <td class="p-4 text-center font-semibold text-amber-600">
                            {{ $item->nilai_uas ?? '-' }}
                        </td>
                        <td class="p-4 text-center font-extrabold text-emerald-600 text-base">
                            {{ $item->nilai_akhir ?? $item->score ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 font-medium">Belum ada data nilai terbaru yang tercatat di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
