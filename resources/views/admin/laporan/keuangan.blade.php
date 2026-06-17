@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

    <!-- HEADER -->
    <div class="flex items-center gap-5 mb-2">
        <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 shadow-xl">
            <i data-lucide="wallet" class="w-9 h-9 text-white"></i>
        </span>
        <div>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan Keuangan</h1>
            <p class="text-gray-400 text-xl">Rekap pemasukan & pengeluaran sekolah secara visual dan informatif</p>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.laporan.keuangan') }}" class="bg-white border border-blue-200 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow-lg">
        <div class="flex flex-wrap gap-3">
            <select name="bulan" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[140px] text-base appearance-none">
                @foreach($months as $num => $name)
                    <option value="{{ $num }}" {{ $selectedBulanNum === $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <select name="tahun" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="2026" {{ $selectedTahun === '2026' ? 'selected' : '' }}>2026</option>
                <option value="2025" {{ $selectedTahun === '2025' ? 'selected' : '' }}>2025</option>
                <option value="2024" {{ $selectedTahun === '2024' ? 'selected' : '' }}>2024</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="window.print()" class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Cetak Laporan</button>
        </div>
    </form>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gradient-to-br from-blue-100 to-blue-50 border border-blue-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Pemasukan</div>
            <div class="text-4xl font-extrabold text-blue-700 flex items-center gap-3"><i data-lucide="arrow-down-circle" class="w-8 h-8"></i>Rp {{ number_format($totalMasuk,0,',','.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-red-100 to-red-50 border border-red-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Total Pengeluaran</div>
            <div class="text-4xl font-extrabold text-red-700 flex items-center gap-3"><i data-lucide="arrow-up-circle" class="w-8 h-8"></i>Rp {{ number_format($totalKeluar,0,',','.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-50 border border-green-200 rounded-2xl p-8 flex flex-col items-center shadow-lg">
            <div class="text-xs text-gray-500 mb-2">Saldo Akhir</div>
            <div class="text-4xl font-extrabold text-green-700 flex items-center gap-3"><i data-lucide="wallet" class="w-8 h-8"></i>Rp {{ number_format($saldo,0,',','.') }}</div>
        </div>
    </div>

    <!-- COMPARATIVE CHART -->
    <div class="bg-white border border-blue-100 rounded-2xl shadow-lg p-8">
        <div class="font-bold text-blue-700 mb-6 flex items-center gap-2 text-lg"><i data-lucide="bar-chart-3" class="w-5 h-5"></i> Perbandingan Anggaran Bulan {{ $bulanName }}</div>
        <div class="space-y-6">
            <div>
                <div class="flex justify-between text-sm font-semibold mb-1 text-blue-800">
                    <span>Total Pemasukan (100%)</span>
                    <span>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-100 h-6 rounded-full overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-full rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                @php
                    $ratio = $totalMasuk > 0 ? min(round(($totalKeluar / $totalMasuk) * 100), 100) : 0;
                @endphp
                <div class="flex justify-between text-sm font-semibold mb-1 text-red-800">
                    <span>Total Pengeluaran ({{ $ratio }}% dari Pemasukan)</span>
                    <span>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-100 h-6 rounded-full overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 h-full rounded-full" style="width: {{ $ratio }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- PEMASUKAN -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <div class="p-6 border-b font-bold text-blue-700 flex items-center gap-2 text-lg">
            <i data-lucide="arrow-down-circle" class="w-5 h-5"></i> Pemasukan
        </div>
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-bold">Sumber</th>
                    <th class="px-6 py-4 text-left font-bold">Keterangan</th>
                    <th class="px-6 py-4 text-right font-bold">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemasukan as $p)
                <tr class="border-t hover:bg-blue-50 transition group">
                    <td class="px-6 py-4">{{ $p['tanggal'] }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $p['sumber'] }}</td>
                    <td class="px-6 py-4">{{ $p['keterangan'] }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold">Rp {{ number_format($p['jumlah'],0,',','.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada data pemasukan untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PENGELUARAN -->
    <div class="bg-white border border-red-100 rounded-3xl shadow-xl overflow-x-auto mt-10">
        <div class="p-6 border-b font-bold text-red-700 flex items-center gap-2 text-lg">
            <i data-lucide="arrow-up-circle" class="w-5 h-5"></i> Pengeluaran
        </div>
        <table class="min-w-full text-base">
            <thead class="bg-red-50 text-red-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-4 text-left font-bold">Kategori</th>
                    <th class="px-6 py-4 text-left font-bold">Keterangan</th>
                    <th class="px-6 py-4 text-right font-bold">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluaran as $k)
                <tr class="border-t hover:bg-red-50 transition group">
                    <td class="px-6 py-4">{{ $k['tanggal'] }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $k['kategori'] }}</td>
                    <td class="px-6 py-4">{{ $k['keterangan'] }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold">Rp {{ number_format($k['jumlah'],0,',','.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada data pengeluaran untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        lucide.createIcons();
    }
});
</script>
@endpush
