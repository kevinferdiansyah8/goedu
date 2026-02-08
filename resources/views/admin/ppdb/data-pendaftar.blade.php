@extends('layouts.admin')

@section('title', 'PPDB - Penerimaan Siswa Baru')

@section('content')
@php
$pendaftar = [
    [
        'no' => 'PPDB001',
        'nama' => 'Andi Saputra',
        'jurusan' => 'RPL',
        'jalur' => 'Reguler',
        'status' => 'Menunggu'
    ],
    [
        'no' => 'PPDB002',
        'nama' => 'Siti Aminah',
        'jurusan' => 'TKJ',
        'jalur' => 'Prestasi',
        'status' => 'Diverifikasi'
    ],
    [
        'no' => 'PPDB003',
        'nama' => 'Budi Santoso',
        'jurusan' => 'AKL',
        'jalur' => 'Reguler',
        'status' => 'Lulus'
    ],
    [
        'no' => 'PPDB004',
        'nama' => 'Dewi Lestari',
        'jurusan' => 'RPL',
        'jalur' => 'Prestasi',
        'status' => 'Tidak Lulus'
    ],
];

$statusCount = collect($pendaftar)->countBy('status');
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">PPDB</h1>
            <p class="text-gray-500">Manajemen Penerimaan Peserta Didik Baru</p>
        </div>
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold text-sm">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            Periode Aktif 2025/2026
        </span>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-10">
        <div class="summary-card-ppdb group">
            <div class="icon-box-ppdb bg-blue-50 group-hover:bg-blue-100">
                <i data-lucide="users" class="w-8 h-8 text-blue-600"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-base font-semibold text-gray-600">Total Pendaftar</span>
                  <span class="text-3xl font-extrabold text-gray-900">{{ count($pendaftar) }}</span>
                </div>
                <div class="w-full h-2 bg-blue-100 rounded-full overflow-hidden">
                  <div class="h-full bg-blue-400/60 rounded-full transition-all" style="width:100%"></div>
                </div>
            </div>
        </div>
        <div class="summary-card-ppdb group">
            <div class="icon-box-ppdb bg-sky-50 group-hover:bg-sky-100">
                <i data-lucide="check-circle-2" class="w-8 h-8 text-sky-600"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-base font-semibold text-sky-600">Diverifikasi</span>
                  <span class="text-3xl font-extrabold text-sky-700">{{ $statusCount['Diverifikasi'] ?? 0 }}</span>
                </div>
                <div class="w-full h-2 bg-sky-100 rounded-full overflow-hidden">
                  <div class="h-full bg-sky-400/60 rounded-full transition-all" style="width:{{ (count($pendaftar) ? round((($statusCount['Diverifikasi']??0)/count($pendaftar))*100) : 0) }}%"></div>
                </div>
            </div>
        </div>
        <div class="summary-card-ppdb group">
            <div class="icon-box-ppdb bg-green-50 group-hover:bg-green-100">
                <i data-lucide="award" class="w-8 h-8 text-green-600"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-base font-semibold text-green-600">Lulus</span>
                  <span class="text-3xl font-extrabold text-green-700">{{ $statusCount['Lulus'] ?? 0 }}</span>
                </div>
                <div class="w-full h-2 bg-green-100 rounded-full overflow-hidden">
                  <div class="h-full bg-green-400/60 rounded-full transition-all" style="width:{{ (count($pendaftar) ? round((($statusCount['Lulus']??0)/count($pendaftar))*100) : 0) }}%"></div>
                </div>
            </div>
        </div>
        <div class="summary-card-ppdb group">
            <div class="icon-box-ppdb bg-red-50 group-hover:bg-red-100">
                <i data-lucide="x-octagon" class="w-8 h-8 text-red-600"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-base font-semibold text-red-600">Tidak Lulus</span>
                  <span class="text-3xl font-extrabold text-red-700">{{ $statusCount['Tidak Lulus'] ?? 0 }}</span>
                </div>
                <div class="w-full h-2 bg-red-100 rounded-full overflow-hidden">
                  <div class="h-full bg-red-400/60 rounded-full transition-all" style="width:{{ (count($pendaftar) ? round((($statusCount['Tidak Lulus']??0)/count($pendaftar))*100) : 0) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="mb-8">
      <div class="bg-white border-2 border-gray-200 rounded-3xl shadow-md px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap gap-5 w-full md:w-auto items-center justify-center md:justify-start">
            <input type="text" placeholder="Cari nama / no daftar"
                class="filter-input-ppdb" />
            <select class="filter-select-ppdb">
                <option value="">Semua Jurusan</option>
                <option>RPL</option>
                <option>TKJ</option>
                <option>AKL</option>
            </select>
            <select class="filter-select-ppdb">
                <option value="">Semua Status</option>
                <option>Menunggu</option>
                <option>Diverifikasi</option>
                <option>Lulus</option>
                <option>Tidak Lulus</option>
            </select>
        </div>
      </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white border-2 border-gray-300 rounded-3xl shadow-2xl overflow-x-auto">
        <table class="min-w-full text-base">
            <thead class="bg-slate-100 text-blue-900 sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-4 text-left font-extrabold text-lg">No Daftar</th>
                    <th class="px-6 py-4 text-left font-extrabold text-lg">Nama</th>
                    <th class="px-6 py-4 text-left font-extrabold text-lg">Jurusan</th>
                    <th class="px-6 py-4 text-left font-extrabold text-lg">Jalur</th>
                    <th class="px-6 py-4 text-center font-extrabold text-lg">Status</th>
                    <th class="px-6 py-4 text-center font-extrabold text-lg">Aksi</th>
                </tr>
            </thead>
            <tbody id="tablePendaftar">
                @foreach($pendaftar as $p)
                <tr class="group even:bg-blue-50/40 hover:bg-blue-100/60 transition rounded-2xl" data-no="{{ strtolower($p['no']) }}" data-nama="{{ strtolower($p['nama']) }}" data-jurusan="{{ strtolower($p['jurusan']) }}" data-status="{{ strtolower($p['status']) }}">
                    <td class="px-6 py-4 font-extrabold text-base">{{ $p['no'] }}</td>
                    <td class="px-6 py-4 text-base">{{ $p['nama'] }}</td>
                    <td class="px-6 py-4 text-base">{{ $p['jurusan'] }}</td>
                    <td class="px-6 py-4 text-base">{{ $p['jalur'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $badge = match($p['status']) {
                            'Menunggu' => 'bg-gray-100 text-gray-700 border border-gray-300',
                            'Diverifikasi' => 'bg-sky-50 text-sky-700 border border-sky-200',
                            'Lulus' => 'bg-green-50 text-green-700 border border-green-200',
                            'Tidak Lulus' => 'bg-red-50 text-red-700 border border-red-200',
                        };
                        @endphp
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-base font-semibold shadow-sm {{ $badge }}">
                            @if($p['status']==='Menunggu')<i data-lucide="clock" class="w-5 h-5"></i>@endif
                            @if($p['status']==='Diverifikasi')<i data-lucide="check-circle-2" class="w-5 h-5"></i>@endif
                            @if($p['status']==='Lulus')<i data-lucide="award" class="w-5 h-5"></i>@endif
                            @if($p['status']==='Tidak Lulus')<i data-lucide="x-octagon" class="w-5 h-5"></i>@endif
                            {{ $p['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-4">
                            <button class="btn-action-ppdb btn-detail-ppdb" title="Detail"><i data-lucide="eye" class="w-6 h-6"></i><div class="btn-label">Detail</div></button>
                            <button class="btn-action-ppdb btn-verif-ppdb" title="Verifikasi"><i data-lucide="check" class="w-6 h-6"></i><div class="btn-label">Verifikasi</div></button>
                            <button class="btn-action-ppdb btn-lulus-ppdb" title="Luluskan"><i data-lucide="award" class="w-6 h-6"></i><div class="btn-label">Luluskan</div></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<style>
.filter-input-ppdb {
    @apply px-7 py-3 rounded-full w-80 text-base bg-white shadow transition font-normal placeholder-gray-400;
    border: none !important;
    outline: none !important;
    font-size: 1.1rem;
    height: 52px;
    box-shadow: 0 1px 6px 0 #e5e7eb33;
}
.filter-input-ppdb:focus {
    outline: none !important;
    box-shadow: 0 2px 12px 0 #2563eb22;
}
.filter-input-ppdb:hover {
    background: #f8fafc;
}
.filter-input-ppdb::placeholder {
    color: #b0b0b0;
    font-weight: 400;
    opacity: 1;
}
.filter-select-ppdb {
    @apply px-7 py-3 rounded-full text-base bg-white shadow transition font-bold cursor-pointer;
    border: none !important;
    outline: none !important;
    font-size: 1.1rem;
    font-weight: 700;
    height: 52px;
    min-width: 210px;
    box-shadow: 0 1px 6px 0 #e5e7eb33;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23343a40' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1.5rem center;
    appearance: none;
}
.filter-select-ppdb:focus {
    outline: none !important;
    box-shadow: 0 2px 12px 0 #2563eb22;
}
.filter-select-ppdb:hover {
    background: #f8fafc;
}
.filter-select-ppdb option {
    font-weight: 700;
}
.summary-card-ppdb {
    @apply flex items-center gap-6 bg-white border-2 border-gray-200 rounded-2xl p-6 shadow-md group-hover:shadow-xl transition-all duration-200 cursor-pointer relative overflow-hidden;
    min-height: 110px;
}
.summary-card-ppdb:hover {
    border-color: #2563eb33;
    box-shadow: 0 8px 32px #2563eb22;
}
.icon-box-ppdb {
    @apply w-16 h-16 flex items-center justify-center rounded-xl shadow bg-opacity-80 transition-all duration-200 text-3xl;
}
.btn-action-ppdb {
    @apply flex flex-col items-center justify-center gap-1 px-3 py-2 rounded-xl text-base font-semibold shadow-sm transition-all duration-150;
    min-width: 60px;
    background: #f8fafc;
    border: 1.5px solid #e5e7eb;
}
.btn-action-ppdb:hover {
    transform: scale(1.08);
    box-shadow: 0 4px 16px #2563eb22;
    border-color: #2563eb44;
}
.btn-detail-ppdb {
    color: #334155;
    background: #f1f5f9;
}
.btn-detail-ppdb:hover {
    background: #e0e7ef;
    color: #2563eb;
}
.btn-verif-ppdb {
    color: #0369a1;
    background: #e0f2fe;
}
.btn-verif-ppdb:hover {
    background: #bae6fd;
    color: #0ea5e9;
}
.btn-lulus-ppdb {
    color: #15803d;
    background: #dcfce7;
}
.btn-lulus-ppdb:hover {
    background: #bbf7d0;
    color: #166534;
}
.btn-label {
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    margin-top: 2px;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) lucide.createIcons();
    // Filter interaktif
    const input = document.querySelector('.filter-input-ppdb');
    const selects = document.querySelectorAll('.filter-select-ppdb');
    const rows = document.querySelectorAll('#tablePendaftar tr');
    function filterTable() {
        const q = (input.value || '').toLowerCase();
        const jurusan = (selects[0].value || '').toLowerCase();
        const status = (selects[1].value || '').toLowerCase();
        rows.forEach(row => {
            const no = row.dataset.no || '';
            const nama = row.dataset.nama || '';
            const jur = row.dataset.jurusan || '';
            const stat = row.dataset.status || '';
            const matchQ = !q || no.includes(q) || nama.includes(q);
            const matchJur = !jurusan || jur === jurusan;
            const matchStat = !status || stat === status;
            row.style.display = (matchQ && matchJur && matchStat) ? '' : 'none';
        });
    }
    input.addEventListener('input', filterTable);
    selects.forEach(s => s.addEventListener('change', filterTable));
});
</script>
@endpush
