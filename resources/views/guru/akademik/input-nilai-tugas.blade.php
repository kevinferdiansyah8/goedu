@extends('layouts.admin')

@section('title', 'Input Nilai Tugas')

@section('content')

{{-- HEADER --}}
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">Input Nilai Tugas / Ulangan</h1>
        <p class="text-gray-500">Masukkan nilai tugas atau ulangan siswa</p>
    </div>

    {{-- Filter --}}
    <div class="flex gap-3 flex-wrap">
        <select class="px-4 py-2 rounded-xl border text-sm">
            <option>X IPA 1</option>
            <option>X IPA 2</option>
        </select>

        <select class="px-4 py-2 rounded-xl border text-sm">
            <option>Tugas Harian</option>
            <option>Ulangan Harian</option>
        </select>

        <input type="date" class="px-4 py-2 rounded-xl border text-sm">
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Siswa</th>
                    <th class="px-6 py-3 text-left">NIS</th>
                    <th class="px-6 py-3 text-left">Nilai</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <tr>
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">Ahmad Fauzi</td>
                    <td class="px-6 py-4">20230101</td>
                    <td class="px-6 py-4">
                        <input type="number" class="w-20 px-2 py-1 border rounded-lg" value="85">
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-green-600 font-medium">Sudah Dinilai</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">Siti Aisyah</td>
                    <td class="px-6 py-4">20230102</td>
                    <td class="px-6 py-4">
                        <input type="number" class="w-20 px-2 py-1 border rounded-lg" placeholder="-">
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-orange-600 font-medium">Belum Dinilai</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <button class="px-6 py-2 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700">
            Simpan Nilai
        </button>
    </div>

</div>
@endsection