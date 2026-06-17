@extends('layouts.admin')

@section('title', 'Rekap Absensi')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rekap Absensi</h1>
            <p class="text-gray-500">Monitoring dan laporan kehadiran guru & siswa</p>
        </div>
        <!-- Filter -->
        <form method="GET" action="{{ route('admin.absensi.rekap') }}" class="flex flex-wrap gap-2 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal (Harian)</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Bulan (Bulanan)</label>
                <input type="month" name="bulan" value="{{ $bulan }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>
        </form>
    </div>

    <!-- Toggle Jenis -->
    <div class="flex gap-3 mb-6">
        <button id="btnGuru"  onclick="switchJenis('guru')"  class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow transition">Guru</button>
        <button id="btnSiswa" onclick="switchJenis('siswa')" class="px-4 py-2 border rounded-lg text-sm font-semibold shadow transition">Siswa</button>
    </div>

    <!-- Tabs -->
    <div class="flex gap-3 mb-6">
        <button onclick="showTab('harian', event)"  class="tab-btn active">Rekap Harian</button>
        <button onclick="showTab('bulanan', event)" class="tab-btn">Rekap Bulanan</button>
        <button onclick="showTab('individu', event)" class="tab-btn">Per Individu</button>
    </div>

    <!-- ================= TAB HARIAN ================= -->
    <div id="tab-harian" class="tab-content">
        <!-- Guru Section -->
        <div id="harian-guru-section">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="card-stat bg-white/80 border-2 border-green-200">
                    <span class="text-green-600 text-2xl mb-1"><i class="fa fa-user-check"></i></span>
                    <div class="font-semibold text-gray-700">Hadir</div>
                    <div class="text-2xl font-black text-green-700">{{ collect($rekapHarian)->where('status','Hadir')->count() }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-yellow-200">
                    <span class="text-yellow-500 text-2xl mb-1"><i class="fa fa-user-clock"></i></span>
                    <div class="font-semibold text-gray-700">Izin</div>
                    <div class="text-2xl font-black text-yellow-700">{{ collect($rekapHarian)->where('status','Izin')->count() }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-blue-200">
                    <span class="text-blue-500 text-2xl mb-1"><i class="fa fa-user-md"></i></span>
                    <div class="font-semibold text-gray-700">Sakit</div>
                    <div class="text-2xl font-black text-blue-700">{{ collect($rekapHarian)->where('status','Sakit')->count() }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-gray-200">
                    <span class="text-gray-400 text-2xl mb-1"><i class="fa fa-user-times"></i></span>
                    <div class="font-semibold text-gray-700">Alpha</div>
                    <div class="text-2xl font-black text-gray-700">{{ collect($rekapHarian)->whereNotIn('status',['Hadir','Izin','Sakit'])->count() }}</div>
                </div>
            </div>
            <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
                <table class="w-full text-base mb-8">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Guru</th>
                            <th class="px-5 py-3 text-center font-bold">Status</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapHarian as $r)
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow">{{ collect(explode(' ', $r['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $r['nama'] }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if(strtolower($r['status'])=='hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">✅ Hadir</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">{{ $r['status'] }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['jam'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400">Belum ada data guru.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Siswa Section -->
        <div id="harian-siswa-section" class="hidden">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="card-stat bg-white/80 border-2 border-green-200">
                    <span class="text-green-600 text-2xl mb-1"><i class="fa fa-user-check"></i></span>
                    <div class="font-semibold text-gray-700">Hadir</div>
                    <div class="text-2xl font-black text-green-700">{{ $summaryHarianSiswa['hadir'] }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-yellow-200">
                    <span class="text-yellow-500 text-2xl mb-1"><i class="fa fa-user-clock"></i></span>
                    <div class="font-semibold text-gray-700">Izin</div>
                    <div class="text-2xl font-black text-yellow-700">{{ $summaryHarianSiswa['izin'] }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-blue-200">
                    <span class="text-blue-500 text-2xl mb-1"><i class="fa fa-user-md"></i></span>
                    <div class="font-semibold text-gray-700">Sakit</div>
                    <div class="text-2xl font-black text-blue-700">{{ $summaryHarianSiswa['sakit'] }}</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-gray-200">
                    <span class="text-gray-400 text-2xl mb-1"><i class="fa fa-user-times"></i></span>
                    <div class="font-semibold text-gray-700">Alpha</div>
                    <div class="text-2xl font-black text-gray-700">{{ $summaryHarianSiswa['alpha'] }}</div>
                </div>
            </div>
            <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
                <table class="w-full text-base mb-8">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Siswa</th>
                            <th class="px-5 py-3 text-center font-bold">Status</th>
                            <th class="px-5 py-3 text-center font-bold">Kelas</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapHarianSiswa as $r)
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow">{{ collect(explode(' ', $r['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $r['nama'] }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if(strtolower($r['status'])=='hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">✅ Hadir</span>
                                @elseif(strtolower($r['status'])=='izin')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">🟡 Izin</span>
                                @elseif(strtolower($r['status'])=='sakit')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">🔵 Sakit</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">❌ Alpha</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['kelas'] }}</td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['jam'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= TAB BULANAN ================= -->
    <div id="tab-bulanan" class="tab-content hidden">
        <!-- Guru Bulanan -->
        <div id="bulanan-guru-section">
            <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Guru</th>
                            <th class="px-5 py-3 text-center font-bold">Hadir</th>
                            <th class="px-5 py-3 text-center font-bold">Izin</th>
                            <th class="px-5 py-3 text-center font-bold">Sakit</th>
                            <th class="px-5 py-3 text-center font-bold">Alpha</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapBulanan as $b)
                        @php
                            $total  = max(1, $b['hadir'] + $b['izin'] + $b['sakit'] + $b['alpha']);
                            $persen = round(($b['hadir'] / $total) * 100);
                            $badge  = $persen >= 90 ? 'bg-green-100 text-green-700' : ($persen >= 80 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow">{{ collect(explode(' ', $b['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $b['nama'] }}</span>
                            </td>
                            <td class="text-center">{{ $b['hadir'] }}</td>
                            <td class="text-center">{{ $b['izin'] }}</td>
                            <td class="text-center">{{ $b['sakit'] }}</td>
                            <td class="text-center">{{ $b['alpha'] }}</td>
                            <td class="text-center">
                                <span class="px-2 py-1 rounded-full {{ $badge }} text-xs font-semibold">{{ $persen }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada data guru.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Siswa Bulanan -->
        <div id="bulanan-siswa-section" class="hidden">
            <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama Siswa</th>
                            <th class="px-5 py-3 text-center font-bold">Kelas</th>
                            <th class="px-5 py-3 text-center font-bold">Hadir</th>
                            <th class="px-5 py-3 text-center font-bold">Izin</th>
                            <th class="px-5 py-3 text-center font-bold">Sakit</th>
                            <th class="px-5 py-3 text-center font-bold">Alpha</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapBulananSiswa as $b)
                        @php
                            $total  = max(1, $b['hadir'] + $b['izin'] + $b['sakit'] + $b['alpha']);
                            $persen = round(($b['hadir'] / $total) * 100);
                            $badge  = $persen >= 90 ? 'bg-green-100 text-green-700' : ($persen >= 80 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow">{{ collect(explode(' ', $b['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $b['nama'] }}</span>
                            </td>
                            <td class="text-center text-gray-600">{{ $b['kelas'] }}</td>
                            <td class="text-center">{{ $b['hadir'] }}</td>
                            <td class="text-center">{{ $b['izin'] }}</td>
                            <td class="text-center">{{ $b['sakit'] }}</td>
                            <td class="text-center">{{ $b['alpha'] }}</td>
                            <td class="text-center">
                                <span class="px-2 py-1 rounded-full {{ $badge }} text-xs font-semibold">{{ $persen }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= TAB INDIVIDU ================= -->
    <div id="tab-individu" class="tab-content hidden">
        <div class="bg-white/95 rounded-2xl shadow-2xl p-6 max-w-3xl mx-auto">
            <p class="text-gray-500 mb-4">Pilih individu untuk melihat detail absensi.</p>
            <div class="flex flex-col md:flex-row gap-4 items-center mb-6">
                <select id="selectIndividu" class="border rounded-lg px-4 py-2 text-base focus:ring-2 focus:ring-blue-400 flex-1"></select>
                <span id="roleIndividu" class="text-sm text-gray-400"></span>
            </div>
            <div id="profilIndividu" class="hidden mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <span id="avatarIndividu" class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center text-2xl shadow"></span>
                    <div>
                        <div id="namaIndividu" class="font-bold text-lg text-gray-800"></div>
                        <div id="kelasIndividu" class="text-sm text-gray-500"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <div class="card-stat bg-white/80 border-2 border-green-200"><span class="text-green-600"><i class="fa fa-user-check"></i></span><div class="font-semibold text-gray-700">Hadir</div><div id="statHadir" class="text-xl font-black text-green-700">0</div></div>
                    <div class="card-stat bg-white/80 border-2 border-yellow-200"><span class="text-yellow-500"><i class="fa fa-user-clock"></i></span><div class="font-semibold text-gray-700">Izin</div><div id="statIzin" class="text-xl font-black text-yellow-700">0</div></div>
                    <div class="card-stat bg-white/80 border-2 border-blue-200"><span class="text-blue-500"><i class="fa fa-user-md"></i></span><div class="font-semibold text-gray-700">Sakit</div><div id="statSakit" class="text-xl font-black text-blue-700">0</div></div>
                    <div class="card-stat bg-white/80 border-2 border-gray-200"><span class="text-gray-400"><i class="fa fa-user-times"></i></span><div class="font-semibold text-gray-700">Alpha</div><div id="statAlpha" class="text-xl font-black text-gray-700">0</div></div>
                </div>
            </div>
            <div id="riwayatIndividu" class="hidden">
                <div class="font-semibold text-gray-700 mb-2">Riwayat Harian (30 hari terakhir)</div>
                <div class="bg-white/90 rounded-xl shadow overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100 text-blue-900">
                            <tr>
                                <th class="px-4 py-2 text-left font-bold">Tanggal</th>
                                <th class="px-4 py-2 text-center font-bold">Status</th>
                                <th class="px-4 py-2 text-center font-bold">Jam</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyRiwayat"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.tab-btn { padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; font-weight: 600; font-size: 14px; transition: all .2s; }
.tab-btn.active { background: #2563eb; color: white; box-shadow: 0 2px 8px #2563eb22; }
.card-stat { display:flex; flex-direction:column; align-items:center; justify-content:center; border-radius:16px; box-shadow:0 2px 12px #2563eb11; min-height:100px; padding:12px; gap:4px; transition:.2s; }
.card-stat:hover { box-shadow: 0 4px 24px #2563eb22; transform: scale(1.03); }
</style>

@push('scripts')
<script>
const dataIndividu = {
    guru: @json($individuGuru),
    siswa: @json($individuSiswa)
};
let jenisIndividu = 'guru';

function renderDropdownIndividu() {
    const select = document.getElementById('selectIndividu');
    select.innerHTML = '<option value="">-- Pilih --</option>';
    dataIndividu[jenisIndividu].forEach((d, i) => {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = d.nama;
        select.appendChild(opt);
    });
    document.getElementById('roleIndividu').textContent = jenisIndividu === 'guru' ? 'Guru' : 'Siswa';
}

function selectIndividuChanged() {
    const idx  = document.getElementById('selectIndividu').value;
    const data = dataIndividu[jenisIndividu][idx];
    if (!data) return;

    document.getElementById('profilIndividu').classList.remove('hidden');
    document.getElementById('riwayatIndividu').classList.remove('hidden');
    document.getElementById('avatarIndividu').textContent = data.nama.split(' ').map(n=>n[0]).join('');
    document.getElementById('namaIndividu').textContent   = data.nama;
    document.getElementById('kelasIndividu').textContent  = data.kelas;
    document.getElementById('statHadir').textContent = data.rekap.hadir;
    document.getElementById('statIzin').textContent  = data.rekap.izin;
    document.getElementById('statSakit').textContent = data.rekap.sakit;
    document.getElementById('statAlpha').textContent = data.rekap.alpha;

    let tbody = '';
    if (data.riwayat && data.riwayat.length > 0) {
        data.riwayat.forEach(r => {
            let badge = r.status==='Hadir' ? 'bg-green-100 text-green-700' : (r.status==='Izin' ? 'bg-yellow-100 text-yellow-700' : (r.status==='Sakit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'));
            tbody += `<tr class="hover:bg-blue-50/40 transition">
                <td class="px-4 py-2">${r.tanggal}</td>
                <td class="px-4 py-2 text-center"><span class="px-2 py-1 rounded-full ${badge} text-xs font-semibold">${r.status}</span></td>
                <td class="px-4 py-2 text-center text-gray-700">${r.jam}</td>
            </tr>`;
        });
    } else {
        tbody = '<tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat.</td></tr>';
    }
    document.getElementById('tbodyRiwayat').innerHTML = tbody;
}

function showTab(tab, event) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    event.target.classList.add('active');
}

let jenisAktif = 'guru';
function switchJenis(jenis) {
    jenisAktif = jenis;
    ['guru','siswa'].forEach(j => {
        const btn = document.getElementById('btn' + j.charAt(0).toUpperCase() + j.slice(1));
        if (j === jenis) {
            btn.classList.add('bg-blue-600','text-white');
            btn.classList.remove('border');
        } else {
            btn.classList.remove('bg-blue-600','text-white');
            btn.classList.add('border');
        }
    });
    // Toggle harian & bulanan sections
    document.getElementById('harian-guru-section').classList.toggle('hidden', jenis !== 'guru');
    document.getElementById('harian-siswa-section').classList.toggle('hidden', jenis !== 'siswa');
    document.getElementById('bulanan-guru-section').classList.toggle('hidden', jenis !== 'guru');
    document.getElementById('bulanan-siswa-section').classList.toggle('hidden', jenis !== 'siswa');
    // Update individu dropdown
    jenisIndividu = jenis;
    renderDropdownIndividu();
}

document.addEventListener('DOMContentLoaded', function () {
    renderDropdownIndividu();
    document.getElementById('selectIndividu').addEventListener('change', selectIndividuChanged);
    switchJenis('guru');
});
</script>
@endpush
@endsection
