@extends('layouts.admin')

@section('title', 'Agenda Sekolah')

@section('content')
@php
$agenda = [
    [
        'judul' => 'Ujian Tengah Semester',
        'jenis' => 'Akademik',
        'tanggal' => '2026-02-10',
        'waktu' => '08:00 - 12:00',
        'lokasi' => 'Ruang Kelas',
        'status' => 'Akan Datang',
        'keterangan' => 'UTS untuk seluruh kelas'
    ],
    [
        'judul' => 'Rapat Guru',
        'jenis' => 'Rapat',
        'tanggal' => '2026-01-25',
        'waktu' => '13:00 - 15:00',
        'lokasi' => 'Ruang Guru',
        'status' => 'Akan Datang',
        'keterangan' => 'Evaluasi pembelajaran'
    ],
    [
        'judul' => 'Class Meeting',
        'jenis' => 'Non-Akademik',
        'tanggal' => '2025-12-15',
        'waktu' => '07:30 - 11:00',
        'lokasi' => 'Lapangan Sekolah',
        'status' => 'Selesai',
        'keterangan' => 'Kegiatan akhir semester'
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 shadow-lg">
                    <i data-lucide="calendar-days" class="w-7 h-7 text-white"></i>
                </span>
                Agenda Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola jadwal dan agenda kegiatan sekolah dengan tampilan modern</p>
        </div>
        <button onclick="toggleAgendaForm()"
            class="flex items-center gap-2 px-7 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Agenda
        </button>
    </div>

    <!-- FILTER -->
    <div class="flex flex-wrap gap-4 items-center mb-4">
        <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[140px] text-base appearance-none">
            <option value="">Semua Jenis</option>
            <option>Akademik</option>
            <option>Non-Akademik</option>
            <option>Rapat</option>
            <option>Ujian</option>
        </select>
        <select class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
            <option value="">Semua Status</option>
            <option>Akan Datang</option>
            <option>Selesai</option>
        </select>
    </div>

    <!-- AGENDA CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($agenda as $a)
        <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 border border-blue-100 rounded-3xl shadow-xl p-7 flex flex-col justify-between hover:shadow-2xl transition group">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500/80">
                        <i data-lucide="calendar-event" class="w-5 h-5 text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-blue-600">{{ $a['judul'] }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $a['lokasi'] }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="clock" class="w-4 h-4"></i> {{ $a['waktu'] }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="tag" class="w-4 h-4"></i> {{ $a['jenis'] }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="calendar" class="w-4 h-4"></i> {{ \Carbon\Carbon::parse($a['tanggal'])->translatedFormat('d F Y') }}</span>
                </div>
                <div class="mb-4 text-gray-700 text-base leading-relaxed">{{ $a['keterangan'] }}</div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide shadow-sm
                    @if($a['status'] === 'Akan Datang') bg-gradient-to-r from-blue-400 to-blue-600 text-white @else bg-gradient-to-r from-gray-300 to-gray-500 text-gray-800 @endif">
                    {{ $a['status'] }}
                </span>
                <div class="flex gap-2">
                    <button class="flex items-center gap-1 px-4 py-1 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 shadow-sm font-semibold">
                        <i data-lucide="eye" class="w-4 h-4"></i> Detail
                    </button>
                    <button class="flex items-center gap-1 px-4 py-1 text-xs rounded-xl bg-gradient-to-r from-blue-600 to-indigo-500 text-white hover:scale-105 shadow font-semibold">
                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FORM AGENDA (MODAL) -->
    <div id="agendaForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 text-blue-700">
                <i data-lucide="calendar-plus" class="w-7 h-7"></i>
                Tambah / Edit Agenda
            </h2>
            <form class="space-y-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Agenda</label>
                    <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Judul agenda">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Jenis Agenda</label>
                        <select class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                            <option>Akademik</option>
                            <option>Non-Akademik</option>
                            <option>Rapat</option>
                            <option>Ujian</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Lokasi</label>
                        <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Ruang / lokasi">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Waktu</label>
                        <input class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="08:00 - 12:00">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm">
                            <option>Akan Datang</option>
                            <option>Selesai</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Keterangan</label>
                    <textarea rows="3" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm" placeholder="Catatan agenda..."></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" onclick="toggleAgendaForm()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-7 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl font-bold shadow-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function toggleAgendaForm() {
    const form = document.getElementById('agendaForm');
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
