@extends('layouts.admin')

@section('title', 'Dashboard Guru')

@section('content')

<div class="space-y-6">

    <!-- Judul -->
    <div>
        <h1 class="text-2xl font-bold">Dashboard Guru</h1>
        <p class="text-gray-600">Selamat datang di dashboard guru.</p>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Jadwal Hari Ini</p>
            <p class="text-2xl font-bold">3 Kelas</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Total Kelas</p>
            <p class="text-2xl font-bold">5</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Total Siswa</p>
            <p class="text-2xl font-bold">160</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Tugas Belum Dinilai</p>
            <p class="text-2xl font-bold text-red-500">8</p>
        </div>

    </div>

    <!-- Jadwal Mengajar -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Jadwal Mengajar Hari Ini</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Jam</th>
                    <th class="text-left py-2">Mata Pelajaran</th>
                    <th class="text-left py-2">Kelas</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-2">07.00 - 08.30</td>
                    <td class="py-2">Matematika</td>
                    <td class="py-2">X RPL 1</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2">09.00 - 10.30</td>
                    <td class="py-2">Matematika</td>
                    <td class="py-2">X RPL 2</td>
                </tr>
                <tr>
                    <td class="py-2">11.00 - 12.30</td>
                    <td class="py-2">Matematika</td>
                    <td class="py-2">XI RPL</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Kelas Diampu -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Kelas yang Diampu</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4">
                <p class="font-semibold">X RPL 1</p>
                <p class="text-sm text-gray-500">32 Siswa</p>
            </div>
            <div class="border rounded-lg p-4">
                <p class="font-semibold">X RPL 2</p>
                <p class="text-sm text-gray-500">30 Siswa</p>
            </div>
            <div class="border rounded-lg p-4">
                <p class="font-semibold">XI RPL</p>
                <p class="text-sm text-gray-500">28 Siswa</p>
            </div>
        </div>
    </div>

</div>

@endsection
