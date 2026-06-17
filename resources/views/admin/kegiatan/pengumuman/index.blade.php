@extends('layouts.admin')

@section('title', 'Pengumuman Sekolah')

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
                    <i data-lucide="megaphone" class="w-7 h-7 text-white"></i>
                </span>
                Pengumuman Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola pengumuman resmi untuk siswa, guru, dan orang tua dengan tampilan modern</p>
        </div>
        <button onclick="addPengumuman()"
            class="flex items-center gap-2 px-7 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Pengumuman
        </button>
    </div>

    <!-- FILTER & SEARCH -->
    <form method="GET" action="{{ route('admin.kegiatan.pengumuman.index') }}" class="flex flex-wrap gap-4 items-center mb-4">
        <select name="target" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[140px] text-base appearance-none">
            <option value="">Semua Target</option>
            <option value="Siswa" {{ request('target') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="Guru" {{ request('target') == 'Guru' ? 'selected' : '' }}>Guru</option>
            <option value="Orang Tua" {{ request('target') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
            <option value="Semua" {{ request('target') == 'Semua' ? 'selected' : '' }}>Semua</option>
        </select>
        <select name="status" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
            <option value="">Semua Status</option>
            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Arsip" {{ request('status') == 'Arsip' ? 'selected' : '' }}>Arsip</option>
        </select>
        <div class="relative flex-1 min-w-[220px] max-w-xs">
            <input type="text" name="q" value="{{ request('q') }}" class="input pl-10 bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 px-4 py-2 w-full text-base" placeholder="Cari pengumuman...">
            <span class="absolute left-3 top-2.5 text-blue-400"><i data-lucide="search" class="w-5 h-5"></i></span>
        </div>
        @if(request('target') || request('status') || request('q'))
            <a href="{{ route('admin.kegiatan.pengumuman.index') }}" class="text-sm text-red-500 hover:underline flex items-center gap-1">
                <i data-lucide="x" class="w-4 h-4"></i> Reset Filter
            </a>
        @endif
    </form>

    <!-- ANNOUNCEMENT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($pengumuman as $p)
        <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 border border-blue-100 rounded-3xl shadow-xl p-7 flex flex-col justify-between hover:shadow-2xl transition group">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500/80">
                        <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
                    </span>
                    <span class="text-xl font-bold text-gray-800 group-hover:text-blue-600">{{ $p->judul }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> {{ $p->jenis }}</span>
                    <span class="inline-flex items-center gap-1 ml-4"><i data-lucide="calendar" class="w-4 h-4"></i> {{ \Carbon\Carbon::parse($p->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="mb-4 text-gray-700 text-base leading-relaxed line-clamp-4">{{ $p->deskripsi }}</div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide shadow-sm
                    @if($p->status === 'Aktif') bg-gradient-to-r from-green-400 to-green-600 text-white @else bg-gradient-to-r from-gray-300 to-gray-500 text-gray-800 @endif">
                    {{ $p->status }}
                </span>
                <div class="flex gap-2">
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 shadow-sm font-semibold" type="button" onclick='showPengumumanDetail(@json($p))'>
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-gradient-to-r from-blue-600 to-indigo-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='editPengumuman(@json($p))'>
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 px-3 py-1 text-xs rounded-xl bg-red-500 text-white hover:scale-105 shadow font-semibold" type="button" onclick='deletePengumuman({{ $p->id }})'>
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="megaphone" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada pengumuman sekolah</span>
        </div>
        @endforelse
    </div>

    <!-- FORM TAMBAH / EDIT (MODAL) -->
    <div id="formPengumuman" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 id="formTitle" class="text-2xl font-bold mb-8 flex items-center gap-3 text-blue-700">
                <i data-lucide="megaphone" class="w-7 h-7"></i>
                Tambah / Edit Pengumuman
            </h2>
            <form id="realPengumumanForm" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Pengumuman</label>
                    <input name="judul" id="inputJudul" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Judul pengumuman" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Target Pengumuman</label>
                    <select name="target" id="inputTarget" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                        <option value="Semua">Semua</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Guru">Guru</option>
                        <option value="Orang Tua">Orang Tua</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Isi Pengumuman</label>
                    <textarea name="isi" id="inputIsi" rows="4" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Isi pengumuman..." required></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="inputTanggal" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <select name="status" id="inputStatus" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Arsip">Arsip</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" onclick="toggleForm()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-7 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl font-bold shadow-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL PENGUMUMAN -->
    <div id="pengumumanDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-lg animate-fadeIn">
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                    <i data-lucide="megaphone" class="w-6 h-6 text-white"></i>
                </span>
                <span id="detailJudul" class="text-2xl font-bold text-gray-800"></span>
            </div>
            <div class="mb-4 text-gray-700 text-base leading-relaxed whitespace-pre-wrap" id="detailIsi"></div>
            <div class="mb-2 text-sm text-gray-600 flex flex-col gap-2">
                <span>Target: <span id="detailTarget" class="font-bold"></span></span>
                <span>Tanggal: <span id="detailTanggal"></span></span>
            </div>
            <div class="mb-2 text-sm text-gray-600 flex gap-4 mt-2">
                <span>Status: <span id="detailStatus" class="font-bold"></span></span>
            </div>
            <div class="flex justify-end pt-6">
                <button type="button" onclick="closePengumumanDetail()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Deletion -->
    <form id="delete-pengumuman-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div>
@endsection

@push('scripts')
<script>
function toggleForm() {
    const form = document.getElementById('formPengumuman');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        setTimeout(() => form.classList.add('opacity-100'), 10);
    } else {
        form.classList.remove('opacity-100');
        setTimeout(() => form.classList.add('hidden'), 300);
    }
}

function addPengumuman() {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="megaphone" class="w-7 h-7"></i> Tambah Pengumuman';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('realPengumumanForm').action = "{{ route('admin.kegiatan.pengumuman.store') }}";
    
    // Clear fields
    document.getElementById('inputJudul').value = '';
    document.getElementById('inputTarget').value = 'Semua';
    document.getElementById('inputIsi').value = '';
    document.getElementById('inputTanggal').value = '';
    document.getElementById('inputStatus').value = 'Aktif';

    toggleForm();
    if(window.lucide) lucide.createIcons();
}

function editPengumuman(data) {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="megaphone" class="w-7 h-7"></i> Edit Pengumuman';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('realPengumumanForm').action = "/admin/kegiatan/pengumuman/" + data.id;
    
    // Populate fields
    document.getElementById('inputJudul').value = data.judul || '';
    document.getElementById('inputTarget').value = data.jenis || 'Semua';
    document.getElementById('inputIsi').value = data.deskripsi || '';
    document.getElementById('inputTanggal').value = data.tanggal_pelaksanaan || '';
    document.getElementById('inputStatus').value = data.status || 'Aktif';

    toggleForm();
    if(window.lucide) lucide.createIcons();
}

function deletePengumuman(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
        const form = document.getElementById('delete-pengumuman-form');
        form.action = "/admin/kegiatan/pengumuman/" + id;
        form.submit();
    }
}

function showPengumumanDetail(data) {
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailIsi').textContent = data.deskripsi;
    document.getElementById('detailTarget').textContent = data.jenis;
    document.getElementById('detailTanggal').textContent = data.tanggal_pelaksanaan;
    document.getElementById('detailStatus').textContent = data.status;

    const modal = document.getElementById('pengumumanDetailModal');
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('opacity-100'), 10);
    if(window.lucide) lucide.createIcons();
}

function closePengumumanDetail() {
    const modal = document.getElementById('pengumumanDetailModal');
    modal.classList.remove('opacity-100');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
