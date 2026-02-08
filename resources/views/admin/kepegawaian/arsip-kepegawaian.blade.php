@extends('layouts.admin')

@section('title', 'Arsip Kepegawaian')

@section('content')
@php
$pegawai = [
    [
        'id' => 1,
        'nama' => 'Budi Santoso, S.Pd',
        'jabatan' => 'Guru RPL',
        'status' => 'Aktif',
        'tipe' => 'Guru',
        'dokumen' => [
            ['nama' => 'SK Pengangkatan', 'file' => 'sk_pengangkatan.pdf'],
            ['nama' => 'SK Mengajar', 'file' => 'sk_mengajar.pdf'],
            ['nama' => 'Ijazah S1', 'file' => 'ijazah.pdf'],
        ],
        'pendidikan' => 'S1 Pendidikan Informatika',
        'sertifikasi' => ['Sertifikat Pendidik', 'Kurikulum Merdeka'],
        'riwayat' => [
            ['jabatan' => 'Guru RPL', 'tahun' => '2021 - Sekarang'],
            ['jabatan' => 'Wali Kelas', 'tahun' => '2023 - Sekarang'],
        ],
    ],
    [
        'id' => 2,
        'nama' => 'Siti Aminah',
        'jabatan' => 'Staff TU',
        'status' => 'Aktif',
        'tipe' => 'Staff',
        'dokumen' => [
            ['nama' => 'SK Pengangkatan', 'file' => 'sk_staff.pdf'],
            ['nama' => 'Kontrak Kerja', 'file' => 'kontrak.pdf'],
        ],
        'pendidikan' => 'D3 Administrasi',
        'sertifikasi' => [],
        'riwayat' => [
            ['jabatan' => 'Staff TU', 'tahun' => '2020 - Sekarang'],
        ],
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Arsip Kepegawaian</h1>
        <p class="text-lg text-gray-400">Kelola dokumen dan riwayat kepegawaian guru & staff</p>
    </div>

    <!-- Filter -->
    <div class="flex gap-3 mb-6">
        <select class="input border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
            <option>Semua Tipe</option>
            <option>Guru</option>
            <option>Staff</option>
        </select>
        <select class="input border rounded-xl px-5 py-2 text-base shadow-sm focus:ring-2 focus:ring-blue-400">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Nonaktif</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
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
                        <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $p['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                        <span class="font-medium text-gray-800">{{ $p['nama'] }}</span>
                    </td>
                    <td class="px-5 py-3">{{ $p['jabatan'] }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $p['tipe'] }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow {{ $p['status']=='Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            <i class="fa fa-circle mr-1 {{ $p['status']=='Aktif' ? 'text-green-500' : 'text-gray-400' }}"></i>
                            {{ $p['status'] }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-flex items-center gap-1 font-semibold text-blue-700"><i class="fa fa-file-alt"></i> {{ count($p['dokumen']) }} File</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <button onclick="openDetail({{ $p['id'] }})"
                            class="btn-detail flex items-center gap-1"><i class="fa fa-folder-open"></i> Detail Arsip</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- DETAIL PANEL -->
    <div id="detailPanel" class="hidden animate-fade-in mt-10 max-w-3xl mx-auto bg-white/95 rounded-2xl shadow-2xl p-8 relative z-10">
        <div class="flex items-center gap-4 mb-6">
            <span id="d-avatar" class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-extrabold flex items-center justify-center text-2xl shadow"></span>
            <div>
                <h2 class="text-2xl font-bold mb-1 text-blue-700">Detail Arsip Kepegawaian</h2>
                <span id="d-jabatan-badge" class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"></span>
            </div>
        </div>
        <!-- Tabs -->
        <div class="flex gap-2 mb-6">
            <button class="tab-btn active" onclick="showTab('profil', event)"><i class="fa fa-user"></i> Profil</button>
            <button class="tab-btn" onclick="showTab('dokumen', event)"><i class="fa fa-file-alt"></i> Dokumen</button>
            <button class="tab-btn" onclick="showTab('riwayat', event)"><i class="fa fa-history"></i> Riwayat</button>
            <button class="tab-btn" onclick="showTab('sertifikasi', event)"><i class="fa fa-certificate"></i> Sertifikasi</button>
        </div>
        <!-- Profil -->
        <div id="tab-profil" class="tab-content">
            <div class="space-y-2">
                <div><b>Nama:</b> <span id="d-nama"></span></div>
                <div><b>Jabatan:</b> <span id="d-jabatan"></span></div>
                <div><b>Pendidikan:</b> <span id="d-pendidikan"></span></div>
            </div>
        </div>
        <!-- Dokumen -->
        <div id="tab-dokumen" class="tab-content hidden">
            <ul id="d-dokumen" class="list-disc ml-5 mb-6"></ul>
            <!-- Upload Dokumen -->
            <form class="flex flex-col md:flex-row items-center gap-3 bg-blue-50 rounded-xl p-4 shadow-inner" onsubmit="event.preventDefault(); alert('Fitur upload hanya UI. Integrasi backend diperlukan.');">
                <label class="flex items-center gap-2 cursor-pointer">
                    <i class="fa fa-upload text-blue-700"></i>
                    <span class="font-semibold text-blue-700">Upload Dokumen Baru</span>
                    <input type="file" class="hidden" id="uploadInput" onchange="showFileName()">
                </label>
                <span id="fileName" class="text-gray-600 text-sm"></span>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 hover:scale-105 transition-all">Upload</button>
            </form>
        </div>
        <!-- Riwayat -->
        <div id="tab-riwayat" class="tab-content hidden">
            <ul id="d-riwayat" class="list-disc ml-5"></ul>
        </div>
        <!-- Sertifikasi -->
        <div id="tab-sertifikasi" class="tab-content hidden">
            <ul id="d-sertifikasi" class="list-disc ml-5"></ul>
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
    background: #f8fafc;
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
    border: 1px solid #e5e7eb;
    font-size: 1rem;
    font-weight: 600;
    color: #2563eb;
    background: #f8fafc;
    transition: background .15s, color .15s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.tab-btn.active, .tab-btn:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
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
const data = @json($pegawai);
function openDetail(id) {
    const p = data.find(x => x.id === id);
    document.getElementById('detailPanel').classList.remove('hidden');
    // Avatar inisial
    const inisial = p.nama.split(' ').map(n=>n[0]).join('');
    document.getElementById('d-avatar').innerText = inisial;
    // Badge jabatan
    document.getElementById('d-jabatan-badge').innerText = p.jabatan;
    // Profil
    document.getElementById('d-nama').innerText = p.nama;
    document.getElementById('d-jabatan').innerText = p.jabatan;
    document.getElementById('d-pendidikan').innerText = p.pendidikan;
    // Dokumen (bisa diunduh)
    document.getElementById('d-dokumen').innerHTML =
        p.dokumen.length ? p.dokumen.map(d => `<li><a href="/arsip/${d.file}" class='text-blue-700 hover:underline flex items-center gap-2' download><i class='fa fa-download'></i> ${d.nama}</a></li>`).join('') : '<li>-</li>';
    // Riwayat
    document.getElementById('d-riwayat').innerHTML =
        p.riwayat.length ? p.riwayat.map(r => `<li><i class='fa fa-briefcase text-blue-400'></i> ${r.jabatan} <span class='text-gray-500'>(${r.tahun})</span></li>`).join('') : '<li>-</li>';
    // Sertifikasi
    document.getElementById('d-sertifikasi').innerHTML =
        p.sertifikasi.length
            ? p.sertifikasi.map(s => `<li><i class='fa fa-certificate text-yellow-500'></i> ${s}</li>`).join('')
            : '<li>-</li>';
    // Reset tab ke profil
    showTab('profil');
    // Reset file upload preview
    document.getElementById('fileName').innerText = '';
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
    const fileName = input.files.length ? input.files[0].name : '';
    document.getElementById('fileName').innerText = fileName;
}
</script>
@endsection
