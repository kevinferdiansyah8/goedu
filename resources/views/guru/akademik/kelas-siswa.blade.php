@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold">Daftar Kelas & Siswa</h1>
        <p class="text-gray-500">Daftar kelas yang Anda ampu beserta data siswa</p>
    </div>

    {{-- Filter --}}
    <div class="flex flex-wrap gap-3">
        <select class="px-4 py-2 rounded-xl border text-sm focus:ring focus:ring-blue-100">
            <option>Semua Kelas</option>
            <option>X IPA 1</option>
            <option>X IPA 2</option>
        </select>

        <input
            type="text"
            placeholder="Cari nama siswa..."
            class="px-4 py-2 rounded-xl border text-sm w-64 focus:ring focus:ring-blue-100"
        >
    </div>

    {{-- Card Kelas --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        {{-- Card Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50">
            <div>
                <h2 class="text-lg font-semibold">X IPA 1</h2>
                <p class="text-sm text-gray-500">Matematika • 32 siswa</p>
            </div>

            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 font-medium">
                Aktif
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Siswa</th>
                        <th class="px-6 py-3 text-left">NIS</th>
                        <th class="px-6 py-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    {{-- Row --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">1</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                A
                            </div>
                            Ahmad Fauzi
                        </td>
                        <td class="px-6 py-4">20230101</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                Aktif
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">2</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-semibold">
                                S
                            </div>
                            Siti Aisyah
                        </td>
                        <td class="px-6 py-4">20230102</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                Aktif
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">3</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-semibold">
                                B
                            </div>
                            Budi Santoso
                        </td>
                        <td class="px-6 py-4">20230103</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                                Izin
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>


@endsection
