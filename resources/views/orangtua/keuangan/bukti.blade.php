@extends('layouts.admin')

@section('title', 'Bukti Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Upload Bukti Pembayaran</h1>
        <p class="text-gray-600">Unggah bukti transfer pembayaran manual.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Form Upload -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Formulir Konfirmasi</h2>
            <form action="{{ route('orangtua.keuangan.bukti.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pembayaran</label>
                    <select name="spp_bill_id" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" required>
                        @forelse($tagihanOptions as $option)
                            <option value="{{ $option->id }}">SPP {{ $option->bulan }} (Rp {{ number_format($option->nominal, 0, ',', '.') }})</option>
                        @empty
                            <option value="">Tidak ada tagihan aktif</option>
                        @endforelse
                    </select>
                </div>
                 <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transfer</label>
                    <input type="date" name="tanggal_transfer" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" required>
                </div>
                 <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Transfer</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                        <input type="number" name="nominal" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 pl-10 p-2.5 border" placeholder="375000" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer (Foto/Struk)</label>
                    <input type="file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors shadow-md shadow-blue-600/20">
                    Kirim Konfirmasi
                </button>
            </form>
        </div>

        <!-- Info Rekening -->
        <div class="space-y-6">
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h3 class="font-semibold text-blue-900 mb-2">Informasi Penting</h3>
                <ul class="text-sm text-blue-800 space-y-2 list-disc list-inside">
                    <li>Pastikan nominal transfer sesuai dengan tagihan.</li>
                    <li>Sertakan nama siswa di berita acara transfer jika memungkinkan.</li>
                    <li>Verifikasi pembayaran manual membutuhkan waktu 1x24 jam kerja.</li>
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Rekening Tujuan</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-3 border border-gray-200 rounded-lg">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold text-xs">BCA</div>
                        <div>
                            <p class="text-xs text-gray-500">Bank Central Asia</p>
                            <p class="font-mono font-bold text-gray-800 text-lg">123 456 7890</p>
                            <p class="text-xs text-gray-600">a.n Yayasan Pendidikan GoEdu</p>
                        </div>
                        <button class="ml-auto text-blue-600 hover:bg-blue-50 p-2 rounded-lg" title="Salin">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                    </div>
                     <div class="flex items-center gap-4 p-3 border border-gray-200 rounded-lg">
                        <div class="w-12 h-12 bg-blue-800 text-white rounded-lg flex items-center justify-center font-bold text-xs">BRI</div>
                        <div>
                            <p class="text-xs text-gray-500">Bank Rakyat Indonesia</p>
                            <p class="font-mono font-bold text-gray-800 text-lg">0000 01 00000 50 0</p>
                            <p class="text-xs text-gray-600">a.n Yayasan Pendidikan GoEdu</p>
                        </div>
                         <button class="ml-auto text-blue-600 hover:bg-blue-50 p-2 rounded-lg" title="Salin">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
