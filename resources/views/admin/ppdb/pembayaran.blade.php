@extends('layouts.admin')

@section('title', 'PPDB - Pembayaran')

@section('content')
@php
$statusPembayaran = 'menunggu_verifikasi'; 
// belum_bayar | menunggu_verifikasi | lunas | ditolak

$pendaftar = [
    'no' => 'PPDB-2024-0021',
    'nama' => 'Siti Aminah',
    'jurusan' => 'Teknik Komputer & Jaringan',
    'jalur' => 'Prestasi'
];

$pembayaran = [
    'biaya' => 250000,
    'metode' => 'Transfer Bank',
    'tanggal' => '2024-07-10',
    'bukti' => 'bukti-transfer.jpg',
    'catatan' => 'Transfer via BRI'
];
@endphp

<div class="max-w-7xl mx-auto px-6 py-8 space-y-10">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Pembayaran PPDB</h1>
        <p class="text-gray-500 mt-1">Verifikasi pembayaran pendaftar</p>
    </div>

    <!-- INFO PENDAFTAR MODERN -->
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <div class="flex-1 flex items-center bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition relative">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-extrabold flex items-center justify-center text-3xl shadow-lg border-4 border-white mr-6">
                {{ collect(explode(' ', $pendaftar['nama']))->map(fn($n)=>$n[0])->join('') }}
            </div>
            <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">No Pendaftaran</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['no'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Nama</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['nama'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Jurusan</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['jurusan'] }}</span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xs text-gray-500 mb-1">Jalur</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $pendaftar['jalur'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- INFO TAGIHAN MODERN -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-6 flex flex-col items-start">
            <span class="text-sm text-gray-500">Total Biaya</span>
            <span class="text-2xl font-bold text-blue-600 mt-1">Rp {{ number_format($pembayaran['biaya'], 0, ',', '.') }}</span>
        </div>
        <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-6 flex flex-col items-start">
            <span class="text-sm text-gray-500">Status Pembayaran</span>
            @if($statusPembayaran === 'lunas')
                <span class="mt-2 px-4 py-1 rounded-full bg-green-100 text-green-700 font-semibold text-sm shadow">LUNAS</span>
            @elseif($statusPembayaran === 'menunggu_verifikasi')
                <span class="mt-2 px-4 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-sm shadow">MENUNGGU VERIFIKASI</span>
            @elseif($statusPembayaran === 'ditolak')
                <span class="mt-2 px-4 py-1 rounded-full bg-red-100 text-red-700 font-semibold text-sm shadow">DITOLAK</span>
            @else
                <span class="mt-2 px-4 py-1 rounded-full bg-gray-100 text-gray-600 font-semibold text-sm shadow">BELUM BAYAR</span>
            @endif
        </div>
        <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-6 flex flex-col items-start">
            <span class="text-sm text-gray-500">Metode</span>
            <span class="font-semibold mt-1">{{ $pembayaran['metode'] }}</span>
            <span class="text-xs text-gray-400">{{ $pembayaran['tanggal'] }}</span>
        </div>
    </div>

    <!-- BUKTI PEMBAYARAN MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-6 space-y-4 mb-8">
        <h2 class="text-lg font-bold text-blue-700">Bukti Pembayaran</h2>
        @if($statusPembayaran === 'belum_bayar')
            <p class="text-gray-500 italic">Pendaftar belum mengunggah bukti pembayaran.</p>
            <form class="mt-4 flex flex-col gap-4" enctype="multipart/form-data">
                <label class="block">
                    <span class="text-sm text-gray-700">Upload Bukti Pembayaran</span>
                    <input type="file" name="bukti" accept="image/*,application/pdf" class="mt-2 block w-full border-2 border-blue-200 rounded-lg px-3 py-2 focus:border-blue-500 transition" />
                </label>
                <button type="submit" class="self-start px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Upload</button>
            </form>
        @else
            <div class="flex items-center gap-6">
                <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden relative">
                    <img src="/storage/bukti/{{ $pembayaran['bukti'] }}" alt="Bukti Pembayaran" class="object-contain w-full h-full" onerror="this.style.display='none'">
                    <i data-lucide="image" class="w-10 h-10 text-gray-400 absolute"></i>
                </div>
                <div>
                    <p class="font-medium">{{ $pembayaran['bukti'] }}</p>
                    <p class="text-sm text-gray-500">{{ $pembayaran['catatan'] }}</p>
                    <button class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm shadow hover:bg-blue-700 transition" onclick="alert('Preview bukti pembayaran')">Lihat Bukti</button>
                    <form class="mt-4 flex flex-col gap-4" enctype="multipart/form-data">
                        <label class="block">
                            <span class="text-sm text-gray-700">Ganti Bukti Pembayaran</span>
                            <input type="file" name="bukti" accept="image/*,application/pdf" class="mt-2 block w-full border-2 border-blue-200 rounded-lg px-3 py-2 focus:border-blue-500 transition" />
                        </label>
                        <button type="submit" class="self-start px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Upload Ulang</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- BUKTI PEMBAYARAN UNTUK PEGANGAN SISWA (PRINTABLE) -->
    <div class="bg-white border-2 border-green-200 rounded-2xl shadow-xl p-6 space-y-4 mb-8">
        <h2 class="text-lg font-bold text-green-700 flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='inline w-6 h-6 text-green-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z' /></svg> Bukti Pembayaran Siswa</h2>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 border-t pt-4">
            <div class="flex-1 space-y-2">
                <div><span class="text-gray-500 text-sm">No Pendaftaran:</span> <span class="font-bold text-gray-900">{{ $pendaftar['no'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Nama:</span> <span class="font-bold text-gray-900">{{ $pendaftar['nama'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Jurusan:</span> <span class="font-bold text-gray-900">{{ $pendaftar['jurusan'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Jalur:</span> <span class="font-bold text-gray-900">{{ $pendaftar['jalur'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Tanggal Bayar:</span> <span class="font-bold text-gray-900">{{ $pembayaran['tanggal'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Metode:</span> <span class="font-bold text-gray-900">{{ $pembayaran['metode'] }}</span></div>
                <div><span class="text-gray-500 text-sm">Total:</span> <span class="font-bold text-blue-700">Rp {{ number_format($pembayaran['biaya'], 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500 text-sm">Status:</span> 
                    @if($statusPembayaran === 'lunas')
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold text-xs">LUNAS</span>
                    @elseif($statusPembayaran === 'menunggu_verifikasi')
                        <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-xs">MENUNGGU VERIFIKASI</span>
                    @elseif($statusPembayaran === 'ditolak')
                        <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold text-xs">DITOLAK</span>
                    @else
                        <span class="inline-block px-3 py-1 rounded-full bg-gray-100 text-gray-600 font-semibold text-xs">BELUM BAYAR</span>
                    @endif
                </div>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden relative">
                    <img src="/storage/bukti/{{ $pembayaran['bukti'] }}" alt="Bukti Pembayaran" class="object-contain w-full h-full" onerror="this.style.display='none'">
                    <i data-lucide="image" class="w-10 h-10 text-gray-400 absolute"></i>
                </div>
                <span class="text-xs text-gray-500">Bukti Transfer</span>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="window.print()" class="px-5 py-2 rounded-lg bg-green-600 text-white font-semibold shadow hover:bg-green-700 transition"><svg xmlns='http://www.w3.org/2000/svg' class='inline w-5 h-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-6 0v4m0 0h4m-4 0H8' /></svg> Cetak Bukti</button>
        </div>
    </div>

    <!-- VERIFIKASI ADMIN MODERN -->
    <div class="bg-white border-2 border-blue-200 rounded-2xl shadow-xl p-7 mb-8">
        <h2 class="text-lg font-bold mb-4 text-blue-700">Verifikasi Admin</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-sm font-medium text-gray-700">Keputusan</label>
                <select class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition">
                    <option value="menunggu_verifikasi">Menunggu</option>
                    <option value="lunas">Terima (Lunas)</option>
                    <option value="ditolak">Tolak Pembayaran</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Catatan Admin</label>
                <textarea rows="3" class="mt-1 w-full border-2 border-blue-200 rounded-lg px-4 py-2 focus:border-blue-500 transition" placeholder="Contoh: Nominal tidak sesuai, mohon upload ulang bukti pembayaran"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 mt-2 justify-end">
            <button class="px-6 py-2 border-2 border-blue-200 rounded-lg font-semibold bg-white hover:bg-blue-50 transition">Batal</button>
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">Simpan Verifikasi</button>
        </div>
    </div>

</div>
@endsection
