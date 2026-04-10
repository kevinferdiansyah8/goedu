@extends('layouts.admin')

@section('title', 'Tagihan SPP')

@section('content')
@php
$tagihan_aktif = [
    ['bulan' => 'April 2026', 'jatuh_tempo' => '10 April 2026', 'nominal' => 375000, 'status' => 'Belum Bayar', 'denda' => 0],
    ['bulan' => 'Maret 2026', 'jatuh_tempo' => '10 Maret 2026', 'nominal' => 375000, 'status' => 'Terlambat', 'denda' => 25000],
];

$riwayat_bayar = [
    ['bulan' => 'Februari 2026', 'tanggal_bayar' => '08 Feb 2026', 'nominal' => 375000, 'metode' => 'Transfer Bank', 'status' => 'Lunas'],
    ['bulan' => 'Januari 2026', 'tanggal_bayar' => '05 Jan 2026', 'nominal' => 375000, 'metode' => 'QRIS', 'status' => 'Lunas'],
    ['bulan' => 'Desember 2025', 'tanggal_bayar' => '09 Des 2025', 'nominal' => 375000, 'metode' => 'Tunai', 'status' => 'Lunas'],
    ['bulan' => 'November 2025', 'tanggal_bayar' => '07 Nov 2025', 'nominal' => 375000, 'metode' => 'Transfer Bank', 'status' => 'Lunas'],
];

$anak = ['nama' => 'Dewi Lestari', 'nis' => '2024004', 'kelas' => 'XI-A', 'semester' => 'Genap 2025/2026'];
@endphp

<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tagihan SPP</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar tagihan pembayaran sekolah anak Anda</p>
        </div>
    </div>

    <!-- Info Anak -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-5">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold flex items-center justify-center text-xl shadow-lg border-4 border-white">
            {{ collect(explode(' ', $anak['nama']))->map(fn($n) => $n[0])->join('') }}
        </div>
        <div class="flex-1 grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div><span class="text-xs text-gray-500">Nama Siswa</span><p class="font-semibold text-gray-900">{{ $anak['nama'] }}</p></div>
            <div><span class="text-xs text-gray-500">NIS</span><p class="font-semibold text-gray-900">{{ $anak['nis'] }}</p></div>
            <div><span class="text-xs text-gray-500">Kelas</span><p class="font-semibold text-gray-900">{{ $anak['kelas'] }}</p></div>
            <div><span class="text-xs text-gray-500">Semester</span><p class="font-semibold text-gray-900">{{ $anak['semester'] }}</p></div>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="flex items-center gap-4 rounded-2xl border-2 border-red-200 bg-gradient-to-br from-red-50 to-white p-5">
            <div class="size-12 bg-red-100 rounded-xl flex items-center justify-center"><i data-lucide="alert-circle" class="size-6 text-red-500"></i></div>
            <div>
                <p class="text-xs text-gray-500">Total Tunggakan</p>
                <p class="font-bold text-xl text-red-600">Rp {{ number_format(375000 + 375000 + 25000, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border-2 border-yellow-200 bg-gradient-to-br from-yellow-50 to-white p-5">
            <div class="size-12 bg-yellow-100 rounded-xl flex items-center justify-center"><i data-lucide="clock" class="size-6 text-yellow-600"></i></div>
            <div>
                <p class="text-xs text-gray-500">Tagihan Aktif</p>
                <p class="font-bold text-xl text-yellow-700">2 bulan</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border-2 border-green-200 bg-gradient-to-br from-green-50 to-white p-5">
            <div class="size-12 bg-green-100 rounded-xl flex items-center justify-center"><i data-lucide="check-circle" class="size-6 text-green-500"></i></div>
            <div>
                <p class="text-xs text-gray-500">Sudah Dibayar</p>
                <p class="font-bold text-xl text-green-600">4 bulan</p>
            </div>
        </div>
    </div>

    <!-- Tagihan Aktif -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="receipt" class="w-5 h-5 text-red-500"></i> Tagihan Belum Dibayar
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($tagihan_aktif as $t)
            <div class="bg-white rounded-2xl shadow-lg border-l-4 {{ $t['status'] === 'Terlambat' ? 'border-red-500' : 'border-yellow-400' }} overflow-hidden hover:shadow-xl transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            @if($t['status'] === 'Terlambat')
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold inline-block mb-2">TERLAMBAT</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold inline-block mb-2">BELUM BAYAR</span>
                            @endif
                            <h3 class="text-lg font-bold text-gray-900">SPP {{ $t['bulan'] }}</h3>
                            <p class="text-gray-500 text-sm mt-1">Jatuh Tempo: {{ $t['jatuh_tempo'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($t['nominal'] + $t['denda'], 0, ',', '.') }}</p>
                            @if($t['denda'] > 0)
                                <p class="text-xs text-red-500 mt-1">+ Denda Rp {{ number_format($t['denda'], 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button class="px-4 py-2 border border-gray-300 rounded-xl text-gray-600 hover:bg-gray-50 font-medium text-sm transition-colors">Detail</button>
                        <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-md shadow-blue-600/20 text-sm transition-colors">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-green-500"></i> Riwayat Pembayaran
        </h2>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-semibold text-gray-500">Bulan</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-500">Tanggal Bayar</th>
                            <th class="text-right px-6 py-4 font-semibold text-gray-500">Nominal</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-500">Metode</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_bayar as $r)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $r['bulan'] }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $r['tanggal_bayar'] }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($r['metode'] === 'Transfer Bank')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold"><i data-lucide="building-2" class="size-3"></i> Transfer</span>
                                @elseif($r['metode'] === 'QRIS')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold"><i data-lucide="qr-code" class="size-3"></i> QRIS</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold"><i data-lucide="banknote" class="size-3"></i> Tunai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">✓ Lunas</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="p-4 bg-blue-50 rounded-2xl border-l-4 border-blue-500">
        <div class="flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-gray-900 text-sm font-medium">Informasi Pembayaran</h4>
                <p class="text-gray-600 text-xs mt-1">Pembayaran SPP dapat dilakukan melalui Transfer Bank, QRIS, atau langsung ke bagian Tata Usaha. Keterlambatan pembayaran akan dikenakan denda Rp 25.000.</p>
            </div>
        </div>
    </div>

</div>
@endsection
