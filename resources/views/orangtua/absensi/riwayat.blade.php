@extends('layouts.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
        <p class="text-gray-600">Catatan kehadiran harian siswa.</p>
    </div>

    <!-- Calendar View Placeholder (Can be enhanced with library later) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar Widget -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-1">
             <h3 class="font-semibold text-gray-800 mb-4">Kalender Februari 2024</h3>
             <div class="grid grid-cols-7 gap-1 text-center text-sm">
                 <div class="text-gray-400 py-2">Min</div>
                 <div class="text-gray-400 py-2">Sen</div>
                 <div class="text-gray-400 py-2">Sel</div>
                 <div class="text-gray-400 py-2">Rab</div>
                 <div class="text-gray-400 py-2">Kam</div>
                 <div class="text-gray-400 py-2">Jum</div>
                 <div class="text-gray-400 py-2">Sab</div>

                 <!-- Empty days -->
                 <div class="py-2"></div>
                 <div class="py-2"></div>
                 <div class="py-2"></div>
                 <div class="py-2"></div>

                 <!-- Days -->
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer">1</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-green-600 bg-green-50">2</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer text-gray-400">3</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer text-gray-400">4</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-green-600 bg-green-50">5</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-green-600 bg-green-50">6</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-green-600 bg-green-50">7</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-blue-600 bg-blue-50">8</div>
                 <div class="py-2 hover:bg-gray-100 rounded-lg cursor-pointer font-bold text-green-600 bg-green-50">9</div>
                 <!-- ... -->
             </div>
        </div>

        <!-- History List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-semibold text-gray-800">Detail Kehadiran</h3>
            </div>
             <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white text-gray-600 font-medium text-sm border-b border-gray-100">
                        <tr>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Jam Masuk</th>
                            <th class="p-4">Jam Pulang</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700">09 Feb 2024</td>
                            <td class="p-4">07:00</td>
                            <td class="p-4">14:00</td>
                            <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                             <td class="p-4 text-gray-500">-</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700">08 Feb 2024</td>
                            <td class="p-4">-</td>
                            <td class="p-4">-</td>
                            <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Sakit</span></td>
                             <td class="p-4 text-gray-500">Demam Tinggi</td>
                        </tr>
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700">07 Feb 2024</td>
                            <td class="p-4">07:05</td>
                            <td class="p-4">14:00</td>
                            <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                             <td class="p-4 text-gray-500">-</td>
                        </tr>
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700">06 Feb 2024</td>
                            <td class="p-4">06:55</td>
                            <td class="p-4">14:00</td>
                            <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Hadir</span></td>
                             <td class="p-4 text-gray-500">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
