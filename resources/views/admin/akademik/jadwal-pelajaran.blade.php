@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')
    <!-- Page Content -->
    {{-- =======================
     JUDUL HALAMAN
======================= --}}
<div class="mb-6">
    <h1 class="text-foreground text-2xl md:text-3xl font-bold flex items-center gap-2">
        <i data-lucide="calendar-range" class="w-7 h-7 text-primary"></i>
        Data Akademik
    </h1>
    <p class="text-secondary text-sm md:text-base">
        Kelola data jurusan, kelas, dan ruang sekolah
    </p>
</div>
{{-- =======================
     TAB NAVIGASI
======================= --}}
<!-- =======================
   TAB NAVIGASI
======================= -->
<div class="flex items-center gap-1 rounded-xl p-1 bg-muted w-fit mb-8">
  <button type="button" class="tab-btn active" data-tab="mingguan" onclick="showTab('mingguan', this)">Jadwal Mingguan</button>
  <button type="button" class="tab-btn" data-tab="daftar" onclick="showTab('daftar', this)">Daftar Jadwal</button>
  <button type="button" class="tab-btn" data-tab="ruang" onclick="showTab('ruang', this)">Pemakaian Ruang</button>
</div>
@php
$jamList = ['07.00','08.00','09.00','10.00','11.00','12.00','13.00','14.00','15.00'];
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

$jadwal = [
    '07.00' => [
        'Senin' => ['Matematika','X IPA 1','Bu Sari','Ruang 1'],
        'Selasa' => ['Bahasa Indonesia','XI IPA 2','Pak Budi','Lab Bahasa'],
        'Rabu' => null,
        'Kamis' => ['IPA Terpadu','VII A','Bu Rina','Ruang 3'],
        'Jumat' => null,
        'Sabtu' => null,
    ],
    '08.00' => [
        'Senin' => null,
        'Selasa' => ['Matematika','X IPA 1','Bu Sari','Ruang 1'],
        'Rabu' => ['Bahasa Indonesia','XI IPA 2','Pak Budi','Lab Bahasa'],
        'Kamis' => null,
        'Jumat' => ['IPA Terpadu','VII A','Bu Rina','Ruang 3'],
        'Sabtu' => null,
    ],
    '09.00' => [
        'Senin' => null,
        'Selasa' => null,
        'Rabu' => ['Matematika','X IPA 1','Bu Sari','Ruang 1'],
        'Kamis' => ['Bahasa Indonesia','XI IPA 2','Pak Budi','Lab Bahasa'],
        'Jumat' => null,
        'Sabtu' => ['IPA Terpadu','VII A','Bu Rina','Ruang 3'],
    ],
];
@endphp
<div id="content-mingguan">
    <div class="rounded-2xl border border-border p-6 bg-white shadow-sm mb-8">
        <h2 class="font-bold text-lg flex items-center gap-2 mb-4">
            <i data-lucide="calendar-days" class="w-5 h-5 text-primary"></i>
            Jadwal Mingguan
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full text-sm">
                <thead>
                    <tr class="bg-muted">
                        <th class="p-2">Jam</th>
                        @foreach($hariList as $hari)
                            <th class="p-2 text-center">{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jamList as $jam)
                        <tr>
                            <td class="p-2 font-semibold text-center {{ $jam=='10.00' ? 'bg-warning-light text-warning-dark' : '' }}">
                                {{ $jam }}
                            </td>

                            @if($jam == '10.00')
                                @foreach($hariList as $hari)
                                    <td class="p-2 text-center bg-warning-light text-warning-dark font-bold">
                                        Istirahat
                                    </td>
                                @endforeach
                            @else
                                @foreach($hariList as $hari)
                                    <td class="p-2">
                                        @if(isset($jadwal[$jam][$hari]) && $jadwal[$jam][$hari])
                                            <div class="rounded-xl bg-accent-blue px-2 py-1 shadow text-center">
                                                <div class="font-bold">{{ $jadwal[$jam][$hari][0] }}</div>
                                                <div class="text-xs">{{ $jadwal[$jam][$hari][1] }}</div>
                                                <div class="text-xs text-secondary">{{ $jadwal[$jam][$hari][2] }}</div>
                                                <div class="text-xs text-info">{{ $jadwal[$jam][$hari][3] }}</div>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">- Kosong -</span>
                                        @endif
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-xs text-secondary mt-2">
            Slot kosong dan jam istirahat ditandai khusus.
        </p>
    </div>
</div>
<div id="content-daftar" class="hidden">
    <div class="rounded-2xl border border-border p-6 bg-white shadow-sm mb-8">
        <h2 class="font-bold text-lg flex items-center gap-2 mb-4">
            <i data-lucide="list" class="w-5 h-5 text-primary"></i>
            Daftar Jadwal
        </h2>

        <table class="w-full text-sm">
            <thead class="bg-muted">
                <tr>
                    <th class="p-2">Mapel</th>
                    <th class="p-2">Kelas</th>
                    <th class="p-2">Guru</th>
                    <th class="p-2">Hari & Jam</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2 font-bold text-primary">Matematika</td>
                    <td class="p-2">X IPA 1</td>
                    <td class="p-2">Bu Sari</td>
                    <td class="p-2">Senin 07.00–08.00</td>
                    <td class="p-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-success-light text-success-dark">Aktif</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="content-ruang" class="hidden">
    <div class="rounded-2xl border border-border p-6 bg-white shadow-sm">
        <h2 class="font-bold text-lg flex items-center gap-2 mb-4">
            <i data-lucide="building-2" class="w-5 h-5 text-primary"></i>
            Pemakaian Ruang
        </h2>

        <div class="grid md:grid-cols-3 gap-4">
            <div class="rounded-xl bg-accent-blue/40 p-4 text-center">
                <div class="text-2xl font-bold text-primary">85%</div>
                <div class="text-xs text-secondary">Ruang 1 Terpakai</div>
            </div>
            <div class="rounded-xl bg-accent-teal/40 p-4 text-center">
                <div class="text-2xl font-bold text-accent-teal">60%</div>
                <div class="text-xs text-secondary">Lab Bahasa Terpakai</div>
            </div>
            <div class="rounded-xl bg-accent-sky/40 p-4 text-center">
                <div class="text-2xl font-bold">5</div>
                <div class="text-xs text-secondary">Ruang Maintenance</div>
            </div>
        </div>
    </div>
</div>
<style>
.tab-btn {
  padding: 0.6rem 1.2rem;
  border-radius: 0.75rem;
  color: #6A7686;
  font-weight: 500;
  transition: all 0.2s;
}
.tab-btn.active {
  background: white;
  color: #080C1A;
  font-weight: 600;
  border: 1px solid #E5E7EB;
}
</style>
<script>
// Inisialisasi icon lucide
document.addEventListener('DOMContentLoaded', function() {
  lucide.createIcons();
  // Set tab default
  showTab('mingguan', document.querySelector('.tab-btn[data-tab="mingguan"]'));
});

// Fungsi toggle tab
function showTab(tab, btn) {
  // Sembunyikan semua konten
  document.getElementById('content-mingguan').classList.add('hidden');
  document.getElementById('content-daftar').classList.add('hidden');
  document.getElementById('content-ruang').classList.add('hidden');
  // Tampilkan konten sesuai tab
  document.getElementById('content-' + tab).classList.remove('hidden');
  // Reset semua tab
  document.querySelectorAll('.tab-btn').forEach(function(b) {
    b.classList.remove('active');
  });
  // Tab aktif
  if(btn) btn.classList.add('active');
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  sidebar.classList.toggle('-translate-x-full');
  overlay.classList.toggle('hidden');
  document.body.classList.toggle('overflow-hidden');
}

function toggleSekolah() {
  const menu = document.getElementById('menuSekolah');
  const arrow = document.getElementById('arrowSekolah');
  if (!menu || !arrow) return;
  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>
</div>
@endsection