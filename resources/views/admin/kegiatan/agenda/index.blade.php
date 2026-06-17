@extends('layouts.admin')

@section('title', 'Agenda Sekolah')

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
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 shadow-lg">
                    <i data-lucide="calendar-days" class="w-7 h-7 text-white"></i>
                </span>
                Agenda Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola jadwal dan agenda kegiatan sekolah dengan tampilan modern</p>
        </div>
        <button onclick="addAgenda()"
            class="flex items-center gap-2 px-7 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Agenda
        </button>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.kegiatan.agenda.index') }}" class="flex flex-wrap gap-4 items-center mb-4">
        <select name="jenis" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[140px] text-base appearance-none">
            <option value="">Semua Jenis</option>
            <option value="Akademik" {{ request('jenis') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
            <option value="Non-Akademik" {{ request('jenis') == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
            <option value="Rapat" {{ request('jenis') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
            <option value="Ujian" {{ request('jenis') == 'Ujian' ? 'selected' : '' }}>Ujian</option>
        </select>
        <select name="status" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
            <option value="">Semua Status</option>
            <option value="Akan Datang" {{ request('status') == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        @if(request('jenis') || request('status'))
            <a href="{{ route('admin.kegiatan.agenda.index') }}" class="text-sm text-red-500 hover:underline flex items-center gap-1">
                <i data-lucide="x" class="w-4 h-4"></i> Reset Filter
            </a>
        @endif
    </form>

    <!-- AGENDA CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($agenda as $a)
        <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 border border-blue-100 rounded-3xl shadow-xl p-7 flex flex-col justify-between hover:shadow-2xl transition group">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500/80">
                        <i data-lucide="calendar-event" class="w-5 h-5 text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-blue-600">{{ $a->judul }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $a->lokasi }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="clock" class="w-4 h-4"></i> {{ $a->waktu_pelaksanaan }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="tag" class="w-4 h-4"></i> {{ $a->jenis }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="calendar" class="w-4 h-4"></i> {{ \Carbon\Carbon::parse($a->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="mb-4 text-gray-700 text-base leading-relaxed line-clamp-3">{{ $a->deskripsi }}</div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide shadow-sm
                    @if($a->status === 'Akan Datang') bg-gradient-to-r from-blue-400 to-blue-600 text-white @else bg-gradient-to-r from-gray-300 to-gray-500 text-gray-800 @endif">
                    {{ $a->status }}
                </span>
                <div class="flex gap-2">
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 shadow-sm font-semibold" type="button" onclick='showAgendaDetail(@json($a))'>
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-gradient-to-r from-blue-600 to-indigo-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='editAgenda(@json($a))'>
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-red-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='deleteAgenda({{ $a->id }})'>
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="calendar-days" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada agenda sekolah</span>
        </div>
        @endforelse
    </div>

    <!-- FORM AGENDA (MODAL) -->
    <div id="agendaForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 id="formTitle" class="text-2xl font-bold mb-8 flex items-center gap-3 text-blue-700">
                <i data-lucide="calendar-plus" class="w-7 h-7"></i>
                Tambah / Edit Agenda
            </h2>
            <form id="realAgendaForm" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Agenda</label>
                    <input name="judul" id="inputJudul" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Judul agenda" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Jenis Agenda</label>
                        <select name="jenis" id="inputJenis" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                            <option value="Akademik">Akademik</option>
                            <option value="Non-Akademik">Non-Akademik</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Ujian">Ujian</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Lokasi</label>
                        <input name="lokasi" id="inputLokasi" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Ruang / lokasi" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="inputTanggal" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Waktu</label>
                        <input name="waktu" id="inputWaktu" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="e.g. 08:00 - 12:00" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select name="status" id="inputStatus" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                            <option value="Akan Datang">Akan Datang</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Keterangan</label>
                    <textarea name="keterangan" id="inputKeterangan" rows="3" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Catatan agenda..."></textarea>
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

    <!-- MODAL DETAIL AGENDA -->
    <div id="agendaDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-lg animate-fadeIn">
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                    <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
                </span>
                <span id="detailJudul" class="text-2xl font-bold text-gray-800"></span>
            </div>
            <div class="mb-4 text-gray-700 text-base leading-relaxed whitespace-pre-wrap" id="detailKeterangan"></div>
            <div class="mb-2 text-sm text-gray-600 flex flex-col gap-2">
                <span><i data-lucide="tag" class="w-4 h-4 inline mr-1"></i> Jenis: <span id="detailJenis" class="font-semibold"></span></span>
                <span><i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i> Lokasi: <span id="detailLokasi"></span></span>
                <span><i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i> Tanggal: <span id="detailTanggal"></span></span>
                <span><i data-lucide="clock" class="w-4 h-4 inline mr-1"></i> Waktu: <span id="detailWaktu"></span></span>
            </div>
            <div class="mb-2 text-sm text-gray-600 flex gap-4 mt-2">
                <span>Status: <span id="detailStatus" class="font-bold"></span></span>
            </div>
            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeAgendaDetail()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Deletion -->
    <form id="delete-agenda-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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

function addAgenda() {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="calendar-plus" class="w-7 h-7"></i> Tambah Agenda';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('realAgendaForm').action = "{{ route('admin.kegiatan.agenda.store') }}";
    
    // Clear fields
    document.getElementById('inputJudul').value = '';
    document.getElementById('inputJenis').value = 'Akademik';
    document.getElementById('inputLokasi').value = '';
    document.getElementById('inputTanggal').value = '';
    document.getElementById('inputWaktu').value = '';
    document.getElementById('inputStatus').value = 'Akan Datang';
    document.getElementById('inputKeterangan').value = '';

    toggleAgendaForm();
    if(window.lucide) lucide.createIcons();
}

function editAgenda(data) {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="calendar-plus" class="w-7 h-7"></i> Edit Agenda';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('realAgendaForm').action = "/admin/kegiatan/agenda/" + data.id;
    
    // Populate fields
    document.getElementById('inputJudul').value = data.judul || '';
    document.getElementById('inputJenis').value = data.jenis || 'Akademik';
    document.getElementById('inputLokasi').value = data.lokasi || '';
    document.getElementById('inputTanggal').value = data.tanggal_pelaksanaan || '';
    document.getElementById('inputWaktu').value = data.waktu_pelaksanaan || '';
    document.getElementById('inputStatus').value = data.status || 'Akan Datang';
    document.getElementById('inputKeterangan').value = data.deskripsi || '';

    toggleAgendaForm();
    if(window.lucide) lucide.createIcons();
}

function deleteAgenda(id) {
    if (confirm('Apakah Anda yakin ingin menghapus agenda ini?')) {
        const form = document.getElementById('delete-agenda-form');
        form.action = "/admin/kegiatan/agenda/" + id;
        form.submit();
    }
}

function showAgendaDetail(data) {
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailKeterangan').textContent = data.deskripsi || 'Tidak ada keterangan.';
    document.getElementById('detailJenis').textContent = data.jenis;
    document.getElementById('detailLokasi').textContent = data.lokasi;
    document.getElementById('detailTanggal').textContent = data.tanggal_pelaksanaan;
    document.getElementById('detailWaktu').textContent = data.waktu_pelaksanaan;
    document.getElementById('detailStatus').textContent = data.status;

    const modal = document.getElementById('agendaDetailModal');
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('opacity-100'), 10);
    if(window.lucide) lucide.createIcons();
}

function closeAgendaDetail() {
    const modal = document.getElementById('agendaDetailModal');
    modal.classList.remove('opacity-100');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
