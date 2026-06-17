@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pembayaran</h1>
        <p class="text-gray-600">Catatan historis pembayaran yang telah dilakukan.</p>
    </div>

    <!-- Filter -->
    <div class="flex gap-4 mb-6">
        <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border bg-white shadow-sm">
            <option>Semua Status</option>
            <option>Lunas</option>
            <option>Menunggu Konfirmasi</option>
        </select>
         <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border bg-white shadow-sm">
            <option>Tahun Ajaran 2023/2024</option>
             <option>Tahun Ajaran 2022/2023</option>
        </select>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">ID Transaksi</th>
                        <th class="p-4">Tanggal Pembayaran</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4">Metode</th>
                        <th class="p-4">Nominal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-xs text-gray-500">#TX-{{ str_pad($r->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $r->keterangan }}</td>
                        <td class="p-4 text-gray-600">{{ $r->metode }}</td>
                        <td class="p-4 font-bold text-gray-800">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($r->status === 'Terverifikasi')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Lunas</span>
                            @elseif($r->status === 'Pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium">Menunggu Verifikasi</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium">Ditolak</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($r->bukti)
                                <a href="{{ asset('storage/' . $r->bukti) }}" target="_blank" class="text-blue-600 hover:text-blue-750 font-medium text-xs flex items-center gap-1">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-400">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
