@extends('layouts.admin')

@section('title', 'Dokumentasi Sekolah')

@section('content')
@php
$dokumentasi = [
    [
        'judul' => 'Pentas Seni Akhir Tahun',
        'tanggal' => '2026-03-11',
        'kategori' => 'Event',
        'jumlah_foto' => 24,
        'thumbnail' => 'https://picsum.photos/400/250?1'
    ],
    [
        'judul' => 'Seminar Karir & Industri',
        'tanggal' => '2026-02-05',
        'kategori' => 'Agenda',
        'jumlah_foto' => 18,
        'thumbnail' => 'https://picsum.photos/400/250?2'
    ],
    [
        'judul' => 'Upacara Bendera',
        'tanggal' => '2026-01-15',
        'kategori' => 'Rutin',
        'jumlah_foto' => 12,
        'thumbnail' => 'https://picsum.photos/400/250?3'
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 shadow-lg">
                    <i data-lucide="images" class="w-7 h-7 text-white"></i>
                </span>
                Dokumentasi Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola galeri foto kegiatan sekolah dengan tampilan modern</p>
        </div>
        <button onclick="toggleDokumentasiForm()"
            class="flex items-center gap-2 px-7 py-3 bg-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Dokumentasi
        </button>
    </div>

    <!-- GRID GALERI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($dokumentasi as $d)
        <div class="bg-white border border-blue-100 rounded-3xl shadow-xl hover:shadow-2xl transition overflow-hidden flex flex-col">
            <img src="{{ $d['thumbnail'] }}" alt="thumbnail"
                class="w-full h-52 object-cover">
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <div class="text-xs text-gray-400 mb-1">{{ $d['tanggal'] }}</div>
                    <h3 class="font-bold text-blue-700 text-lg mb-2">{{ $d['judul'] }}</h3>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            {{ $d['kategori'] }}
                        </span>
                        <span class="text-gray-500 text-xs">
                            {{ $d['jumlah_foto'] }} foto
                        </span>
                    </div>
                </div>
                <div class="flex gap-2 pt-3">
                    <button class="flex-1 px-4 py-2 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 font-bold shadow-sm">
                        <i data-lucide="eye" class="w-4 h-4"></i> Lihat
                    </button>
                    <button class="flex-1 px-4 py-2 text-xs rounded-xl bg-blue-500 text-white font-bold shadow">
                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FORM TAMBAH DOKUMENTASI (MODAL) -->
    <div id="formDokumentasi" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 text-blue-700">
                <i data-lucide="image-plus" class="w-7 h-7"></i>
                Tambah Dokumentasi
            </h2>
            <form class="space-y-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Dokumentasi</label>
                    <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Contoh: Pentas Seni Akhir Tahun">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Kategori</label>
                        <select class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                            <option>Event</option>
                            <option>Agenda</option>
                            <option>Rutin</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Upload Foto</label>
                    <input type="file" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" multiple>
                    <p class="text-xs text-gray-400 mt-1">Bisa upload lebih dari 1 foto</p>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" onclick="toggleDokumentasiForm()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-7 py-2 bg-blue-500 text-white rounded-xl font-bold shadow-xl">
                        Simpan Dokumentasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function toggleDokumentasiForm() {
    const form = document.getElementById('formDokumentasi');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        setTimeout(() => form.classList.add('opacity-100'), 10);
    } else {
        form.classList.remove('opacity-100');
        setTimeout(() => form.classList.add('hidden'), 300);
    }
}
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
