@extends('layouts.admin')

@section('title', 'Rekap Absensi')

@section('content')
@php
$rekapHarian = [
    ['nama'=>'Budi Santoso','role'=>'Guru','kelas'=>'-','status'=>'Hadir','jam'=>'07:10'],
    ['nama'=>'Siti Aminah','role'=>'Guru','kelas'=>'-','status'=>'Izin','jam'=>'-'],
    ['nama'=>'Andi Wijaya','role'=>'Guru','kelas'=>'-','status'=>'Hadir','jam'=>'07:05'],
];

$rekapBulanan = [
    ['nama'=>'Budi Santoso','hadir'=>20,'izin'=>1,'sakit'=>0,'alpha'=>1],
    ['nama'=>'Siti Aminah','hadir'=>18,'izin'=>2,'sakit'=>1,'alpha'=>0],
    ['nama'=>'Andi Wijaya','hadir'=>15,'izin'=>0,'sakit'=>2,'alpha'=>4],
];
// Data siswa
$rekapHarianSiswa = [
    ['nama'=>'Rina Putri','kelas'=>'X IPA 1','status'=>'Hadir','jam'=>'07:12'],
    ['nama'=>'Dewi Lestari','kelas'=>'X IPA 2','status'=>'Sakit','jam'=>'-'],
    ['nama'=>'Agus Salim','kelas'=>'X IPS 1','status'=>'Alpha','jam'=>'-'],
];
$rekapBulananSiswa = [
    ['nama'=>'Rina Putri','hadir'=>22,'izin'=>0,'sakit'=>1,'alpha'=>0],
    ['nama'=>'Dewi Lestari','hadir'=>19,'izin'=>1,'sakit'=>2,'alpha'=>1],
    ['nama'=>'Agus Salim','hadir'=>17,'izin'=>2,'sakit'=>0,'alpha'=>4],
];
@endphp

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Rekap Absensi</h1>
        <p class="text-gray-500">Monitoring dan laporan kehadiran guru & siswa</p>
    </div>

    <!-- Toggle Jenis -->
    <div class="flex gap-3 mb-6">
        <button id="btnGuru" onclick="switchJenis('guru')" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow transition">Guru</button>
        <button id="btnSiswa" onclick="switchJenis('siswa')" class="px-4 py-2 border rounded-lg text-sm font-semibold shadow transition">Siswa</button>
    </div>

    <!-- Tabs -->
    <div class="flex gap-3 mb-6">
        <button onclick="showTab('harian')" class="tab-btn active">Rekap Harian</button>
        <button onclick="showTab('bulanan')" class="tab-btn">Rekap Bulanan</button>
        <button onclick="showTab('individu')" class="tab-btn">Per Individu</button>
    </div>

    <!-- ================= TAB HARIAN ================= -->
    <div id="tab-harian" class="tab-content">
        <!-- Guru Section -->
        <div id="harian-guru-section">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="card-stat bg-white/80 border-2 border-green-200">
                    <span class="text-green-600 text-2xl mb-1"><i class="fa fa-user-check"></i></span>
                    <div class="font-semibold text-gray-700">Hadir</div>
                    <div class="text-2xl font-black text-green-700">2</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-yellow-200">
                    <span class="text-yellow-500 text-2xl mb-1"><i class="fa fa-user-clock"></i></span>
                    <div class="font-semibold text-gray-700">Izin</div>
                    <div class="text-2xl font-black text-yellow-700">1</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-blue-200">
                    <span class="text-blue-500 text-2xl mb-1"><i class="fa fa-user-md"></i></span>
                    <div class="font-semibold text-gray-700">Sakit</div>
                    <div class="text-2xl font-black text-blue-700">0</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-gray-200">
                    <span class="text-gray-400 text-2xl mb-1"><i class="fa fa-user-times"></i></span>
                    <div class="font-semibold text-gray-700">Alpha</div>
                    <div class="text-2xl font-black text-gray-700">0</div>
                </div>
            </div>
            <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
                <table class="w-full text-base mb-8">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
                            <th class="px-5 py-3 text-center font-bold">Status</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapHarian as $r)
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $r['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $r['nama'] }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if(strtolower($r['status'])=='hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-check-circle'></i> Hadir</span>
                                @elseif(strtolower($r['status'])=='izin')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-clock'></i> Izin</span>
                                @elseif(strtolower($r['status'])=='sakit')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-user-md'></i> Sakit</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-info-circle'></i> {{ $r['status'] }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['jam'] }}</td>
                        </tr>
                        @endforeach
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
                    <div class="text-2xl font-black text-green-700">2</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-yellow-200">
                    <span class="text-yellow-500 text-2xl mb-1"><i class="fa fa-user-clock"></i></span>
                    <div class="font-semibold text-gray-700">Izin</div>
                    <div class="text-2xl font-black text-yellow-700">0</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-blue-200">
                    <span class="text-blue-500 text-2xl mb-1"><i class="fa fa-user-md"></i></span>
                    <div class="font-semibold text-gray-700">Sakit</div>
                    <div class="text-2xl font-black text-blue-700">1</div>
                </div>
                <div class="card-stat bg-white/80 border-2 border-gray-200">
                    <span class="text-gray-400 text-2xl mb-1"><i class="fa fa-user-times"></i></span>
                    <div class="font-semibold text-gray-700">Alpha</div>
                    <div class="text-2xl font-black text-gray-700">1</div>
                </div>
            </div>
            <div class="bg-white/95 border border-blue-100 rounded-3xl shadow-2xl overflow-x-auto">
                <table class="w-full text-base mb-8">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
                            <th class="px-5 py-3 text-center font-bold">Status</th>
                            <th class="px-5 py-3 text-center font-bold">Kelas</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapHarianSiswa as $r)
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class='w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $r['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $r['nama'] }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if(strtolower($r['status'])=='hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-check-circle'></i> Hadir</span>
                                @elseif(strtolower($r['status'])=='izin')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-clock'></i> Izin</span>
                                @elseif(strtolower($r['status'])=='sakit')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-user-md'></i> Sakit</span>
                                @elseif(strtolower($r['status'])=='alpha')
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-info-circle'></i> Alpha</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa fa-info-circle'></i> {{ $r['status'] }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['kelas'] }}</td>
                            <td class="px-5 py-3 text-center text-gray-700">{{ $r['jam'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= TAB BULANAN ================= -->
    <div id="tab-bulanan" class="tab-content hidden">
        <!-- Guru Section -->
        <div id="bulanan-guru-section">
            <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
                            <th class="px-5 py-3 text-center font-bold">Hadir</th>
                            <th class="px-5 py-3 text-center font-bold">Izin</th>
                            <th class="px-5 py-3 text-center font-bold">Sakit</th>
                            <th class="px-5 py-3 text-center font-bold">Alpha</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapBulanan as $b)
                        @php
                            $total = $b['hadir'] + $b['izin'] + $b['sakit'] + $b['alpha'];
                            $persen = round(($b['hadir'] / $total) * 100);
                            $badge = $persen >= 90 ? 'bg-green-100 text-green-700' : ($persen >= 80 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $b['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $b['nama'] }}</span>
                            </td>
                            <td class="text-center">{{ $b['hadir'] }}</td>
                            <td class="text-center">{{ $b['izin'] }}</td>
                            <td class="text-center">{{ $b['sakit'] }}</td>
                            <td class="text-center">{{ $b['alpha'] }}</td>
                            <td class="text-center">
                                <span class="px-3 py-1 rounded-full {{$badge}} text-xs font-semibold flex items-center gap-1 justify-center mb-1"><i class='fa fa-chart-line'></i> {{ $persen }}%</span>
                                <div class="w-16 h-2 bg-slate-200 rounded-full mx-auto">
                                    <div class="h-2 rounded-full {{ $persen >= 90 ? 'bg-green-400' : ($persen >= 80 ? 'bg-yellow-400' : 'bg-red-400') }}" style="width: {{ $persen }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Siswa Section -->
        <div id="bulanan-siswa-section" class="hidden">
            <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-blue-900">
                        <tr>
                            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
                            <th class="px-5 py-3 text-center font-bold">Hadir</th>
                            <th class="px-5 py-3 text-center font-bold">Izin</th>
                            <th class="px-5 py-3 text-center font-bold">Sakit</th>
                            <th class="px-5 py-3 text-center font-bold">Alpha</th>
                            <th class="px-5 py-3 text-center font-bold rounded-tr-xl">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapBulananSiswa as $b)
                        @php
                            $total = $b['hadir'] + $b['izin'] + $b['sakit'] + $b['alpha'];
                            $persen = round(($b['hadir'] / $total) * 100);
                            $badge = $persen >= 90 ? 'bg-green-100 text-green-700' : ($persen >= 80 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
                            <td class="px-5 py-3 flex items-center gap-3">
                                <span class='w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow'>{{ collect(explode(' ', $b['nama']))->map(fn($n)=>$n[0])->join('') }}</span>
                                <span class="font-medium text-gray-800">{{ $b['nama'] }}</span>
                            </td>
                            <td class="text-center">{{ $b['hadir'] }}</td>
                            <td class="text-center">{{ $b['izin'] }}</td>
                            <td class="text-center">{{ $b['sakit'] }}</td>
                            <td class="text-center">{{ $b['alpha'] }}</td>
                            <td class="text-center">
                                <span class="px-3 py-1 rounded-full {{$badge}} text-xs font-semibold flex items-center gap-1 justify-center mb-1"><i class='fa fa-chart-line'></i> {{ $persen }}%</span>
                                <div class="w-16 h-2 bg-slate-200 rounded-full mx-auto">
                                    <div class="h-2 rounded-full {{ $persen >= 90 ? 'bg-green-400' : ($persen >= 80 ? 'bg-yellow-400' : 'bg-red-400') }}" style="width: {{ $persen }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
                <select id="selectIndividu" class="border rounded-lg px-4 py-2 text-base focus:ring-2 focus:ring-blue-400">
                    <!-- Diisi dinamis oleh JS -->
                </select>
                <span id="roleIndividu" class="text-sm text-gray-400"></span>
            </div>
            <div id="profilIndividu" class="hidden mb-6">
                <div class="flex items-center gap-4 mb-2">
                    <span id="avatarIndividu" class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center text-2xl shadow"></span>
                    <div>
                        <div id="namaIndividu" class="font-bold text-lg text-gray-800"></div>
                        <div id="kelasIndividu" class="text-sm text-gray-500"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-2">
                    <div class="card-stat bg-white/80 border-2 border-green-200">
                        <span class="text-green-600 text-xl mb-1"><i class="fa fa-user-check"></i></span>
                        <div class="font-semibold text-gray-700">Hadir</div>
                        <div id="statHadir" class="text-xl font-black text-green-700">0</div>
                    </div>
                    <div class="card-stat bg-white/80 border-2 border-yellow-200">
                        <span class="text-yellow-500 text-xl mb-1"><i class="fa fa-user-clock"></i></span>
                        <div class="font-semibold text-gray-700">Izin</div>
                        <div id="statIzin" class="text-xl font-black text-yellow-700">0</div>
                    </div>
                    <div class="card-stat bg-white/80 border-2 border-blue-200">
                        <span class="text-blue-500 text-xl mb-1"><i class="fa fa-user-md"></i></span>
                        <div class="font-semibold text-gray-700">Sakit</div>
                        <div id="statSakit" class="text-xl font-black text-blue-700">0</div>
                    </div>
                    <div class="card-stat bg-white/80 border-2 border-gray-200">
                        <span class="text-gray-400 text-xl mb-1"><i class="fa fa-user-times"></i></span>
                        <div class="font-semibold text-gray-700">Alpha</div>
                        <div id="statAlpha" class="text-xl font-black text-gray-700">0</div>
                    </div>
                    <div class="card-stat bg-white/80 border-2 border-green-200 col-span-2 md:col-span-1">
                        <span class="text-green-600 text-xl mb-1"><i class="fa fa-chart-line"></i></span>
                        <div class="font-semibold text-gray-700">% Hadir</div>
                        <div id="statPersen" class="text-xl font-black text-green-700">0%</div>
                        <div class="w-16 h-2 bg-slate-200 rounded-full mx-auto mt-1">
                            <div id="statBar" class="h-2 rounded-full bg-green-400" style="width:0%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="riwayatIndividu" class="hidden">
                <div class="font-semibold text-gray-700 mb-2">Riwayat Harian</div>
                <div class="bg-white/90 rounded-xl shadow overflow-x-auto">
                    <table class="w-full text-base">
                        <thead class="bg-slate-100 text-blue-900">
                            <tr>
                                <th class="px-4 py-2 text-left font-bold rounded-tl-xl">Tanggal</th>
                                <th class="px-4 py-2 text-center font-bold">Status</th>
                                <th class="px-4 py-2 text-center font-bold">Jam</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyRiwayat">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
        // Data dummy individu (guru & siswa)
        const dataIndividu = {
            guru: [
                {
                    nama: 'Budi Santoso', kelas: '-', role: 'Guru',
                    rekap: { hadir: 20, izin: 1, sakit: 0, alpha: 1 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Hadir', jam: '07:10' },
                        { tanggal: '2026-01-29', status: 'Izin', jam: '-' },
                        { tanggal: '2026-01-28', status: 'Hadir', jam: '07:12' },
                    ]
                },
                {
                    nama: 'Siti Aminah', kelas: '-', role: 'Guru',
                    rekap: { hadir: 18, izin: 2, sakit: 1, alpha: 0 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Hadir', jam: '07:15' },
                        { tanggal: '2026-01-29', status: 'Sakit', jam: '-' },
                        { tanggal: '2026-01-28', status: 'Hadir', jam: '07:13' },
                    ]
                },
                {
                    nama: 'Andi Wijaya', kelas: '-', role: 'Guru',
                    rekap: { hadir: 15, izin: 0, sakit: 2, alpha: 4 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Alpha', jam: '-' },
                        { tanggal: '2026-01-29', status: 'Hadir', jam: '07:09' },
                        { tanggal: '2026-01-28', status: 'Hadir', jam: '07:11' },
                    ]
                },
            ],
            siswa: [
                {
                    nama: 'Rina Putri', kelas: 'X IPA 1', role: 'Siswa',
                    rekap: { hadir: 22, izin: 0, sakit: 1, alpha: 0 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Hadir', jam: '07:12' },
                        { tanggal: '2026-01-29', status: 'Hadir', jam: '07:13' },
                        { tanggal: '2026-01-28', status: 'Sakit', jam: '-' },
                    ]
                },
                {
                    nama: 'Dewi Lestari', kelas: 'X IPA 2', role: 'Siswa',
                    rekap: { hadir: 19, izin: 1, sakit: 2, alpha: 1 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Hadir', jam: '07:14' },
                        { tanggal: '2026-01-29', status: 'Izin', jam: '-' },
                        { tanggal: '2026-01-28', status: 'Hadir', jam: '07:10' },
                    ]
                },
                {
                    nama: 'Agus Salim', kelas: 'X IPS 1', role: 'Siswa',
                    rekap: { hadir: 17, izin: 2, sakit: 0, alpha: 4 },
                    riwayat: [
                        { tanggal: '2026-01-30', status: 'Alpha', jam: '-' },
                        { tanggal: '2026-01-29', status: 'Hadir', jam: '07:16' },
                        { tanggal: '2026-01-28', status: 'Hadir', jam: '07:17' },
                    ]
                },
            ]
        };
        let jenisIndividu = 'guru';
        function renderDropdownIndividu() {
            const select = document.getElementById('selectIndividu');
            select.innerHTML = '';
            dataIndividu[jenisIndividu].forEach((d, i) => {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = d.nama;
                select.appendChild(opt);
            });
            document.getElementById('roleIndividu').textContent = jenisIndividu.charAt(0).toUpperCase() + jenisIndividu.slice(1);
            selectIndividuChanged();
        }
        function selectIndividuChanged() {
            const idx = document.getElementById('selectIndividu').value;
            const data = dataIndividu[jenisIndividu][idx];
            if (!data) return;
            document.getElementById('profilIndividu').classList.remove('hidden');
            document.getElementById('riwayatIndividu').classList.remove('hidden');
            // Avatar
            document.getElementById('avatarIndividu').textContent = data.nama.split(' ').map(n=>n[0]).join('');
            // Nama & kelas
            document.getElementById('namaIndividu').textContent = data.nama;
            document.getElementById('kelasIndividu').textContent = data.role === 'Guru' ? 'Guru' : data.kelas;
            // Statistik
            document.getElementById('statHadir').textContent = data.rekap.hadir;
            document.getElementById('statIzin').textContent = data.rekap.izin;
            document.getElementById('statSakit').textContent = data.rekap.sakit;
            document.getElementById('statAlpha').textContent = data.rekap.alpha;
            const total = data.rekap.hadir + data.rekap.izin + data.rekap.sakit + data.rekap.alpha;
            const persen = total ? Math.round((data.rekap.hadir/total)*100) : 0;
            document.getElementById('statPersen').textContent = persen+"%";
            document.getElementById('statBar').style.width = persen+"%";
            document.getElementById('statBar').className = 'h-2 rounded-full ' + (persen>=90?'bg-green-400':(persen>=80?'bg-yellow-400':'bg-red-400'));
            // Riwayat
            let tbody = '';
            data.riwayat.forEach(r => {
                let badge = r.status==='Hadir' ? 'bg-green-100 text-green-700' : (r.status==='Izin' ? 'bg-yellow-100 text-yellow-700' : (r.status==='Sakit' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'));
                let icon = r.status==='Hadir' ? 'fa-check-circle' : (r.status==='Izin' ? 'fa-clock' : (r.status==='Sakit' ? 'fa-user-md' : 'fa-info-circle'));
                tbody += `<tr class="group hover:bg-blue-50/40 transition">
                    <td class="px-4 py-2">${r.tanggal}</td>
                    <td class="px-4 py-2 text-center"><span class="px-3 py-1 rounded-full ${badge} text-xs font-semibold flex items-center gap-1 justify-center"><i class='fa ${icon}'></i> ${r.status}</span></td>
                    <td class="px-4 py-2 text-center text-gray-700">${r.jam}</td>
                </tr>`;
            });
            document.getElementById('tbodyRiwayat').innerHTML = tbody;
        }
        // Ganti dropdown jika toggle guru/siswa
        function updateIndividuDropdownByJenis() {
            renderDropdownIndividu();
        }
        // Integrasi dengan toggle utama
        const oldSwitchJenis = window.switchJenis;
        window.switchJenis = function(jenis) {
            oldSwitchJenis(jenis);
            jenisIndividu = jenis;
            renderDropdownIndividu();
        }
        document.addEventListener('DOMContentLoaded', function() {
            renderDropdownIndividu();
            document.getElementById('selectIndividu').addEventListener('change', selectIndividuChanged);
        });
        </script>
    </div>

</div>

<style>
.tab-btn {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    font-weight: 600;
    font-size: 14px;
    transition: all .2s;
}
.tab-btn.active {
    background: #2563eb;
    color: white;
    box-shadow: 0 2px 8px #2563eb22;
}
.card-stat {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    border-radius: 16px; box-shadow: 0 2px 12px #2563eb11;
    min-height: 110px;
    transition: box-shadow .2s, transform .2s;
}
.card-stat:hover { box-shadow: 0 4px 24px #2563eb22; transform: scale(1.03); }
</style>

@push('scripts')
<script>
function showTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    event.target.classList.add('active');
}
let jenisAktif = 'guru';
function switchJenis(jenis) {
    jenisAktif = jenis;
    document.getElementById('btnGuru').classList.remove('bg-blue-600','text-white');
    document.getElementById('btnGuru').classList.add('border');
    document.getElementById('btnSiswa').classList.remove('bg-blue-600','text-white');
    document.getElementById('btnSiswa').classList.add('border');
    if(jenis==='guru'){
        document.getElementById('btnGuru').classList.add('bg-blue-600','text-white');
        document.getElementById('btnGuru').classList.remove('border');
        document.getElementById('btnSiswa').classList.remove('bg-blue-600','text-white');
        document.getElementById('btnSiswa').classList.add('border');
        // Tampilkan data guru, sembunyikan siswa
        document.getElementById('harian-guru-section').classList.remove('hidden');
        document.getElementById('harian-siswa-section').classList.add('hidden');
        document.getElementById('bulanan-guru-section').classList.remove('hidden');
        document.getElementById('bulanan-siswa-section').classList.add('hidden');
    }else{
        document.getElementById('btnSiswa').classList.add('bg-blue-600','text-white');
        document.getElementById('btnSiswa').classList.remove('border');
        document.getElementById('btnGuru').classList.remove('bg-blue-600','text-white');
        document.getElementById('btnGuru').classList.add('border');
        // Tampilkan data siswa, sembunyikan guru
        document.getElementById('harian-guru-section').classList.add('hidden');
        document.getElementById('harian-siswa-section').classList.remove('hidden');
        document.getElementById('bulanan-guru-section').classList.add('hidden');
        document.getElementById('bulanan-siswa-section').classList.remove('hidden');
    }
}
// Set default ke guru saat load
document.addEventListener('DOMContentLoaded', function() {
    switchJenis('guru');
});
</script>
@endpush
@endsection
