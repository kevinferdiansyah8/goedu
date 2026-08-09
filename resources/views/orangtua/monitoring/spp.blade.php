@extends('layouts.admin')

@section('title', 'Status SPP')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Status SPP</h1>
            <p class="text-gray-600">Informasi dan status pembayaran SPP siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span> secara realtime.</p>
        </div>
        <a href="{{ route('orangtua.keuangan.tagihan') }}" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all flex items-center gap-2 self-start">
            <i data-lucide="credit-card" class="w-4 h-4"></i> Bayar / Upload Bukti SPP
        </a>
    </div>

    <!-- Status Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Status SPP Bulan Ini ({{ $activeMonthBill->bulan ?? date('F Y') }})</h3>
                <p class="text-gray-500 text-sm mt-1">Nominal: <span class="font-bold text-gray-800">Rp {{ number_format($activeMonthBill->nominal ?? 350000, 0, ',', '.') }}</span></p>
            </div>
            <div class="flex items-center gap-2">
                @if(($activeMonthBill->status ?? '') === 'Lunas')
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-extrabold flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> LUNAS
                    </span>
                @else
                    <span class="px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-extrabold flex items-center gap-1">
                        <i data-lucide="clock" class="w-4 h-4"></i> {{ strtoupper($activeMonthBill->status ?? 'BELUM BAYAR') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- History Payment -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-orange-500"></i> Seluruh Tagihan & Riwayat SPP
            </h3>
            <a href="{{ route('orangtua.keuangan.riwayat') }}" class="text-xs font-semibold text-primary hover:underline">Riwayat Transaksi &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Bulan Tagihan</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($tagihan as $t)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 font-bold text-gray-800">{{ $t->bulan }}</td>
                        <td class="p-4 text-gray-800 font-semibold">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($t->status === 'Lunas')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Lunas</span>
                            @elseif($t->status === 'Pending')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($t->status !== 'Lunas')
                                <a href="{{ route('orangtua.keuangan.bukti') }}" class="px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-hover transition-colors inline-block">Bayar</a>
                            @else
                                <span class="text-xs text-gray-400 font-medium">Terverifikasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500 font-medium">Belum ada data tagihan SPP di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
