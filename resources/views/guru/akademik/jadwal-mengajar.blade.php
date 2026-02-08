@extends('layouts.admin')

@section('title', 'Jadwal Mengajar')

@section('content')

{{-- HEADER --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold">Jadwal Mengajar</h1>
    <p class="text-gray-500">
        Daftar jadwal mengajar Anda berdasarkan hari dan kelas
    </p>
</div>

{{-- FILTER (DUMMY) --}}
<div class="flex flex-wrap gap-4 mb-6">
    <select class="px-4 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-100">
        <option>Hari Ini</option>
        <option>Senin</option>
        <option>Selasa</option>
        <option>Rabu</option>
        <option>Kamis</option>
        <option>Jumat</option>
    </select>

    <select class="px-4 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-100">
        <option>Semua Kelas</option>
        <option>X IPA 1</option>
        <option>X IPA 2</option>
        <option>XI IPA 1</option>
    </select>
</div>

{{-- JADWAL CARD LIST --}}
<div class="space-y-4">

    {{-- ITEM --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 font-bold px-4 py-2 rounded-lg text-center">
                    07.00<br>08.30
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Matematika</h3>
                    <p class="text-gray-500 text-sm">
                        X IPA 1 • Ruang 101
                    </p>
                </div>
            </div>
            <span class="text-sm text-green-600 font-medium">
                Hari Ini
            </span>
        </div>
    </div>

    {{-- ITEM --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 text-indigo-600 font-bold px-4 py-2 rounded-lg text-center">
                    09.00<br>10.30
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Matematika</h3>
                    <p class="text-gray-500 text-sm">
                        X IPA 2 • Ruang 102
                    </p>
                </div>
            </div>
            <span class="text-sm text-green-600 font-medium">
                Hari Ini
            </span>
        </div>
    </div>

    {{-- ITEM --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 text-purple-600 font-bold px-4 py-2 rounded-lg text-center">
                    11.00<br>12.30
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Matematika</h3>
                    <p class="text-gray-500 text-sm">
                        XI IPA 1 • Ruang 201
                    </p>
                </div>
            </div>
            <span class="text-sm text-yellow-600 font-medium">
                Besok
            </span>
        </div>
    </div>

</div>

@endsection
