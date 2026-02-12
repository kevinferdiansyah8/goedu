@extends('layouts.admin')

@section('title', 'Izin / Sakit')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Izin / Sakit</h1>
            <p class="text-gray-600">Ajukan surat izin atau keterangan sakit.</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat Pengajuan
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium text-sm">
                    <tr>
                        <th class="p-4">Tanggal Pengajuan</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Mulai Tanggal</th>
                        <th class="p-4">Sampai Tanggal</th>
                        <th class="p-4">Keterangan</th>
                        <th class="p-4">Bukti</th>
                        <th class="p-4">Status Approval</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">08 Feb 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Sakit</span></td>
                        <td class="p-4">08 Feb 2024</td>
                        <td class="p-4">08 Feb 2024</td>
                        <td class="p-4 text-gray-500">Demam</td>
                         <td class="p-4"><a href="#" class="text-blue-600 hover:underline text-xs flex items-center gap-1"><i data-lucide="file" class="w-3 h-3"></i> surat_dokter.jpg</a></td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Disetujui</span></td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-700">15 Jan 2024</td>
                        <td class="p-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium">Izin</span></td>
                        <td class="p-4">20 Jan 2024</td>
                        <td class="p-4">20 Jan 2024</td>
                        <td class="p-4 text-gray-500">Acara Keluarga</td>
                         <td class="p-4 text-gray-400 text-xs">-</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Disetujui</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
