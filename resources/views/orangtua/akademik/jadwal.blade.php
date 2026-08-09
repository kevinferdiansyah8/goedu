@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
        <p class="text-gray-600">Jadwal kegiatan belajar mengajar siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span> (Kelas {{ $student->kelas ?? '10' }}).</p>
    </div>

    <!-- Day Tabs -->
    <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
            <a href="{{ route('orangtua.akademik.jadwal', ['hari' => $h]) }}" 
               class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all whitespace-nowrap {{ strtolower($selectedHari) === strtolower($h) ? 'bg-primary text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                {{ $h }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-primary"></i> Jadwal Hari {{ ucfirst($selectedHari) }}
            </h3>
            <span class="text-xs text-gray-400 font-medium">{{ count($jadwalHariIni) }} Mata Pelajaran</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="p-4 w-36">Jam Pelajaran</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru Pengampu</th>
                        <th class="p-4">Ruang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($jadwalHariIni as $j)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="p-4 text-gray-600 font-mono font-semibold">
                            {{ $j->jam_mulai ?? $j->jam }} @if($j->jam_selesai) - {{ $j->jam_selesai }} @endif
                        </td>
                        <td class="p-4 font-bold text-gray-800">
                            {{ $j->subject->nama_pelajaran ?? $j->subject->nama ?? $j->mata_pelajaran ?? '-' }}
                        </td>
                        <td class="p-4 text-gray-600">
                            {{ $j->subject->teacher->name ?? $j->guru ?? '-' }}
                        </td>
                        <td class="p-4 text-gray-600 font-medium">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs">
                                {{ $j->ruang ?? $j->kelas ?? 'Ruang Kelas' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500 font-medium">
                            Tidak ada jadwal pelajaran untuk hari {{ ucfirst($selectedHari) }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
