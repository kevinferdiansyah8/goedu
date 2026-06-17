@extends('layouts.admin')

@section('title', 'Izin / Sakit')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Izin / Sakit</h1>
            <p class="text-gray-600">Ajukan surat izin atau keterangan sakit untuk anak Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Pengajuan -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-plus" class="w-5 h-5 text-blue-600"></i> Buat Pengajuan Baru
                </h3>
                <form action="{{ route('orangtua.absensi.izin.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    @if(session('success'))
                        <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Ketidakhadiran</label>
                        <select name="jenis" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Alasan ketidakhadiran..."></textarea>
                    </div>
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti (Surat Dokter)</label>
                        <input type="file" name="bukti" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">Kirim Pengajuan</button>
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
                            @forelse($izinSakit as $is)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-gray-700">{{ $is['tanggal_pengajuan'] }}</td>
                                <td class="p-4">
                                    @if($is['kategori'] === 'Sakit')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Sakit</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium">Izin</span>
                                    @endif
                                </td>
                                <td class="p-4">{{ $is['mulai_tanggal'] }}</td>
                                <td class="p-4">{{ $is['sampai_tanggal'] }}</td>
                                <td class="p-4 text-gray-500">{{ $is['keterangan'] }}</td>
                                <td class="p-4 text-gray-400 text-xs">{{ $is['bukti'] }}</td>
                                <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">{{ $is['status'] }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400">Belum ada riwayat pengajuan izin/sakit.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
