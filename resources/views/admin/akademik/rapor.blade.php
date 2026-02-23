@extends('layouts.admin')

@section('title', 'Rapor Siswa')

@section('content')
@php
$kelasList = ['X RPL 1', 'X RPL 2', 'XI TKJ 1', 'XI MM 1', 'XII AKL 1'];

$siswa = [
    [
        'nama' => 'Andi Wijaya', 'nisn' => '0012345678', 'kelas' => 'X RPL 1',
        'nilai' => [
            ['mapel' => 'Pemrograman Dasar', 'tugas' => 88, 'uts' => 82, 'uas' => 85, 'rata' => 85],
            ['mapel' => 'Basis Data', 'tugas' => 80, 'uts' => 75, 'uas' => 78, 'rata' => 78],
            ['mapel' => 'Matematika', 'tugas' => 82, 'uts' => 78, 'uas' => 80, 'rata' => 80],
            ['mapel' => 'Bahasa Indonesia', 'tugas' => 85, 'uts' => 88, 'uas' => 82, 'rata' => 85],
            ['mapel' => 'Bahasa Inggris', 'tugas' => 78, 'uts' => 80, 'uas' => 75, 'rata' => 78],
        ]
    ],
    [
        'nama' => 'Siti Aminah', 'nisn' => '0098765432', 'kelas' => 'XI TKJ 1',
        'nilai' => [
            ['mapel' => 'Jaringan Komputer', 'tugas' => 72, 'uts' => 68, 'uas' => 70, 'rata' => 70],
            ['mapel' => 'Pemrograman Dasar', 'tugas' => 65, 'uts' => 70, 'uas' => 68, 'rata' => 68],
            ['mapel' => 'Matematika', 'tugas' => 75, 'uts' => 72, 'uas' => 72, 'rata' => 73],
            ['mapel' => 'Bahasa Indonesia', 'tugas' => 80, 'uts' => 78, 'uas' => 82, 'rata' => 80],
            ['mapel' => 'Bahasa Inggris', 'tugas' => 70, 'uts' => 65, 'uas' => 72, 'rata' => 69],
        ]
    ],
    [
        'nama' => 'Budi Prasetyo', 'nisn' => '0056789012', 'kelas' => 'X RPL 1',
        'nilai' => [
            ['mapel' => 'Pemrograman Dasar', 'tugas' => 95, 'uts' => 90, 'uas' => 92, 'rata' => 92],
            ['mapel' => 'Basis Data', 'tugas' => 88, 'uts' => 85, 'uas' => 90, 'rata' => 88],
            ['mapel' => 'Matematika', 'tugas' => 90, 'uts' => 88, 'uas' => 92, 'rata' => 90],
            ['mapel' => 'Bahasa Indonesia', 'tugas' => 82, 'uts' => 85, 'uas' => 80, 'rata' => 82],
            ['mapel' => 'Bahasa Inggris', 'tugas' => 85, 'uts' => 82, 'uas' => 88, 'rata' => 85],
        ]
    ],
];
@endphp

<div class="max-w-7xl mx-auto" x-data="raporApp()" x-init="init()">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-rose-600 flex items-center justify-center shadow-lg shadow-orange-200">
					<i data-lucide="file-text" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Rapor Siswa</h1>
					<p class="text-gray-400 text-xs">Lihat hasil belajar siswa per semester — Tahun Ajaran 2025/2026</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Filter Card -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-6">
		<div class="flex items-center gap-2 mb-3">
			<i data-lucide="filter" class="w-4 h-4 text-orange-500"></i>
			<span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Filter Rapor</span>
		</div>
		<div class="flex flex-wrap items-end gap-3">
			<div class="flex-1 min-w-[180px]">
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kelas</label>
				<select x-model="selectedKelas" @change="filterSiswa()" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all">
					<option value="">Pilih Kelas</option>
					@foreach($kelasList as $k)
						<option value="{{ $k }}">{{ $k }}</option>
					@endforeach
				</select>
			</div>
			<div class="flex-1 min-w-[180px]">
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Siswa</label>
				<select x-model="selectedSiswa" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all">
					<option value="">Pilih Siswa</option>
					<template x-for="s in filteredSiswa" :key="s.nama">
						<option :value="s.nama" x-text="s.nama"></option>
					</template>
				</select>
			</div>
			<div class="flex-1 min-w-[140px]">
				<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Semester</label>
				<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all">
					<option>Semester 1 (Ganjil)</option>
					<option>Semester 2 (Genap)</option>
				</select>
			</div>
			<button @click="tampilkanRapor()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-orange-500 to-rose-600 hover:from-orange-600 hover:to-rose-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-200 transition-all active:scale-95">
				<i data-lucide="search" class="w-4 h-4"></i>
				Tampilkan
			</button>
		</div>
	</div>

	<!-- Empty State -->
	<div x-show="!showRapor" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-12 text-center">
		<div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center mx-auto mb-4">
			<i data-lucide="file-search" class="w-8 h-8 text-orange-300"></i>
		</div>
		<h3 class="text-lg font-bold text-gray-400 mb-1">Belum Ada Rapor Ditampilkan</h3>
		<p class="text-sm text-gray-400">Pilih kelas dan siswa terlebih dahulu, lalu klik <strong>Tampilkan</strong></p>
	</div>

	<!-- Rapor Card -->
	<div x-show="showRapor" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-5">

		<!-- Student Info Card -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="bg-gradient-to-r from-orange-500 to-rose-600 px-6 py-4">
				<div class="flex items-center justify-between">
					<div class="flex items-center gap-4">
						<div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
							<span class="text-white text-xl font-extrabold" x-text="currentSiswa ? currentSiswa.nama.split(' ').map(w=>w[0]).join('') : ''"></span>
						</div>
						<div>
							<h2 class="text-white text-lg font-extrabold" x-text="currentSiswa?.nama"></h2>
							<div class="flex items-center gap-3 mt-1">
								<span class="text-orange-200 text-xs">NISN: <span class="text-white font-semibold" x-text="currentSiswa?.nisn"></span></span>
								<span class="text-orange-200 text-xs">Kelas: <span class="text-white font-semibold" x-text="currentSiswa?.kelas"></span></span>
							</div>
						</div>
					</div>
					<button onclick="window.print()" class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-sm font-semibold transition-all">
						<i data-lucide="printer" class="w-4 h-4"></i> Cetak
					</button>
				</div>
			</div>

			<!-- Summary Stats -->
			<div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100">
				<div class="p-4 text-center">
					<p class="text-2xl font-extrabold" :class="rataRata >= 80 ? 'text-emerald-600' : (rataRata >= 75 ? 'text-blue-600' : 'text-red-500')" x-text="rataRata"></p>
					<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Rata-rata</p>
				</div>
				<div class="p-4 text-center">
					<p class="text-2xl font-extrabold text-emerald-600" x-text="totalLulus"></p>
					<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Mapel Lulus</p>
				</div>
				<div class="p-4 text-center">
					<p class="text-2xl font-extrabold" :class="totalRemedial > 0 ? 'text-amber-500' : 'text-gray-300'" x-text="totalRemedial"></p>
					<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Remedial</p>
				</div>
			</div>
		</div>

		<!-- Nilai Table -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
				<div class="flex items-center gap-2">
					<i data-lucide="table" class="w-4 h-4 text-orange-500"></i>
					<span class="text-sm font-bold text-gray-700">Detail Nilai Per Mata Pelajaran</span>
				</div>
				<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">KKM: 75</span>
			</div>
			<div class="overflow-x-auto">
				<table class="min-w-full text-sm">
					<thead>
						<tr class="bg-gray-50/80">
							<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider w-8">No</th>
							<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
							<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tugas</th>
							<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UTS</th>
							<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UAS</th>
							<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rata²</th>
							<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ket</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-50">
						<template x-for="(n, idx) in currentSiswa?.nilai || []" :key="idx">
							<tr class="hover:bg-orange-50/20 transition-colors">
								<td class="px-5 py-3 text-xs text-gray-400" x-text="idx + 1"></td>
								<td class="px-5 py-3 font-semibold text-gray-800" x-text="n.mapel"></td>
								<td class="px-5 py-3 text-center">
									<span class="text-sm font-medium" :class="n.tugas >= 75 ? 'text-gray-700' : 'text-red-500'" x-text="n.tugas"></span>
								</td>
								<td class="px-5 py-3 text-center">
									<span class="text-sm font-medium" :class="n.uts >= 75 ? 'text-gray-700' : 'text-red-500'" x-text="n.uts"></span>
								</td>
								<td class="px-5 py-3 text-center">
									<span class="text-sm font-medium" :class="n.uas >= 75 ? 'text-gray-700' : 'text-red-500'" x-text="n.uas"></span>
								</td>
								<td class="px-5 py-3 text-center">
									<span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-extrabold" :class="n.rata >= 85 ? 'bg-emerald-100 text-emerald-700' : (n.rata >= 75 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600')" x-text="n.rata"></span>
								</td>
								<td class="px-5 py-3 text-center">
									<span x-show="n.rata >= 75" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-100">
										<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lulus
									</span>
									<span x-show="n.rata < 75" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">
										<span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Remedial
									</span>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>

			<!-- Footer Summary -->
			<div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
				<div class="flex items-center gap-3">
					<span class="text-xs text-gray-500 font-medium">Status Akhir:</span>
					<span x-show="rataRata >= 75" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-extrabold uppercase tracking-wider border border-emerald-200">
						<i data-lucide="check-circle-2" class="w-4 h-4"></i> Naik Kelas
					</span>
					<span x-show="rataRata < 75" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-amber-100 text-amber-700 text-xs font-extrabold uppercase tracking-wider border border-amber-200">
						<i data-lucide="alert-triangle" class="w-4 h-4"></i> Perlu Perhatian
					</span>
				</div>
				<div class="text-right">
					<p class="text-[10px] text-gray-400">Semester 1 — TA 2025/2026</p>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@push('scripts')
<script>
const dataSiswa = @json($siswa);

function raporApp() {
	return {
		selectedKelas: '',
		selectedSiswa: '',
		showRapor: false,
		currentSiswa: null,
		filteredSiswa: [],
		rataRata: 0,
		totalLulus: 0,
		totalRemedial: 0,

		init() {
			this.filteredSiswa = dataSiswa;
		},

		filterSiswa() {
			this.selectedSiswa = '';
			this.showRapor = false;
			if (this.selectedKelas === '') {
				this.filteredSiswa = dataSiswa;
			} else {
				this.filteredSiswa = dataSiswa.filter(s => s.kelas === this.selectedKelas);
			}
		},

		tampilkanRapor() {
			const siswa = dataSiswa.find(s => s.nama === this.selectedSiswa);
			if (!siswa) return;

			this.currentSiswa = siswa;
			const total = siswa.nilai.reduce((sum, n) => sum + n.rata, 0);
			this.rataRata = Math.round(total / siswa.nilai.length);
			this.totalLulus = siswa.nilai.filter(n => n.rata >= 75).length;
			this.totalRemedial = siswa.nilai.filter(n => n.rata < 75).length;
			this.showRapor = true;

			this.$nextTick(() => {
				if (window.lucide) lucide.createIcons();
			});
		}
	};
}

document.addEventListener('DOMContentLoaded', function() {
	if (window.lucide) lucide.createIcons();
});
</script>
@endpush
