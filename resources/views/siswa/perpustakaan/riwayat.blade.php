@extends('layouts.admin')

@section('title', 'Riwayat & Denda')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman & Denda</h1>
        <p class="text-gray-600">Lacak status peminjaman buku dan tagihan denda Anda.</p>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-blue-600">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-blue-800">1 Buku</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="bg-green-50 rounded-xl p-6 border border-green-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-green-600">Total Dikembalikan</p>
                <p class="text-2xl font-bold text-green-800">5 Buku</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full text-green-600">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="bg-red-50 rounded-xl p-6 border border-red-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-red-600">Total Denda</p>
                <p class="text-2xl font-bold text-red-800">Rp 5.000</p>
            </div>
            <div class="bg-red-100 p-3 rounded-full text-red-600">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Tgl Pinjam</th>
                        <th class="px-6 py-4">Tenggat Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($riwayat_pinjam as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item['judul'] }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item['tgl_pinjam'])->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item['tgl_kembali'])->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item['status'] == 'Dikembalikan')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-600">Dikembalikan</span>
                            @elseif($item['status'] == 'Terlambat')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Terlambat</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">Dipinjam</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-medium">
                            @if($item['denda'] > 0)
                                <span class="text-red-600">Rp {{ number_format($item['denda'], 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
