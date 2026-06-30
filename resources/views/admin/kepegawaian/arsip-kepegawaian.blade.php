@extends('layouts.admin')

@section('title', 'Arsip Kepegawaian')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Arsip Kepegawaian</h1>
            <p class="text-lg text-gray-400">Kelola dokumen dan riwayat kepegawaian guru & staff</p>
        </div>
    </div>

    <!-- Filter -->
    <form class="flex gap-3 mb-6" method="GET" action="{{ route('admin.kepegawaian.arsip-kepegawaian') }}">
        <select name="tipe" class="input border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400" onchange="this.form.submit()">
            <option value="Semua Tipe" {{ request('tipe') == 'Semua Tipe' ? 'selected' : '' }}>Semua Tipe</option>
            <option value="Guru" {{ request('tipe') == 'Guru' ? 'selected' : '' }}>Guru</option>
            <option value="Staff" {{ request('tipe') == 'Staff' ? 'selected' : '' }}>Staff</option>
        </select>
        <select name="status" class="input border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400" onchange="this.form.submit()">
            <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </form>

    <!-- Table -->
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2 mb-10">
        <table class="w-full text-base">
            <thead class="bg-slate-100 text-blue-900">
                <tr>
                    <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
                    <th class="px-5 py-3 font-bold">Jabatan</th>
                    <th class="px-5 py-3 font-bold text-center">Tipe</th>
                    <th class="px-5 py-3 font-bold text-center">Status</th>
                    <th class="px-5 py-3 font-bold text-center">Dokumen</th>
                    <th class="px-5 py-3 font-bold text-center rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawai as $p)
                <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
                    <td class="px-5 py-3 flex items-center gap-3">
                        <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>
                            {{ collect(explode(' ', $p->nama))->map(fn($n)=>$n[0])->take(2)->join('') }}
                        </span>
                        <div>
                            <div class="font-medium text-gray-800">{{ $p->nama }}</div>
                            <div class="text-xs text-gray-500">NIP: {{ $p->nip ?? '-' }}</div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">{{ $p->jabatan ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $p->tipe }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow {{ $p->status=='Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            <i class="fa fa-circle mr-1 {{ $p->status=='Aktif' ? 'text-green-500' : 'text-gray-400' }}"></i>
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-flex items-center gap-1 font-semibold text-blue-700"><i class="fa fa-file-alt"></i> {{ count($p->documents) }} File</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <button onclick='openDetail(@json($p))'
                            class="btn-detail flex items-center gap-1 mx-auto"><i class="fa fa-folder-open"></i> Detail Arsip</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- DETAIL PANEL -->
    <div id="detailPanel" class="hidden animate-fade-in max-w-4xl mx-auto bg-white/95 rounded-2xl shadow-2xl p-8 relative z-10 mb-10">
        
        <!-- Header Panel -->
        <div class="flex items-center gap-4 mb-6 relative">
            <button onclick="document.getElementById('detailPanel').classList.add('hidden')" class="absolute top-0 right-0 text-gray-400 hover:text-red-500">
                <i class="fa fa-times text-xl"></i>
            </button>
            <span id="d-avatar" class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-extrabold flex items-center justify-center text-2xl shadow"></span>
            <div>
                <h2 class="text-2xl font-bold mb-1 text-blue-700">Detail Arsip Kepegawaian</h2>
                <span id="d-jabatan-badge" class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"></span>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-2 mb-6 border-b pb-2">
            <button class="tab-btn active" onclick="showTab('profil', event)"><i class="fa fa-user"></i> Profil</button>
            <button class="tab-btn" onclick="showTab('dokumen', event)"><i class="fa fa-file-alt"></i> Dokumen</button>
            <button class="tab-btn" onclick="showTab('riwayat', event)"><i class="fa fa-history"></i> Riwayat</button>
            <button class="tab-btn" onclick="showTab('sertifikasi', event)"><i class="fa fa-certificate"></i> Sertifikasi</button>
        </div>

        <!-- Profil -->
        <div id="tab-profil" class="tab-content">
            <form id="formProfil" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                        <input type="text" id="p-nama" class="input w-full bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">NIP</label>
                        <input type="text" id="p-nip" class="input w-full bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" id="p-jabatan" name="jabatan" class="input w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                        <input type="text" id="p-pendidikan" name="pendidikan" class="input w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tipe Pegawai</label>
                        <select name="tipe" id="p-tipe" class="input w-full" required>
                            <option value="Guru">Guru</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Status</label>
                        <select name="status" id="p-status" class="input w-full" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 font-bold">Simpan Profil</button>
                </div>
            </form>
        </div>

        <!-- Dokumen -->
        <div id="tab-dokumen" class="tab-content hidden">
            <div id="d-dokumen-list" class="space-y-3 mb-8"></div>
            
            <hr class="mb-6 border-dashed">
            
            <form id="formDokumen" method="POST" action="" enctype="multipart/form-data" class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 shadow-inner">
                @csrf
                <h3 class="font-bold text-blue-800 mb-3"><i class="fa fa-upload"></i> Upload Dokumen Baru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Dokumen (Contoh: Ijazah S1)</label>
                        <input type="text" name="nama_dokumen" class="input w-full" required>
                    </div>
                    <div class="flex gap-2 items-center">
                        <label class="flex-1 input border border-blue-200 bg-white cursor-pointer flex items-center justify-between text-sm text-gray-500">
                            <span id="fileName">Pilih File PDF/Gambar (Max 5MB)</span>
                            <input type="file" name="file" class="hidden" id="uploadInput" accept=".pdf,.jpg,.jpeg,.png" required onchange="showFileName()">
                        </label>
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition-all font-bold">Upload</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Riwayat -->
        <div id="tab-riwayat" class="tab-content hidden">
            <div id="d-riwayat-list" class="space-y-3 mb-8"></div>

            <hr class="mb-6 border-dashed">

            <form id="formRiwayat" method="POST" action="" class="bg-gray-50 border border-gray-200 rounded-xl p-5 shadow-inner">
                @csrf
                <h3 class="font-bold text-gray-800 mb-3"><i class="fa fa-plus-circle"></i> Tambah Riwayat Jabatan</h3>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold mb-1">Jabatan (Contoh: Wali Kelas 7 A)</label>
                        <input type="text" name="jabatan" class="input w-full" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold mb-1">Tahun (Contoh: 2021 - Sekarang)</label>
                        <input type="text" name="tahun" class="input w-full" required>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-gray-800 text-white rounded-xl shadow hover:bg-black transition-all font-bold">Tambah</button>
                </div>
            </form>
        </div>

        <!-- Sertifikasi -->
        <div id="tab-sertifikasi" class="tab-content hidden">
            <div id="d-sertifikasi-list" class="space-y-3 mb-8"></div>

            <hr class="mb-6 border-dashed">

            <form id="formSertifikasi" method="POST" action="" class="bg-yellow-50/50 border border-yellow-200 rounded-xl p-5 shadow-inner">
                @csrf
                <h3 class="font-bold text-yellow-800 mb-3"><i class="fa fa-plus-circle"></i> Tambah Sertifikasi/Pelatihan</h3>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold mb-1">Nama Sertifikasi / Diklat</label>
                        <input type="text" name="nama_sertifikasi" class="input w-full" required>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-yellow-600 text-white rounded-xl shadow hover:bg-yellow-700 transition-all font-bold">Tambah</button>
                </div>
            </form>
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
<style>
.input {
    padding: 0.75rem 1.25rem;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    font-size: 1rem;
    background: #ffffff;
    transition: box-shadow .15s;
}
.input:focus {
    outline: none;
    box-shadow: 0 0 0 2px #2563eb44;
}
.btn-detail {
    background:#2563eb;
    color:white;
    padding:8px 20px;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
    box-shadow:0 2px 8px #2563eb22;
    transition:all .15s;
    display:inline-flex;
    align-items:center;
    gap:8px;
}
.btn-detail:hover { background:#1746a2; box-shadow:0 4px 16px #2563eb33; transform:scale(1.05); }
.tab-btn {
    padding: 0.6rem 1.5rem;
    border-radius: 0.75rem;
    border: 1px solid transparent;
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
    background: transparent;
    transition: all .2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.tab-btn.active {
    background: #eff6ff;
    color: #2563eb;
}
.tab-btn:hover:not(.active) {
    background: #f1f5f9;
    color: #334155;
}
.tab-content {
    transition: opacity .2s;
}
.animate-fade-in {
    animation: fadeIn .4s;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function openDetail(p) {
    document.getElementById('detailPanel').classList.remove('hidden');
    
    // Header
    const inisial = p.nama.split(' ').map(n=>n[0]).join('').substring(0,2);
    document.getElementById('d-avatar').innerText = inisial;
    document.getElementById('d-jabatan-badge').innerText = p.jabatan || 'Belum diatur';
    
    // Set Forms Action URL
    document.getElementById('formProfil').action = `/admin/kepegawaian/arsip/${p.id}/profil`;
    document.getElementById('formDokumen').action = `/admin/kepegawaian/arsip/${p.id}/dokumen`;
    document.getElementById('formRiwayat').action = `/admin/kepegawaian/arsip/${p.id}/riwayat`;
    document.getElementById('formSertifikasi').action = `/admin/kepegawaian/arsip/${p.id}/sertifikasi`;

    // Fill Profil Form
    document.getElementById('p-nama').value = p.nama;
    document.getElementById('p-nip').value = p.nip || '';
    document.getElementById('p-jabatan').value = p.jabatan || '';
    document.getElementById('p-pendidikan').value = p.pendidikan || '';
    document.getElementById('p-tipe').value = p.tipe;
    document.getElementById('p-status').value = p.status;

    // Render Dokumen List
    let docHtml = p.documents.length ? '' : '<div class="text-gray-400 italic">Belum ada dokumen</div>';
    p.documents.forEach(d => {
        docHtml += `
            <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-blue-100 text-blue-600 flex items-center justify-center"><i class="fa fa-file-pdf"></i></div>
                    <div>
                        <div class="font-bold text-gray-800">${d.nama_dokumen}</div>
                        <a href="/storage/${d.file_path}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat / Download</a>
                    </div>
                </div>
                <form action="/admin/kepegawaian/arsip/dokumen/${d.id}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        `;
    });
    document.getElementById('d-dokumen-list').innerHTML = docHtml;

    // Render Riwayat List
    let riwHtml = p.histories.length ? '' : '<div class="text-gray-400 italic">Belum ada riwayat</div>';
    p.histories.forEach(h => {
        riwHtml += `
            <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fa fa-briefcase"></i></div>
                    <div>
                        <div class="font-bold text-gray-800">${h.jabatan}</div>
                        <div class="text-xs text-gray-500">Tahun: ${h.tahun}</div>
                    </div>
                </div>
                <form action="/admin/kepegawaian/arsip/riwayat/${h.id}" method="POST" onsubmit="return confirm('Hapus riwayat ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        `;
    });
    document.getElementById('d-riwayat-list').innerHTML = riwHtml;

    // Render Sertifikasi List
    let serHtml = p.certifications.length ? '' : '<div class="text-gray-400 italic">Belum ada sertifikasi</div>';
    p.certifications.forEach(s => {
        serHtml += `
            <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center"><i class="fa fa-certificate"></i></div>
                    <div>
                        <div class="font-bold text-gray-800">${s.nama_sertifikasi}</div>
                    </div>
                </div>
                <form action="/admin/kepegawaian/arsip/sertifikasi/${s.id}" method="POST" onsubmit="return confirm('Hapus sertifikasi ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        `;
    });
    document.getElementById('d-sertifikasi-list').innerHTML = serHtml;

    // Scroll to detail
    document.getElementById('detailPanel').scrollIntoView({behavior: 'smooth', block: 'start'});

    showTab('profil');
    document.getElementById('fileName').innerText = 'Pilih File PDF/Gambar (Max 5MB)';
    document.getElementById('uploadInput').value = '';
}

function showTab(tab, e) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    if(e) e.target.classList.add('active');
    else document.querySelector('.tab-btn').classList.add('active');
}

function showFileName() {
    const input = document.getElementById('uploadInput');
    const fileName = input.files.length ? input.files[0].name : 'Pilih File PDF/Gambar (Max 5MB)';
    document.getElementById('fileName').innerText = fileName;
}
</script>
@endsection
