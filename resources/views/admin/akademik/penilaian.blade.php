@extends('layouts.admin')

@section('title', 'Penilaian')

@section('content')
@php
$kelasList = ['X RPL 1', 'X RPL 2', 'XI TKJ 1', 'XI MM 1', 'XII AKL 1'];
$mapelList = ['Pemrograman Dasar', 'Basis Data', 'Desain Grafis', 'Jaringan Komputer', 'Akuntansi Dasar'];
$nilai = [
    ['nama' => 'Andi Wijaya', 'kelas' => 'X RPL 1', 'mapel' => 'Pemrograman Dasar', 'tugas' => 88, 'uts' => 82, 'uas' => 85, 'rata' => 85, 'status' => 'Lulus'],
    ['nama' => 'Siti Aminah', 'kelas' => 'XI TKJ 1', 'mapel' => 'Basis Data', 'tugas' => 75, 'uts' => 68, 'uas' => 72, 'rata' => 72, 'status' => 'Remedial'],
    ['nama' => 'Budi Prasetyo', 'kelas' => 'X RPL 1', 'mapel' => 'Pemrograman Dasar', 'tugas' => 92, 'uts' => 90, 'uas' => 95, 'rata' => 92, 'status' => 'Lulus'],
    ['nama' => 'Dewi Lestari', 'kelas' => 'XI MM 1', 'mapel' => 'Desain Grafis', 'tugas' => 78, 'uts' => 80, 'uas' => 76, 'rata' => 78, 'status' => 'Lulus'],
    ['nama' => 'Rizky Fadillah', 'kelas' => 'XII AKL 1', 'mapel' => 'Akuntansi Dasar', 'tugas' => 60, 'uts' => 55, 'uas' => 65, 'rata' => 60, 'status' => 'Remedial'],
    ['nama' => 'Putri Rahayu', 'kelas' => 'X RPL 2', 'mapel' => 'Pemrograman Dasar', 'tugas' => 95, 'uts' => 88, 'uas' => 92, 'rata' => 92, 'status' => 'Lulus'],
];
$totalLulus = collect($nilai)->where('status', 'Lulus')->count();
$totalRemedial = collect($nilai)->where('status', 'Remedial')->count();
$rataRata = round(collect($nilai)->avg('rata'), 1);
@endphp

<div class="max-w-7xl mx-auto" x-data="{ showForm: false }">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-200">
					<i data-lucide="award" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Penilaian</h1>
					<p class="text-gray-400 text-xs">Kelola nilai siswa per kelas dan mata pelajaran</p>
				</div>
			</div>
		</div>
		<button @click="showForm = !showForm" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-200 transition-all active:scale-95">
			<i data-lucide="plus" class="w-4 h-4"></i>
			Tambah Nilai
		</button>
	</div>

	<!-- Stats Cards -->
	<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
					<i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ count($nilai) }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Data</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
					<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-emerald-600">{{ $totalLulus }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Lulus</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
					<i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
				</div>
				<span class="text-2xl font-extrabold text-amber-500">{{ $totalRemedial }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Remedial</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
					<i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-indigo-600">{{ $rataRata }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Rata-rata</p>
		</div>
	</div>

	<!-- Filter Bar -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
		<div class="flex flex-wrap items-center gap-3">
			<div class="relative flex-1 min-w-[200px]">
				<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
					<i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
				</div>
				<input type="text" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
			</div>
			<select id="filterKelas" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all min-w-[150px]">
				<option value="">Semua Kelas</option>
				@foreach($kelasList as $k)
					<option>{{ $k }}</option>
				@endforeach
			</select>
			<select id="filterMapel" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all min-w-[180px]">
				<option value="">Semua Mapel</option>
				@foreach($mapelList as $m)
					<option>{{ $m }}</option>
				@endforeach
			</select>
			<select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all min-w-[130px]">
				<option value="">Semua Status</option>
				<option>Lulus</option>
				<option>Remedial</option>
			</select>
		</div>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-500"></i>
				<span class="text-sm font-bold text-gray-700">Data Penilaian</span>
			</div>
			<span class="text-xs text-gray-400">KKM: <strong class="text-gray-600">75</strong></span>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Siswa</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tugas</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UTS</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">UAS</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rata²</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody id="nilaiTable" class="divide-y divide-gray-50">
					@foreach($nilai as $n)
					<tr class="hover:bg-emerald-50/20 transition-colors" data-kelas="{{ $n['kelas'] }}" data-mapel="{{ $n['mapel'] }}">
						<td class="px-5 py-3.5">
							<div class="flex items-center gap-2.5">
								<div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $n['status'] === 'Lulus' ? 'from-emerald-400 to-teal-500' : 'from-amber-400 to-orange-500' }} flex items-center justify-center">
									<span class="text-white text-[10px] font-extrabold">{{ strtoupper(substr($n['nama'], 0, 2)) }}</span>
								</div>
								<span class="font-semibold text-gray-800">{{ $n['nama'] }}</span>
							</div>
						</td>
						<td class="px-5 py-3.5">
							<span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold">{{ $n['kelas'] }}</span>
						</td>
						<td class="px-5 py-3.5">
							<span class="text-xs text-gray-600">{{ $n['mapel'] }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="text-sm font-medium {{ $n['tugas'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['tugas'] }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="text-sm font-medium {{ $n['uts'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['uts'] }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="text-sm font-medium {{ $n['uas'] >= 75 ? 'text-gray-700' : 'text-red-500' }}">{{ $n['uas'] }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-extrabold {{ $n['rata'] >= 85 ? 'bg-emerald-100 text-emerald-700' : ($n['rata'] >= 75 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600') }}">
								{{ $n['rata'] }}
							</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							@if($n['status'] === 'Lulus')
								<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
									<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lulus
								</span>
							@else
								<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider border border-amber-100">
									<span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Remedial
								</span>
							@endif
						</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								<button class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors group" title="Edit">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-blue-500 group-hover:text-blue-700"></i>
								</button>
								<button class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors group" title="Hapus">
									<i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-400 group-hover:text-red-600"></i>
								</button>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
			<p class="text-xs text-gray-400">Menampilkan 1–{{ count($nilai) }} dari {{ count($nilai) }} data</p>
			<div class="flex gap-1">
				<button class="w-8 h-8 rounded-lg bg-emerald-600 text-white text-xs font-bold">1</button>
			</div>
		</div>
	</div>

	<!-- Form Tambah Nilai -->
	<div x-show="showForm" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-2xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="clipboard-edit" class="w-5 h-5 text-emerald-200"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider">Input Nilai Baru</span>
				</div>
				<p class="text-emerald-200 text-xs mt-1">Masukkan nilai tugas, UTS, dan UAS untuk siswa</p>
			</div>
			<form class="p-6">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Siswa <span class="text-red-400">*</span></label>
						<input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all" placeholder="Nama siswa">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kelas <span class="text-red-400">*</span></label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all">
							<option value="">Pilih Kelas</option>
							@foreach($kelasList as $k)
								<option>{{ $k }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Mata Pelajaran <span class="text-red-400">*</span></label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 transition-all">
							<option value="">Pilih Mapel</option>
							@foreach($mapelList as $m)
								<option>{{ $m }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nilai Tugas</label>
						<input type="number" min="0" max="100" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all" placeholder="0–100">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nilai UTS</label>
						<input type="number" min="0" max="100" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all" placeholder="0–100">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nilai UAS</label>
						<input type="number" min="0" max="100" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all" placeholder="0–100">
					</div>
				</div>
				<div class="flex justify-end gap-2.5 mt-6 pt-5 border-t border-gray-100">
					<button type="button" @click="showForm = false" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</button>
					<button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-200 transition-all active:scale-95">
						<i data-lucide="save" class="w-4 h-4"></i>
						Simpan Nilai
					</button>
				</div>
			</form>
		</div>
	</div>

</div>
@endsection

@push('scripts')
<script>
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
