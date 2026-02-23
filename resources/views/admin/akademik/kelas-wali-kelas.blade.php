@extends('layouts.admin')

@section('title', 'Kelas & Wali Kelas')

@section('content')
@php
$kelas = [
	['id' => 1, 'nama_kelas' => 'X RPL 1', 'tingkat' => 'X', 'jurusan' => 'Rekayasa Perangkat Lunak', 'wali_kelas' => 'Budi Santoso, S.Pd', 'jumlah_siswa' => 32, 'jumlah_laki' => 18, 'jumlah_perempuan' => 14, 'status' => 'Aktif'],
	['id' => 2, 'nama_kelas' => 'X RPL 2', 'tingkat' => 'X', 'jurusan' => 'Rekayasa Perangkat Lunak', 'wali_kelas' => 'Siti Aminah, S.Pd', 'jumlah_siswa' => 30, 'jumlah_laki' => 16, 'jumlah_perempuan' => 14, 'status' => 'Aktif'],
	['id' => 3, 'nama_kelas' => 'XI TKJ 1', 'tingkat' => 'XI', 'jurusan' => 'Teknik Komputer & Jaringan', 'wali_kelas' => null, 'jumlah_siswa' => 30, 'jumlah_laki' => 20, 'jumlah_perempuan' => 10, 'status' => 'Aktif'],
	['id' => 4, 'nama_kelas' => 'XI MM 1', 'tingkat' => 'XI', 'jurusan' => 'Multimedia', 'wali_kelas' => 'Rina Kartika, S.Pd', 'jumlah_siswa' => 28, 'jumlah_laki' => 12, 'jumlah_perempuan' => 16, 'status' => 'Aktif'],
	['id' => 5, 'nama_kelas' => 'XII AKL 1', 'tingkat' => 'XII', 'jurusan' => 'Akuntansi & Keuangan Lembaga', 'wali_kelas' => 'Dewi Lestari, S.Pd', 'jumlah_siswa' => 28, 'jumlah_laki' => 10, 'jumlah_perempuan' => 18, 'status' => 'Tidak Aktif'],
];
$waliKelas = [
	['nama' => 'Budi Santoso, S.Pd'],
	['nama' => 'Siti Aminah, S.Pd'],
	['nama' => 'Rina Kartika, S.Pd'],
	['nama' => 'Dewi Lestari, S.Pd'],
	['nama' => 'Hadi Prasetyo, S.Kom'],
];
$totalKelas = count($kelas);
$totalSiswa = collect($kelas)->sum('jumlah_siswa');
$kelasAktif = collect($kelas)->where('status', 'Aktif')->count();
$kelasTanpaWali = collect($kelas)->whereNull('wali_kelas')->count();
$daftarJurusan = collect($kelas)->pluck('jurusan')->unique()->values();
$daftarTingkat = collect($kelas)->pluck('tingkat')->unique()->values();
@endphp

<div class="max-w-7xl mx-auto" x-data="{ showForm: false }">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-200">
					<i data-lucide="layers" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Kelas & Wali Kelas</h1>
					<p class="text-gray-400 text-xs">Kelola data kelas, wali kelas, dan distribusi siswa</p>
				</div>
			</div>
		</div>
		<button @click="showForm = !showForm" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-violet-200 transition-all active:scale-95">
			<i data-lucide="plus" class="w-4 h-4"></i>
			Tambah Kelas
		</button>
	</div>

	<!-- Stats Cards -->
	<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
					<i data-lucide="layers" class="w-4 h-4 text-violet-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalKelas }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Kelas</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
					<i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-blue-600">{{ $totalSiswa }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Siswa</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
					<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-emerald-600">{{ $kelasAktif }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Kelas Aktif</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
					<i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
				</div>
				<span class="text-2xl font-extrabold text-amber-500">{{ $kelasTanpaWali }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Tanpa Wali</p>
		</div>
	</div>

	<!-- Filter Bar -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
		<div class="flex flex-wrap items-center gap-3">
			<div class="relative flex-1 min-w-[200px]">
				<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
					<i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
				</div>
				<input type="text" placeholder="Cari kelas atau wali kelas..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 focus:bg-white transition-all">
			</div>
			<select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all min-w-[180px]">
				<option value="">Semua Jurusan</option>
				@foreach($daftarJurusan as $j)
					<option>{{ $j }}</option>
				@endforeach
			</select>
			<select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all min-w-[130px]">
				<option value="">Semua Tingkat</option>
				@foreach($daftarTingkat as $t)
					<option>{{ $t }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="list" class="w-4 h-4 text-violet-500"></i>
				<span class="text-sm font-bold text-gray-700">Daftar Kelas</span>
			</div>
			<span class="text-xs text-gray-400">{{ count($kelas) }} kelas</span>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jurusan</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Wali Kelas</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Siswa</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@foreach($kelas as $k)
					<tr class="hover:bg-violet-50/20 transition-colors">
						<td class="px-5 py-3.5">
							<div class="flex items-center gap-3">
								<div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $k['tingkat'] === 'X' ? 'from-blue-500 to-indigo-600' : ($k['tingkat'] === 'XI' ? 'from-emerald-500 to-teal-600' : 'from-amber-500 to-orange-600') }} flex items-center justify-center shadow-sm">
									<span class="text-white text-[10px] font-extrabold">{{ $k['tingkat'] }}</span>
								</div>
								<div>
									<p class="font-bold text-gray-800">{{ $k['nama_kelas'] }}</p>
									<p class="text-[10px] text-gray-400">Tingkat {{ $k['tingkat'] }}</p>
								</div>
							</div>
						</td>
						<td class="px-5 py-3.5">
							<span class="text-xs text-gray-600">{{ $k['jurusan'] }}</span>
						</td>
						<td class="px-5 py-3.5">
							@if($k['wali_kelas'])
								<div class="flex items-center gap-2">
									<div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center">
										<i data-lucide="user" class="w-3.5 h-3.5 text-violet-600"></i>
									</div>
									<span class="text-xs font-medium text-gray-700">{{ $k['wali_kelas'] }}</span>
								</div>
							@else
								<span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full border border-amber-100">
									<i data-lucide="alert-circle" class="w-3 h-3"></i> Belum ditugaskan
								</span>
							@endif
						</td>
						<td class="px-5 py-3.5 text-center">
							<div>
								<span class="text-sm font-bold text-gray-800">{{ $k['jumlah_siswa'] }}</span>
								<div class="flex items-center justify-center gap-2 mt-0.5">
									<span class="text-[9px] text-blue-500 font-medium">♂ {{ $k['jumlah_laki'] }}</span>
									<span class="text-[9px] text-pink-500 font-medium">♀ {{ $k['jumlah_perempuan'] }}</span>
								</div>
							</div>
						</td>
						<td class="px-5 py-3.5 text-center">
							@if($k['status'] === 'Aktif')
								<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
									<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
								</span>
							@else
								<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider border border-red-100">
									<span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Non-Aktif
								</span>
							@endif
						</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								<button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-violet-100 flex items-center justify-center transition-colors group" title="Detail">
									<i data-lucide="eye" class="w-3.5 h-3.5 text-gray-400 group-hover:text-violet-600"></i>
								</button>
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
			<p class="text-xs text-gray-400">Menampilkan 1–{{ count($kelas) }} dari {{ count($kelas) }} kelas</p>
			<div class="flex gap-1">
				<button class="w-8 h-8 rounded-lg bg-violet-600 text-white text-xs font-bold">1</button>
			</div>
		</div>
	</div>

	<!-- Form Tambah (Slide down) -->
	<div x-show="showForm" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-2xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-violet-600 to-purple-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="plus-square" class="w-5 h-5 text-violet-200"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider">Tambah Kelas Baru</span>
				</div>
				<p class="text-violet-200 text-xs mt-1">Isi data kelas dan tetapkan wali kelas</p>
			</div>
			<form class="p-6">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Kelas <span class="text-red-400">*</span></label>
						<input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 focus:bg-white transition-all" placeholder="cth: XII RPL 1">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tingkat <span class="text-red-400">*</span></label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all">
							<option value="">Pilih Tingkat</option>
							<option>X</option><option>XI</option><option>XII</option>
						</select>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jurusan <span class="text-red-400">*</span></label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all">
							<option value="">Pilih Jurusan</option>
							@foreach($daftarJurusan as $j)
								<option>{{ $j }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Wali Kelas</label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all">
							<option value="">Pilih Wali Kelas</option>
							@foreach($waliKelas as $w)
								<option>{{ $w['nama'] }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition-all">
							<option>Aktif</option>
							<option>Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="flex justify-end gap-2.5 mt-6 pt-5 border-t border-gray-100">
					<button type="button" @click="showForm = false" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</button>
					<button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-violet-200 transition-all active:scale-95">
						<i data-lucide="save" class="w-4 h-4"></i>
						Simpan Kelas
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
});
</script>
@endpush
