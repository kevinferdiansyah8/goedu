@extends('layouts.admin')

@section('title', 'Izin / Sakit')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengajuan Izin / Sakit</h1>
        <p class="text-gray-600">Form pengajuan ketidakhadiran siswa.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Pengajuan -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-plus" class="w-5 h-5 text-blue-600"></i> Buat Pengajuan Baru
                </h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Ketidakhadiran</label>
                        <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option>Izin</option>
                            <option>Sakit</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Alasan ketidakhadiran..."></textarea>
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti (Surat Dokter/Ortu)</label>
                        <input type="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <button type="button" class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">Kirim Pengajuan</button>
                </form>
            </div>
        </div>

        <!-- Riwayat Pengajuan -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-gray-600"></i> Riwayat Pengajuan
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                                <th class="px-4 py-3 font-semibold">Tanggal</th>
                                <th class="px-4 py-3 font-semibold">Jenis</th>
                                <th class="px-4 py-3 font-semibold">Keterangan</th>
                                <th class="px-4 py-3 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($riwayat_izin as $izin)
                            <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($izin['tanggal_mulai'])->format('d M') }} - {{ \Carbon\Carbon::parse($izin['tanggal_selesai'])->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $izin['jenis'] == 'Sakit' ? 'bg-yellow-50 text-yellow-700' : 'bg-blue-50 text-blue-700' }}">
                                        {{ $izin['jenis'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $izin['keterangan'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">{{ $izin['status'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
