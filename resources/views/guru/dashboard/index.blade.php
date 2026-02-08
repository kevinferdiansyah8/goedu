@extends('layouts.admin')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Guru</h1>
        <p class="text-gray-500">Ringkasan aktivitas pribadi Anda hari ini</p>
    </div>

    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Jadwal Hari Ini --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Jadwal Mengajar Hari Ini</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">3</p>
            <p class="text-sm text-gray-400 mt-1">Kelas</p>
        </div>

        {{-- Total Kelas --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Kelas Diampu</p>
            <p class="text-3xl font-bold text-green-600 mt-2">5</p>
            <p class="text-sm text-gray-400 mt-1">Kelas</p>
        </div>

        {{-- Absensi --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Rata-rata Kehadiran</p>
            <p class="text-3xl font-bold text-indigo-600 mt-2">92%</p>
            <p class="text-sm text-gray-400 mt-1">Bulan ini</p>
        </div>

        {{-- Notifikasi --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Notifikasi</p>
            <p class="text-3xl font-bold text-red-500 mt-2">4</p>
            <p class="text-sm text-gray-400 mt-1">Perlu ditindaklanjuti</p>
        </div>
    </div>

   {{-- JADWAL MENGAJAR HARI INI --}}
<div class="bg-white rounded-xl p-6 shadow-sm">
    <h2 class="text-lg font-semibold mb-4">Jadwal Mengajar Hari Ini</h2>

    <div class="space-y-4">

        {{-- ITEM --}}
        <div class="flex items-center justify-between p-4 rounded-xl border hover:bg-gray-50 transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 font-semibold">
                    07.00
                </div>

                <div>
                    <p class="font-semibold text-gray-800">Matematika</p>
                    <p class="text-sm text-gray-500">X IPA 1 · Ruang 101</p>
                </div>
            </div>

            <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-600">
                Sedang berlangsung
            </span>
        </div>

        {{-- ITEM --}}
        <div class="flex items-center justify-between p-4 rounded-xl border hover:bg-gray-50 transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 font-semibold">
                    09.00
                </div>

                <div>
                    <p class="font-semibold text-gray-800">Matematika</p>
                    <p class="text-sm text-gray-500">X IPA 2 · Ruang 102</p>
                </div>
            </div>

            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-600">
                Akan datang
            </span>
        </div>

        {{-- ITEM --}}
        <div class="flex items-center justify-between p-4 rounded-xl border hover:bg-gray-50 transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600 font-semibold">
                    11.00
                </div>

                <div>
                    <p class="font-semibold text-gray-800">Matematika</p>
                    <p class="text-sm text-gray-500">XI IPA 1 · Ruang 201</p>
                </div>
            </div>

            <span class="px-3 py-1 rounded-full text-sm bg-gray-200 text-gray-600">
                Akan datang
            </span>
        </div>

    </div>
</div>



  {{-- GRAFIK ABSENSI --}}
       {{-- GRAFIK ABSENSI --}}
<div class="bg-white rounded-xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Grafik Absensi Kelas</h2>
        <span class="text-sm text-gray-500">7 Hari Terakhir</span>
    </div>

    {{-- PENTING: height langsung di div --}}
    <div style="height:320px;">
        <canvas id="grafikAbsensiGuru"></canvas>
    </div>
</div>


    {{-- NOTIFIKASI & PENGUMUMAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Notifikasi Tugas --}}
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Notifikasi Tugas</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between">
                    <span>⏳ Penilaian tugas X IPA 1</span>
                    <span class="text-red-500">Belum dinilai</span>
                </li>
                <li class="flex justify-between">
                    <span>📌 Tugas baru XI IPA 1</span>
                    <span class="text-yellow-500">Perlu dicek</span>
                </li>
            </ul>
        </div>

        {{-- Pengumuman --}}
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Pengumuman Sekolah</h2>
            <ul class="space-y-3 text-sm text-gray-700">
                <li>📢 Rapat guru hari Jumat pukul 13.00</li>
                <li>📢 Pengisian nilai rapor ditutup 25 Juni</li>
            </ul>
        </div>

    </div>

</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('grafikAbsensiGuru');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Kehadiran (%)',
                data: [90, 85, 88, 92, 95, 0, 0],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.25)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: {
                        callback: value => value + '%'
                    }
                }
            }
        }
    });
});
</script>
@endpush

@endsection
