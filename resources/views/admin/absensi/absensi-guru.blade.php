@extends('layouts.admin')

@section('title', 'Absensi Guru')

@section('content')
@php
$absensiGuru = [
    [
        'nama' => 'Budi Santoso, S.Pd',
        'nip' => '198712312021011001',
        'tanggal' => '2026-01-31',
        'jam' => '07:12',
        'status' => 'Hadir',
        'keterangan' => '-'
    ],
    [
        'nama' => 'Siti Aminah, S.Pd',
        'nip' => '198902122022011002',
        'tanggal' => '2026-01-31',
        'jam' => '07:25',
        'status' => 'Izin',
        'keterangan' => 'Urusan keluarga'
    ],
    [
        'nama' => 'Dewi Lestari, S.Pd',
        'nip' => '199001052023011003',
        'tanggal' => '2026-01-31',
        'jam' => '-',
        'status' => 'Sakit',
        'keterangan' => 'Demam'
    ],
];
@endphp


<div class="min-h-screen w-full bg-gradient-to-br from-slate-50 via-white to-blue-100 py-10 px-2 md:px-0">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Absensi Guru</h1>
            <p class="text-base text-gray-500">Monitoring kehadiran guru (admin)</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="flex flex-col items-center bg-white/80 border-2 border-gray-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-gray-300 text-2xl"><i class="fa fa-users"></i></span>
                <span class="text-3xl font-extrabold text-gray-800 mb-1">{{ count($absensiGuru) }}</span>
                <span class="font-semibold text-gray-500 text-lg">Total Guru</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-green-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-green-300 text-2xl"><i class="fa fa-user-check"></i></span>
                <span class="text-3xl font-extrabold text-green-700 mb-1">{{ collect($absensiGuru)->where('status','Hadir')->count() }}</span>
                <span class="font-semibold text-green-700 text-lg">Hadir</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-yellow-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-yellow-300 text-2xl"><i class="fa fa-user-clock"></i></span>
                <span class="text-3xl font-extrabold text-yellow-700 mb-1">{{ collect($absensiGuru)->where('status','Izin')->count() }}</span>
                <span class="font-semibold text-yellow-700 text-lg">Izin</span>
            </div>
            <div class="flex flex-col items-center bg-white/80 border-2 border-red-200 rounded-2xl shadow p-6 relative overflow-hidden">
                <span class="absolute top-2 right-2 text-red-300 text-2xl"><i class="fa fa-user-times"></i></span>
                <span class="text-3xl font-extrabold text-red-700 mb-1">{{ collect($absensiGuru)->where('status','Sakit')->count() }}</span>
                <span class="font-semibold text-red-700 text-lg">Sakit</span>
            </div>
        </div>

        <!-- Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="date" class="border border-blue-200 rounded-lg px-4 py-2 w-full md:w-56 focus:ring-2 focus:ring-blue-200">
            <select id="filterStatus" class="border border-blue-200 rounded-lg px-4 py-2 w-full md:w-56 focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Status</option>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Dinas">Dinas</option>
            </select>
        </div>

        <!-- Table -->
        <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
            <table class="min-w-full text-base mb-8">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-slate-100 text-blue-900">
                        <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Guru</th>
                        <th class="px-5 py-3 text-left font-bold">NIP</th>
                        <th class="px-5 py-3 text-center font-bold">Tanggal</th>
                        <th class="px-5 py-3 text-center font-bold">Jam</th>
                        <th class="px-5 py-3 text-center font-bold">Status</th>
                        <th class="px-5 py-3 text-left font-bold rounded-tr-xl">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tableAbsensi">
                    @foreach($absensiGuru as $a)
                    <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl" data-status="{{ $a['status'] }}">
                        <td class="px-5 py-3 flex items-center gap-3">
                            <span class='w-12 h-12 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow text-sm'>{{ collect(explode(' ', $a['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                            <span class="font-medium text-gray-800">{{ $a['nama'] }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $a['nip'] }}</td>
                        <td class="px-5 py-3 text-center text-gray-700">{{ $a['tanggal'] }}</td>
                        <td class="px-5 py-3 text-center text-gray-700">{{ $a['jam'] }}</td>
                        <td class="px-5 py-3 text-center">
                            @if($a['status'] === 'Hadir')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-check-circle'></i> Hadir</span>
                            @elseif($a['status'] === 'Izin')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-clock'></i> Izin</span>
                            @elseif($a['status'] === 'Sakit')
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-times-circle'></i> Sakit</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-info-circle'></i> {{ $a['status'] }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $a['keterangan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('filterStatus').addEventListener('change', function () {
    const status = this.value;
    document.querySelectorAll('#tableAbsensi tr').forEach(row => {
        if (!status || row.dataset.status === status) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
});
</script>
@endpush
