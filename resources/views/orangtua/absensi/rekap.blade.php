@extends('layouts.admin')

@section('title', 'Rekap Absensi Bulanan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rekap Bulanan</h1>
        <p class="text-gray-600">Statistik kehadiran bulanan.</p>
    </div>

    <!-- Month Selector -->
    <form method="GET" action="{{ route('orangtua.absensi.rekap') }}" class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <label for="bulan-rekap" class="text-sm font-medium text-gray-700">Pilih Bulan:</label>
        <select id="bulan-rekap" name="bulan" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
            @foreach($dropdownOptions as $val => $lbl)
                <option value="{{ $val }}" {{ $selectedBulan === $val ? 'selected' : '' }}>{{ $lbl }}</option>
            @endforeach
        </select>
    </form>

    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Bulan: {{ $selectedBulanName }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Summary Cards -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $hadir }}</h3>
            <p class="text-sm text-gray-500 mt-1">Hadir</p>
        </div>
         <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="plus-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $sakit }}</h3>
            <p class="text-sm text-gray-500 mt-1">Sakit</p>
        </div>
         <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="alert-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $izin }}</h3>
            <p class="text-sm text-gray-500 mt-1">Izin</p>
        </div>
         <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $alpha }}</h3>
            <p class="text-sm text-gray-500 mt-1">Alpha</p>
        </div>
    </div>

    <!-- Chart Placeholder -->
     <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-6">Grafik Kehadiran</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
            [Chart Area: Hadir vs Tidak Hadir]
        </div>
     </div>
</div>
@endsection
