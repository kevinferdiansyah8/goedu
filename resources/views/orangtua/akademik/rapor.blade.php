@extends('layouts.admin')

@section('title', 'Rapor Siswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rapor Siswa</h1>
        <p class="text-gray-600">Hasil belajar siswa per semester.</p>
    </div>

    <!-- Semester Selector -->
     <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <label for="semester-rapor" class="block text-sm font-medium text-gray-700 mb-2">Pilih Semester</label>
        <select id="semester-rapor" class="w-full md:w-1/3 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
            <option>Semester Ganjil 2023/2024</option>
            <option>Semester Genap 2022/2023</option>
             <option>Semester Ganjil 2022/2023</option>
        </select>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 text-center border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">LAPORAN HASIL BELAJAR (RAPOR)</h2>
            <p class="text-gray-600">Semester Ganjil T.A. 2023/2024</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4 text-center">KKM</th>
                        <th class="p-4 text-center">Nilai Akhir</th>
                        <th class="p-4 text-center">Predikat</th>
                        <th class="p-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($rapor as $idx => $r)
                    <tr>
                        <td class="p-4 text-center">{{ $idx + 1 }}</td>
                        <td class="p-4">{{ $r->subject->nama ?? '-' }}</td>
                        <td class="p-4 text-center">75</td>
                        <td class="p-4 text-center font-bold">{{ $r->nilai_akhir ?? '-' }}</td>
                        <td class="p-4 text-center">
                            @if($r->nilai_akhir >= 90) A
                            @elseif($r->nilai_akhir >= 80) B
                            @elseif($r->nilai_akhir >= 75) C
                            @else D
                            @endif
                        </td>
                        <td class="p-4">
                            @if($r->nilai_akhir >= 90) Sangat Baik
                            @elseif($r->nilai_akhir >= 80) Baik
                            @elseif($r->nilai_akhir >= 75) Cukup
                            @else Perlu Peningkatan
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data nilai rapor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
             <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                 <i data-lucide="download" class="w-4 h-4"></i> Download PDF
             </button>
         </div>
    </div>
</div>
@endsection
