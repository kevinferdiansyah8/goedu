@extends('layouts.admin')

@section('title', 'Rekap Absensi Siswa')

@section('content')
@php
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
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Rekap Absensi Siswa</h1>
        <p class="text-gray-500">
            Rekap kehadiran siswa yang diajar oleh guru
        </p>
    </div>

    <div class="flex gap-3 mb-6">
    <button onclick="showTab('harian')" class="tab-btn active">Rekap Harian</button>
    <button onclick="showTab('bulanan')" class="tab-btn">Rekap Bulanan</button>
    <button onclick="showTab('individu')" class="tab-btn">Per Siswa</button>
</div>

<div id="tab-harian" class="tab-content">
    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-base">
            <thead class="bg-slate-100 text-blue-900">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-center">Kelas</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center">Jam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapHarianSiswa as $r)
                <tr class="border-b">
                    <td class="px-5 py-3">{{ $r['nama'] }}</td>
                    <td class="px-5 py-3 text-center">{{ $r['kelas'] }}</td>
                    <td class="px-5 py-3 text-center">{{ $r['status'] }}</td>
                    <td class="px-5 py-3 text-center">{{ $r['jam'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="tab-bulanan" class="tab-content hidden">
    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-base">
            <thead class="bg-slate-100 text-blue-900">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-center">Hadir</th>
                    <th class="px-5 py-3 text-center">Izin</th>
                    <th class="px-5 py-3 text-center">Sakit</th>
                    <th class="px-5 py-3 text-center">Alpha</th>
                    <th class="px-5 py-3 text-center">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapBulananSiswa as $b)
                @php
                    $total = $b['hadir']+$b['izin']+$b['sakit']+$b['alpha'];
                    $persen = round(($b['hadir']/$total)*100);
                @endphp
                <tr class="border-b">
                    <td class="px-5 py-3">{{ $b['nama'] }}</td>
                    <td class="text-center">{{ $b['hadir'] }}</td>
                    <td class="text-center">{{ $b['izin'] }}</td>
                    <td class="text-center">{{ $b['sakit'] }}</td>
                    <td class="text-center">{{ $b['alpha'] }}</td>
                    <td class="text-center font-semibold">{{ $persen }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="tab-individu" class="tab-content hidden">
    <div class="bg-white rounded-2xl shadow p-6 max-w-xl mx-auto">
        <label class="font-medium">Pilih Siswa</label>
        <select id="selectSiswa" class="w-full border rounded-lg px-4 py-2 mt-2"></select>

        <div id="detailSiswa" class="mt-6 hidden">
            <h3 id="namaSiswa" class="font-bold text-lg"></h3>
            <p id="kelasSiswa" class="text-sm text-gray-500 mb-4"></p>

            <div class="grid grid-cols-4 gap-3">
                <div>Hadir: <span id="sHadir"></span></div>
                <div>Izin: <span id="sIzin"></span></div>
                <div>Sakit: <span id="sSakit"></span></div>
                <div>Alpha: <span id="sAlpha"></span></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const dataSiswa = @json($rekapBulananSiswa);

function showTab(tab){
    document.querySelectorAll('.tab-content').forEach(e=>e.classList.add('hidden'));
    document.getElementById('tab-'+tab).classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(e=>e.classList.remove('active'));
    event.target.classList.add('active');
}

document.addEventListener('DOMContentLoaded', ()=>{
    const select = document.getElementById('selectSiswa');
    dataSiswa.forEach((s,i)=>{
        const o=document.createElement('option');
        o.value=i;
        o.text=s.nama;
        select.appendChild(o);
    });
    select.onchange=()=>{
        const s=dataSiswa[select.value];
        document.getElementById('detailSiswa').classList.remove('hidden');
        document.getElementById('namaSiswa').textContent=s.nama;
        document.getElementById('kelasSiswa').textContent='Siswa';
        document.getElementById('sHadir').textContent=s.hadir;
        document.getElementById('sIzin').textContent=s.izin;
        document.getElementById('sSakit').textContent=s.sakit;
        document.getElementById('sAlpha').textContent=s.alpha;
    };
});
</script>
@endpush
@endsection
