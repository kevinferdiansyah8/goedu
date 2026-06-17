@extends('layouts.admin')

@section('title', 'Event Sekolah')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-2xl shadow-sm flex items-center gap-3">
        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-500"></i>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-2xl shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i data-lucide="alert-circle" class="w-6 h-6 text-red-500"></i>
            <span class="font-bold">Ada kesalahan penginputan:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
        <button onclick="addEvent()"
            class="flex items-center gap-2 px-7 py-3 bg-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Event
        </button>
    </div>

    <!-- TABEL EVENT (CARD) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $e)
        <div class="bg-white border border-blue-100 rounded-3xl shadow-xl p-7 flex flex-col justify-between hover:shadow-2xl transition group">
            <div>
                @if($e->gambar_attachment)
                    <div class="w-full h-48 rounded-2xl overflow-hidden mb-4 bg-gray-100">
                        <img src="{{ asset('storage/' . $e->gambar_attachment) }}" alt="{{ $e->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                @else
                    <div class="w-full h-48 rounded-2xl overflow-hidden mb-4 bg-blue-50 flex items-center justify-center text-blue-300">
                        <i data-lucide="image" class="w-16 h-16"></i>
                    </div>
                @endif

                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                        <i data-lucide="calendar-event" class="w-5 h-5 text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-blue-600">{{ $e->judul }}</span>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $e->lokasi }}</span>
                    <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="w-4 h-4"></i> 
                        {{ \Carbon\Carbon::parse($e->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                        @if($e->waktu_pelaksanaan && $e->waktu_pelaksanaan !== $e->tanggal_pelaksanaan)
                            <span class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($e->waktu_pelaksanaan)->translatedFormat('d F Y') }}</span>
                        @endif
                    </span>
                </div>
                <div class="mb-4 text-gray-700 text-base leading-relaxed line-clamp-3">{{ $e->deskripsi }}</div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide shadow-sm
                    @if($e->status === 'Dipublikasikan') bg-blue-500 text-white @else bg-gray-300 text-gray-800 @endif">
                    {{ $e->status }}
                </span>
                <div class="flex gap-2">
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 shadow-sm font-semibold" type="button" onclick='showEventDetail(@json($e))'>
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-blue-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='editEvent(@json($e))'>
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-red-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='deleteEvent({{ $e->id }})'>
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="calendar" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada event sekolah</span>
        </div>
        @endforelse
    </div>

    <!-- FORM EVENT (MODAL) -->
    <div id="eventForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-pink-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 id="formTitle" class="text-2xl font-bold mb-8 flex items-center gap-3 text-pink-700">
                <i data-lucide="calendar-heart" class="w-7 h-7"></i>
                Tambah / Edit Event
            </h2>
            <form id="realEventForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Event</label>
                    <input name="judul" id="inputJudul" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Nama event" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Deskripsi Event</label>
                    <textarea name="deskripsi" id="inputDeskripsi" rows="3" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Deskripsi lengkap event" required></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="inputTanggalMulai" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="inputTanggalSelesai" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Lokasi</label>
                        <input name="lokasi" id="inputLokasi" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Lokasi event" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select name="status" id="inputStatus" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                            <option value="Draft">Draft</option>
                            <option value="Dipublikasikan">Dipublikasikan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Poster / Banner <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="file" name="banner" id="inputBanner" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border">
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
            <div id="detailBannerContainer" class="w-full h-48 rounded-2xl overflow-hidden mb-6 bg-gray-100 hidden">
                <img id="detailBanner" src="" alt="Banner" class="w-full h-full object-cover">
            </div>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                    <i data-lucide="calendar-event" class="w-6 h-6 text-white"></i>
                </span>
                <span id="detailJudul" class="text-2xl font-bold text-gray-800"></span>
            </div>
            <div class="mb-4 text-gray-700 text-base leading-relaxed whitespace-pre-wrap" id="detailDeskripsi"></div>
            <div class="mb-2 text-sm text-gray-600 flex flex-col gap-2">
                <span><i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i> <span id="detailLokasi"></span></span>
                <span><i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i> <span id="detailTanggal"></span></span>
            </div>
            <div class="mb-2 text-sm text-gray-600 flex gap-4 mt-2">
                <span>Status: <span id="detailStatus" class="font-bold"></span></span>
            </div>
            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeEventDetail()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Deletion -->
    <form id="delete-event-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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

function addEvent() {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="calendar-heart" class="w-7 h-7"></i> Tambah Event';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('realEventForm').action = "{{ route('admin.kegiatan.event.store') }}";
    
    // Clear fields
    document.getElementById('inputJudul').value = '';
    document.getElementById('inputDeskripsi').value = '';
    document.getElementById('inputTanggalMulai').value = '';
    document.getElementById('inputTanggalSelesai').value = '';
    document.getElementById('inputLokasi').value = '';
    document.getElementById('inputStatus').value = 'Draft';
    document.getElementById('inputBanner').value = '';
    document.getElementById('inputBanner').required = true;

    toggleEventForm();
    if(window.lucide) lucide.createIcons();
}

function editEvent(data) {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="calendar-heart" class="w-7 h-7"></i> Edit Event';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('realEventForm').action = "/admin/kegiatan/event/" + data.id;
    
    // Populate fields
    document.getElementById('inputJudul').value = data.judul || '';
    document.getElementById('inputDeskripsi').value = data.deskripsi || '';
    document.getElementById('inputTanggalMulai').value = data.tanggal_pelaksanaan || '';
    document.getElementById('inputTanggalSelesai').value = data.waktu_pelaksanaan || '';
    document.getElementById('inputLokasi').value = data.lokasi || '';
    document.getElementById('inputStatus').value = data.status || 'Draft';
    document.getElementById('inputBanner').value = '';
    document.getElementById('inputBanner').required = false;

    toggleEventForm();
    if(window.lucide) lucide.createIcons();
}

function deleteEvent(id) {
    if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
        const form = document.getElementById('delete-event-form');
        form.action = "/admin/kegiatan/event/" + id;
        form.submit();
    }
}

function showEventDetail(data) {
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailDeskripsi').textContent = data.deskripsi;
    document.getElementById('detailLokasi').textContent = data.lokasi;
    
    let tanggal = data.tanggal_pelaksanaan;
    if(data.waktu_pelaksanaan && data.waktu_pelaksanaan !== data.tanggal_pelaksanaan) {
        tanggal += ' s/d ' + data.waktu_pelaksanaan;
    }
    document.getElementById('detailTanggal').textContent = tanggal;
    document.getElementById('detailStatus').textContent = data.status;

    const bannerContainer = document.getElementById('detailBannerContainer');
    const bannerImg = document.getElementById('detailBanner');
    if (data.gambar_attachment) {
        bannerImg.src = "/storage/" + data.gambar_attachment;
        bannerContainer.classList.remove('hidden');
    } else {
        bannerImg.src = "";
        bannerContainer.classList.add('hidden');
    }

    const modal = document.getElementById('eventDetailModal');
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('opacity-100'), 10);
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
