@extends('layouts.admin')

@section('title', 'Form Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Form Peminjaman Buku</h1>
            <p class="text-gray-600">Isi data berikut untuk mengajukan peminjaman buku.</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <form action="#" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku</label>
                        <select class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Judul Buku --</option>
                            @foreach($buku_list as $judul)
                                <option value="{{ $judul }}">{{ $judul }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                            <input type="date" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Durasi Pinjam</label>
                             <select class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                 <option value="3">3 Hari</option>
                                 <option value="7" selected>7 Hari</option>
                                 <option value="14">14 Hari</option>
                             </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                        <textarea rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Kondisi buku saat dipinjam, dll."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
