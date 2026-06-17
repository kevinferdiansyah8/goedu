@extends('layouts.admin')

@section('title', 'Dokumentasi Sekolah')

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
                    <i data-lucide="images" class="w-7 h-7 text-white"></i>
                </span>
                Dokumentasi Sekolah
            </h1>
            <p class="text-gray-400 mt-2 text-lg">Kelola galeri foto kegiatan sekolah dengan tampilan modern</p>
        </div>
        <button onclick="addDokumentasi()"
            class="flex items-center gap-2 px-7 py-3 bg-blue-500 text-white rounded-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-transform duration-200">
            <i data-lucide="plus" class="w-6 h-6"></i>
            Tambah Dokumentasi
        </button>
    </div>

    <!-- GRID GALERI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($dokumentasi as $d)
        <div class="bg-white border border-blue-100 rounded-3xl shadow-xl hover:shadow-2xl transition overflow-hidden flex flex-col group">
            @if($d->gambar_attachment)
                <img src="{{ asset('storage/' . $d->gambar_attachment) }}" alt="{{ $d->judul }}"
                    class="w-full h-52 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-52 bg-blue-50 flex items-center justify-center text-blue-300">
                    <i data-lucide="image" class="w-16 h-16"></i>
                </div>
            @endif
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <div class="text-xs text-gray-400 mb-1">{{ \Carbon\Carbon::parse($d->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</div>
                    <h3 class="font-bold text-blue-700 text-lg mb-2 line-clamp-2">{{ $d->judul }}</h3>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            {{ $d->jenis }}
                        </span>
                        <span class="text-gray-500 text-xs">
                            {{ $d->waktu_pelaksanaan }} foto
                        </span>
                    </div>
                </div>
                <div class="flex gap-2 pt-3">
                    <button class="flex-1 px-3 py-2 text-xs rounded-xl bg-white border border-blue-200 hover:bg-blue-50 text-blue-600 font-bold shadow-sm" type="button" onclick='showDokumentasiDetail(@json($d))'>
                        <i data-lucide="eye" class="w-4 h-4 inline mr-1"></i> Lihat
                    </button>
                    <button class="flex-1 px-3 py-2 text-xs rounded-xl bg-blue-500 text-white font-bold shadow hover:scale-105 transition" type="button" onclick='editDokumentasi(@json($d))'>
                        <i data-lucide="edit" class="w-4 h-4 inline mr-1"></i> Edit
                    </button>
                    <button class="px-3 py-2 text-xs rounded-xl bg-red-500 text-white font-bold shadow hover:scale-105 transition" type="button" onclick='deleteDokumentasi({{ $d->id }})'>
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
            <i data-lucide="images" class="w-16 h-16 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada dokumentasi sekolah</span>
        </div>
        @endforelse
    </div>

    <!-- FORM TAMBAH/EDIT DOKUMENTASI (MODAL) -->
    <div id="formDokumentasi" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-xl animate-fadeIn">
            <h2 id="formTitle" class="text-2xl font-bold mb-8 flex items-center gap-3 text-blue-700">
                <i data-lucide="image-plus" class="w-7 h-7"></i>
                Tambah Dokumentasi
            </h2>
            <form id="realDokumentasiForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Judul Dokumentasi</label>
                    <input name="judul" id="inputJudul" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" placeholder="Contoh: Pentas Seni Akhir Tahun" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Kategori</label>
                        <select name="kategori" id="inputKategori" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                            <option value="Event">Event</option>
                            <option value="Agenda">Agenda</option>
                            <option value="Rutin">Rutin</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="inputTanggal" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border" required>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Upload Foto <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="file" name="foto" id="inputFoto" class="input bg-gray-100 border-gray-300 rounded-xl shadow-sm w-full p-2 border">
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

    <!-- MODAL DETAIL DOKUMENTASI -->
    <div id="dokumentasiDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden transition-opacity duration-300">
        <div class="bg-white border border-blue-200 rounded-3xl shadow-2xl p-10 w-full max-w-lg animate-fadeIn">
            <div class="w-full h-64 rounded-2xl overflow-hidden mb-6 bg-gray-100">
                <img id="detailFoto" src="" alt="Dokumentasi" class="w-full h-full object-cover">
            </div>
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                    <i data-lucide="image" class="w-6 h-6 text-white"></i>
                </span>
                <span id="detailJudul" class="text-2xl font-bold text-gray-800"></span>
            </div>
            <div class="text-sm text-gray-600 flex flex-col gap-2 mb-4">
                <span>Kategori: <span id="detailKategori" class="font-bold"></span></span>
                <span>Tanggal: <span id="detailTanggal"></span></span>
                <span>Jumlah Foto (Mock): <span id="detailJumlahFoto"></span></span>
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" onclick="closeDokumentasiDetail()" class="px-7 py-2 border border-gray-300 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-100">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Deletion -->
    <form id="delete-dokumentasi-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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

function addDokumentasi() {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="image-plus" class="w-7 h-7"></i> Tambah Dokumentasi';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('realDokumentasiForm').action = "{{ route('admin.kegiatan.dokumentasi.store') }}";
    
    // Clear fields
    document.getElementById('inputJudul').value = '';
    document.getElementById('inputKategori').value = 'Event';
    document.getElementById('inputTanggal').value = '';
    document.getElementById('inputFoto').value = '';
    document.getElementById('inputFoto').required = true;

    toggleDokumentasiForm();
    if(window.lucide) lucide.createIcons();
}

function editDokumentasi(data) {
    document.getElementById('formTitle').innerHTML = '<i data-lucide="image-plus" class="w-7 h-7"></i> Edit Dokumentasi';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('realDokumentasiForm').action = "/admin/kegiatan/dokumentasi/" + data.id;
    
    // Populate fields
    document.getElementById('inputJudul').value = data.judul || '';
    document.getElementById('inputKategori').value = data.jenis || 'Event';
    document.getElementById('inputTanggal').value = data.tanggal_pelaksanaan || '';
    document.getElementById('inputFoto').value = '';
    document.getElementById('inputFoto').required = false;

    toggleDokumentasiForm();
    if(window.lucide) lucide.createIcons();
}

function deleteDokumentasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')) {
        const form = document.getElementById('delete-dokumentasi-form');
        form.action = "/admin/kegiatan/dokumentasi/" + id;
        form.submit();
    }
}

function showDokumentasiDetail(data) {
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailKategori').textContent = data.jenis;
    document.getElementById('detailTanggal').textContent = data.tanggal_pelaksanaan;
    document.getElementById('detailJumlahFoto').textContent = data.waktu_pelaksanaan + ' foto';
    
    const foto = document.getElementById('detailFoto');
    if (data.gambar_attachment) {
        foto.src = "/storage/" + data.gambar_attachment;
    } else {
        foto.src = "";
    }

    const modal = document.getElementById('dokumentasiDetailModal');
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('opacity-100'), 10);
    if(window.lucide) lucide.createIcons();
}

function closeDokumentasiDetail() {
    const modal = document.getElementById('dokumentasiDetailModal');
    modal.classList.remove('opacity-100');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
