@extends('layouts.admin')

@section('title', 'Penilaian')

@section('content')
@php
$kelasList = ['X RPL 1', 'XI TKJ 2'];
$mapelList = ['Pemrograman Dasar', 'Basis Data'];
$nilai = [
    [
        'nama' => 'Andi Wijaya',
        'kelas' => 'X RPL 1',
        'mapel' => 'Pemrograman Dasar',
        'nilai' => 85,
        'status' => 'Lulus',
    ],
    [
        'nama' => 'Siti Aminah',
        'kelas' => 'XI TKJ 2',
        'mapel' => 'Basis Data',
        'nilai' => 72,
        'status' => 'Remedial',
    ],
];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-2">
            <i data-lucide="award" class="w-8 h-8 text-blue-600"></i>
            Penilaian
        </h1>
        <p class="text-gray-500 text-base">Kelola nilai siswa per kelas dan mata pelajaran</p>
    </div>
    <!-- Filter & Action -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex flex-wrap gap-3 bg-white border rounded-xl shadow-sm p-4">
            <select id="filterKelas" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none w-48 transition">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                @endforeach
            </select>
            <select id="filterMapel" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none w-48 transition">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $m)
                    <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <button onclick="toggleFormNilai()" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-xl font-bold shadow hover:bg-blue-700 transition text-base">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Nilai
        </button>
    </div>
    <!-- Tabel Penilaian -->
    <div class="bg-white border rounded-2xl shadow p-6 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <th class="px-4 py-3 text-left">Nama Siswa</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                    <th class="px-4 py-3 text-center">Nilai</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="nilaiTable">
                @foreach($nilai as $n)
                <tr class="border-b last:border-0 hover:bg-blue-50/30 transition" data-kelas="{{ $n['kelas'] }}" data-mapel="{{ $n['mapel'] }}">
                    <td class="px-4 py-2 font-medium">{{ $n['nama'] }}</td>
                    <td class="px-4 py-2">{{ $n['kelas'] }}</td>
                    <td class="px-4 py-2">{{ $n['mapel'] }}</td>
                    <td class="px-4 py-2 text-center font-bold text-blue-700">{{ $n['nilai'] }}</td>
                    <td class="px-4 py-2 text-center">
                        @if($n['status'] === 'Lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold border border-green-100">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Lulus
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full bg-yellow-50 text-yellow-700 text-xs font-semibold border border-yellow-100">
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i> Remedial
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button class="inline-flex items-center gap-1 px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow transition">
                            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Form Tambah Nilai -->
    <div id="formNilai" class="max-w-2xl mx-auto hidden mt-10">
        <div class="bg-white border rounded-2xl shadow-lg p-8">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="clipboard-edit" class="w-5 h-5 text-blue-600"></i>
                <h2 class="text-xl font-bold">Tambah Nilai</h2>
            </div>
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium mb-1 block">Nama Siswa</label>
                        <input class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Nama siswa">
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1 block">Kelas</label>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @foreach($kelasList as $k)
                                <option>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1 block">Mata Pelajaran</label>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @foreach($mapelList as $m)
                                <option>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1 block">Nilai</label>
                        <input type="number" class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="0 - 100">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-8">
                    <button type="button" onclick="toggleFormNilai()" class="px-6 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-semibold hover:bg-gray-100">Batal</button>
                    <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow hover:bg-blue-700 transition">
                        <i data-lucide="save" class="w-5 h-5"></i>
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
function toggleFormNilai() {
    const form = document.getElementById('formNilai');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) lucide.createIcons();
    document.getElementById('filterKelas').addEventListener('change', filterTable);
    document.getElementById('filterMapel').addEventListener('change', filterTable);
});
function filterTable() {
    const kelas = document.getElementById('filterKelas').value;
    const mapel = document.getElementById('filterMapel').value;
    document.querySelectorAll('#nilaiTable tr').forEach(row => {
        const show =
            (kelas === '' || row.dataset.kelas === kelas) &&
            (mapel === '' || row.dataset.mapel === mapel);
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endpush
