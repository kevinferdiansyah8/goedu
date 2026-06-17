@extends('layouts.admin')

@section('title', 'Laporan Absensi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-2">
        <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-500 shadow-lg">
            <i data-lucide="calendar-check" class="w-8 h-8 text-white"></i>
        </span>
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-1">Laporan Absensi</h1>
            <p class="text-gray-400 text-lg">Rekap kehadiran {{ ucfirst($role) }} secara {{ $mode === 'harian' ? 'Harian' : 'Bulanan' }}</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <form method="GET" action="{{ route('admin.laporan.absensi') }}" class="bg-white border border-blue-100 rounded-2xl p-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between shadow">
        <div class="flex flex-wrap gap-3">
            <select name="mode" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="harian" {{ $mode==='harian'?'selected':'' }}>Harian</option>
                <option value="bulanan" {{ $mode==='bulanan'?'selected':'' }}>Bulanan</option>
            </select>
            <select name="role" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 min-w-[120px] text-base appearance-none">
                <option value="siswa" {{ $role==='siswa'?'selected':'' }}>Siswa</option>
                <option value="guru" {{ $role==='guru'?'selected':'' }}>Guru</option>
            </select>
            @if($mode === 'harian')
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 text-base">
            @else
                <input type="month" name="bulan" value="{{ $bulan }}" onchange="this.form.submit()" class="input bg-gray-100 border-2 border-blue-400 rounded-full shadow-sm font-semibold text-gray-800 px-4 py-2 text-base">
            @endif
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="window.print()" class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Cetak Laporan</button>
        </div>
    </form>

    <!-- SUMMARY -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-green-50 border border-green-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Total Hadir</div>
            <div class="text-3xl font-extrabold text-green-700 flex items-center gap-2"><i data-lucide="check-circle" class="w-6 h-6"></i>{{ $summary['hadir'] }}</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Total Izin</div>
            <div class="text-3xl font-extrabold text-yellow-700 flex items-center gap-2"><i data-lucide="alert-circle" class="w-6 h-6"></i>{{ $summary['izin'] }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Total Sakit</div>
            <div class="text-3xl font-extrabold text-blue-700 flex items-center gap-2"><i data-lucide="plus-circle" class="w-6 h-6"></i>{{ $summary['sakit'] }}</div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 flex flex-col items-center shadow">
            <div class="text-xs text-gray-500 mb-1">Total Alpha</div>
            <div class="text-3xl font-extrabold text-red-700 flex items-center gap-2"><i data-lucide="x-circle" class="w-6 h-6"></i>{{ $summary['alpha'] }}</div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-x-auto">
        <table class="min-w-full text-base">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left font-bold">Nama</th>
                    <th class="px-6 py-4 text-center font-bold">Hadir</th>
                    <th class="px-6 py-4 text-center font-bold">Izin</th>
                    <th class="px-6 py-4 text-center font-bold">Sakit</th>
                    <th class="px-6 py-4 text-center font-bold">Alpha</th>
                </tr>
            </thead>
            <tbody>
                @if($mode === 'harian')
                    @forelse($rekapHarian as $r)
                        <tr class="border-t hover:bg-blue-50 transition group">
                            <td class="px-6 py-4 font-semibold flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold group-hover:bg-blue-200">{{ strtoupper(substr($r['nama'],0,1)) }}</span>
                                {{ $r['nama'] }}
                            </td>
                            <td class="px-6 py-4 text-center">{!! $r['hadir'] ? '<span class=\'inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold\'><i data-lucide=\'check-circle\' class=\'w-4 h-4\'></i>Hadir</span>' : '-' !!}</td>
                            <td class="px-6 py-4 text-center">{!! $r['izin'] ? '<span class=\'inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold\'><i data-lucide=\'alert-circle\' class=\'w-4 h-4\'></i>Izin</span>' : '-' !!}</td>
                            <td class="px-6 py-4 text-center">{!! $r['sakit'] ? '<span class=\'inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold\'><i data-lucide=\'plus-circle\' class=\'w-4 h-4\'></i>Sakit</span>' : '-' !!}</td>
                            <td class="px-6 py-4 text-center">{!! $r['alpha'] ? '<span class=\'inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold\'><i data-lucide=\'x-circle\' class=\'w-4 h-4\'></i>Alpha</span>' : '-' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data absensi untuk tanggal ini.</td>
                        </tr>
                    @endforelse
                @else
                    @forelse($rekapBulanan as $r)
                        <tr class="border-t hover:bg-blue-50 transition group">
                            <td class="px-6 py-4 font-semibold flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold group-hover:bg-blue-200">{{ strtoupper(substr($r['nama'],0,1)) }}</span>
                                {{ $r['nama'] }}
                            </td>
                            <td class="px-6 py-4 text-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold"><i data-lucide="check-circle" class="w-4 h-4"></i>{{ $r['hadir'] }}</span></td>
                            <td class="px-6 py-4 text-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold"><i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $r['izin'] }}</span></td>
                            <td class="px-6 py-4 text-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold"><i data-lucide="plus-circle" class="w-4 h-4"></i>{{ $r['sakit'] }}</span></td>
                            <td class="px-6 py-4 text-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold"><i data-lucide="x-circle" class="w-4 h-4"></i>{{ $r['alpha'] }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data absensi untuk bulan ini.</td>
                        </tr>
                    @endforelse
                @endif
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
