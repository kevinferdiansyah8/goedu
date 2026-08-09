@extends('layouts.admin')

@section('title', 'Rapor Siswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rapor Siswa</h1>
        <p class="text-gray-600">Laporan hasil belajar siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span> per semester.</p>
    </div>

    <!-- Semester Selector -->
    @php
        $currY = date('Y');
        $nextY = $currY + 1;
        $prevY1 = $currY - 1;
        $prevY2 = $currY - 2;
        $selectedSemester = request('semester', "Semester Ganjil {$currY}/{$nextY}");
    @endphp
    <form method="GET" action="{{ route('orangtua.akademik.rapor') }}" class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center gap-4">
        <label for="semester-rapor" class="text-sm font-bold text-gray-700 whitespace-nowrap">Pilih Semester & Tahun Ajaran:</label>
        <select name="semester" id="semester-rapor" onchange="this.form.submit()" class="w-full md:w-1/2 border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-2.5 border bg-gray-50/50 font-semibold text-gray-800">
            <option value="Semester Ganjil {{ $currY }}/{{ $nextY }}" {{ $selectedSemester == "Semester Ganjil {$currY}/{$nextY}" ? 'selected' : '' }}>Semester Ganjil {{ $currY }}/{{ $nextY }}</option>
            <option value="Semester Genap {{ $prevY1 }}/{{ $currY }}" {{ $selectedSemester == "Semester Genap {$prevY1}/{$currY}" ? 'selected' : '' }}>Semester Genap {{ $prevY1 }}/{{ $currY }}</option>
            <option value="Semester Ganjil {{ $prevY1 }}/{{ $currY }}" {{ $selectedSemester == "Semester Ganjil {$prevY1}/{$currY}" ? 'selected' : '' }}>Semester Ganjil {{ $prevY1 }}/{{ $currY }}</option>
            <option value="Semester Genap {{ $prevY2 }}/{{ $prevY1 }}" {{ $selectedSemester == "Semester Genap {$prevY2}/{$prevY1}" ? 'selected' : '' }}>Semester Genap {{ $prevY2 }}/{{ $prevY1 }}</option>
            <option value="Semester Ganjil {{ $prevY2 }}/{{ $prevY1 }}" {{ $selectedSemester == "Semester Ganjil {$prevY2}/{$prevY1}" ? 'selected' : '' }}>Semester Ganjil {{ $prevY2 }}/{{ $prevY1 }}</option>
        </select>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 text-center border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-extrabold text-gray-800 tracking-wide">LAPORAN HASIL BELAJAR (RAPOR)</h2>
            <p class="text-primary font-bold text-sm mt-1">{{ $selectedSemester }}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4 text-center">KKM</th>
                        <th class="p-4 text-center">Nilai Akhir</th>
                        <th class="p-4 text-center">Predikat</th>
                        <th class="p-4">Keterangan Capaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($rapor as $idx => $r)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 text-center font-bold text-gray-500">{{ $idx + 1 }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $r->subject->nama_pelajaran ?? $r->subject->nama ?? '-' }}</td>
                        <td class="p-4 text-center font-semibold text-gray-600">75</td>
                        <td class="p-4 text-center font-extrabold text-blue-600 text-base">{{ $r->nilai_akhir ?? $r->score ?? '-' }}</td>
                        <td class="p-4 text-center font-bold">
                            @php $final = $r->nilai_akhir ?? $r->score ?? 0; @endphp
                            @if($final >= 90)
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs">A</span>
                            @elseif($final >= 80)
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs">B</span>
                            @elseif($final >= 75)
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs">C</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs">D</span>
                            @endif
                        </td>
                        <td class="p-4 font-medium text-gray-600">
                            @if($final >= 90)
                                Sangat Baik (Menunjukkan penguasaan kompetensi sangat tinggi)
                            @elseif($final >= 80)
                                Baik (Menunjukkan penguasaan kompetensi dengan baik)
                            @elseif($final >= 75)
                                Cukup (Telah memenuhi batas KKM standar)
                            @else
                                Perlu Bimbingan & Peningkatan
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500 font-medium">Belum ada data nilai rapor untuk semester ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5 bg-gray-50/80 border-t border-gray-100 flex justify-end">
            <button onclick="window.print()" class="bg-primary hover:bg-primary-hover text-white font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition-all shadow-md shadow-blue-200 text-sm cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i> Cetak / Download Rapor (PDF)
            </button>
        </div>
    </div>
</div>
@endsection
