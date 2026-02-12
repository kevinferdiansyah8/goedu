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
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pembayaran</label>
                    <select class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
                        <option>SPP Februari 2024</option>
                        <option>Uang Gedung</option>
                        <option>Lainnya</option>
                    </select>
                </div>
                 <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transfer</label>
                    <input type="date" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
                </div>
                 <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Transfer</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                        <input type="number" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 pl-10 p-2.5 border" placeholder="500000">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer (Foto/Struk)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="space-y-1 text-center">
                            <i data-lucide="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 2MB</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors shadow-md shadow-blue-600/20">
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
