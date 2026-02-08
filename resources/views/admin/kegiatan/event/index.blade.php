@extends('layouts.admin')

@section('title', 'Event Sekolah')

@section('content')
@php
$events = [
    [
        'judul' => 'Pentas Seni Akhir Tahun',
        'tanggal_mulai' => '2026-03-10',
        'tanggal_selesai' => '2026-03-11',
        'lokasi' => 'Aula Sekolah',
        'status' => 'Dipublikasikan',
        'deskripsi' => 'Pentas seni tahunan menampilkan kreativitas siswa'
    ],
    [
        'judul' => 'Seminar Karir & Industri',
        'tanggal_mulai' => '2026-02-05',
        'tanggal_selesai' => '2026-02-05',
        'lokasi' => 'Ruang Multimedia',
        'status' => 'Draft',
        'deskripsi' => 'Seminar persiapan karir untuk siswa kelas XII'
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 shadow-lg">
                    <i data-lucide="calendar-heart" class="w-7 h-7 text-white"></i>
                </span>
                Event Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola event dan kegiatan besar sekolah dengan tampilan modern</p>
        </div>
        <button onclick="toggleEventForm()"
            class="flex items-center gap-2 px-7 py-3 bg-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Event
        </button>
    </div>

    <!-- TABEL EVENT (CARD) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $e)
        <div class="bg-white border border-blue-100 rounded-3xl shadow-xl p-7 flex flex-col justify-between hover:shadow-2xl transition group">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                        <i data-lucide="calendar-event" class="w-5 h-5 text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-blue-600">{{ $e['judul'] }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $e['lokasi'] }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="calendar" class="w-4 h-4"></i> {{ \Carbon\Carbon::parse($e['tanggal_mulai'])->translatedFormat('d F Y') }}
                        @if($e['tanggal_mulai'] !== $e['tanggal_selesai'])
                            <span class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($e['tanggal_selesai'])->translatedFormat('d F Y') }}</span>
                        @endif
                    </span>
                </div>
                <div class="mb-4 text-gray-700 text-base leading-relaxed">{{ $e['deskripsi'] }}</div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide shadow-sm
                    @if($e['status'] === 'Dipublikasikan') bg-blue-500 text-white @else bg-gray-300 text-gray-800 @endif">
                    {{ $e['status'] }}
                </span>
                <div class="flex gap-2">
                    <button class="flex items-center gap-1 px-4 py-1 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 shadow-sm font-semibold" type="button" onclick='showEventDetail(@json($e))'>
                        <i data-lucide="eye" class="w-4 h-4"></i> Detail
                    </button>
                    <button class="flex items-center gap-1 px-4 py-1 text-xs rounded-xl bg-blue-500 text-white hover:scale-105 shadow font-semibold">
                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FORM EVENT (MODAL) -->
    <div id="eventForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-pink-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 text-pink-700">
                <i data-lucide="calendar-heart" class="w-7 h-7"></i>
                Tambah / Edit Event
            </h2>
            <form class="space-y-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Event</label>
                    <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Nama event">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Deskripsi Event</label>
                    <textarea rows="3" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Deskripsi lengkap event"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                        <input type="date" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal Selesai</label>
                        <input type="date" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Lokasi</label>
                        <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Lokasi event">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                            <option>Draft</option>
                            <option>Dipublikasikan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Poster / Banner</label>
                    <input type="file" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" onclick="toggleEventForm()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-7 py-2 bg-gradient-to-r from-blue-600 to-pink-500 text-white rounded-xl font-bold shadow-xl">
                        Simpan Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL EVENT -->
    <div id="eventDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-lg animate-fadeIn">
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                    <i data-lucide="calendar-event" class="w-6 h-6 text-white"></i>
                </span>
                <span id="detailJudul" class="text-2xl font-bold text-gray-800"></span>
            </div>
            <div class="mb-4 text-gray-700 text-base leading-relaxed" id="detailDeskripsi"></div>
            <div class="mb-2 text-sm text-gray-600 flex gap-4">
                <span><i data-lucide="map-pin" class="w-4 h-4 inline"></i> <span id="detailLokasi"></span></span>
                <span><i data-lucide="calendar" class="w-4 h-4 inline"></i> <span id="detailTanggal"></span></span>
            </div>
            <div class="mb-2 text-sm text-gray-600 flex gap-4">
                <span>Status: <span id="detailStatus" class="font-bold"></span></span>
            </div>
            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeEventDetail()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function toggleEventForm() {
    const form = document.getElementById('eventForm');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        setTimeout(() => form.classList.add('opacity-100'), 10);
    } else {
        form.classList.remove('opacity-100');
        setTimeout(() => form.classList.add('hidden'), 300);
    }
}
function showEventDetail(data) {
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailDeskripsi').textContent = data.deskripsi;
    document.getElementById('detailLokasi').textContent = data.lokasi;
    let tanggal = data.tanggal_mulai;
    if(data.tanggal_mulai !== data.tanggal_selesai) {
        tanggal += ' s/d ' + data.tanggal_selesai;
    }
    document.getElementById('detailTanggal').textContent = tanggal;
    document.getElementById('detailStatus').textContent = data.status;
    document.getElementById('eventDetailModal').classList.remove('hidden');
    setTimeout(() => document.getElementById('eventDetailModal').classList.add('opacity-100'), 10);
    if(window.lucide) lucide.createIcons();
}
function closeEventDetail() {
    const modal = document.getElementById('eventDetailModal');
    modal.classList.remove('opacity-100');
    setTimeout(() => modal.classList.add('hidden'), 300);
}
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
