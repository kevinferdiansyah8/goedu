
@extends('layouts.admin')

@section('title', 'Kelas & Wali Kelas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
	<!-- Breadcrumb -->
	<nav class="text-xs mb-4 flex items-center gap-2 text-gray-400" aria-label="Breadcrumb">
		<a href="/admin" class="hover:text-blue-600 transition flex items-center"><i data-lucide="home" class="inline w-4 h-4 mr-1"></i>Dashboard</a>
		<span>/</span>
		<a href="#" class="hover:text-blue-600 transition">Akademik</a>
		<span>/</span>
		<span class="text-gray-500">Kelas & Wali Kelas</span>
	</nav>
	<!-- Header -->
	<div class="mb-8 flex items-center gap-3">
		<div class="flex items-center justify-center bg-blue-100 rounded-xl w-12 h-12 mr-2">
			<i data-lucide="layers" class="w-7 h-7 text-blue-600"></i>
		</div>
		<div>
			<h1 class="text-3xl font-bold text-gray-900 mb-1">Kelas & Wali Kelas</h1>
			<p class="text-gray-500">Kelola data kelas dan penugasan wali kelas</p>
		</div>
	</div>
	<!-- Card Summary -->
	@php
		$kelas = [
			[
				'id' => 1,
				'nama_kelas' => 'X RPL 1',
				'tingkat' => 'X',
				'jurusan' => 'Rekayasa Perangkat Lunak',
				'wali_kelas' => 'Budi Santoso, S.Pd',
				'jumlah_siswa' => 32,
				'status' => 'Aktif',
			],
			[
				'id' => 2,
				'nama_kelas' => 'XI TKJ 2',
				'tingkat' => 'XI',
				'jurusan' => 'Teknik Komputer & Jaringan',
				'wali_kelas' => null,
				'jumlah_siswa' => 30,
				'status' => 'Aktif',
			],
			[
				'id' => 3,
				'nama_kelas' => 'XII AKL 1',
				'tingkat' => 'XII',
				'jurusan' => 'Akuntansi & Keuangan Lembaga',
				'wali_kelas' => 'Dewi Lestari, S.Pd',
				'jumlah_siswa' => 28,
				'status' => 'Tidak Aktif',
			],
		];
		$waliKelas = [
			[
				'nama' => 'Budi Santoso, S.Pd',
				'kelas_diampu' => 'X RPL 1',
			],
			[
				'nama' => 'Siti Aminah, S.Pd',
				'kelas_diampu' => 'XI TKJ 2',
			],
			[
				'nama' => 'Dewi Lestari, S.Pd',
				'kelas_diampu' => 'XII AKL 1',
			],
		];
		$totalKelas = count($kelas);
		$totalWali = count($waliKelas);
		$kelasAktif = collect($kelas)->where('status', 'Aktif')->count();
		$kelasTanpaWali = collect($kelas)->whereNull('wali_kelas')->count();
		$daftarJurusan = collect($kelas)->pluck('jurusan')->unique()->values();
		$daftarTingkat = collect($kelas)->pluck('tingkat')->unique()->values();
	@endphp
	<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-8">
		<div class="bg-white border rounded-xl shadow flex items-center gap-4 p-5">
			<div class="bg-blue-100 rounded-lg p-2"><i data-lucide="layers" class="w-6 h-6 text-blue-600"></i></div>
			<div>
				<div class="text-lg font-bold text-gray-900">{{ $totalKelas }}</div>
				<div class="text-xs text-gray-500">Total Kelas</div>
			</div>
		</div>
		<div class="bg-white border rounded-xl shadow flex items-center gap-4 p-5">
			<div class="bg-blue-100 rounded-lg p-2"><i data-lucide="users" class="w-6 h-6 text-blue-600"></i></div>
			<div>
				<div class="text-lg font-bold text-gray-900">{{ $totalWali }}</div>
				<div class="text-xs text-gray-500">Total Wali Kelas</div>
			</div>
		</div>
		<div class="bg-white border rounded-xl shadow flex items-center gap-4 p-5">
			<div class="bg-blue-100 rounded-lg p-2"><i data-lucide="check-circle-2" class="w-6 h-6 text-blue-600"></i></div>
			<div>
				<div class="text-lg font-bold text-gray-900">{{ $kelasAktif }}</div>
				<div class="text-xs text-gray-500">Kelas Aktif</div>
			</div>
		</div>
		<div class="bg-white border rounded-xl shadow flex items-center gap-4 p-5">
			<div class="bg-blue-100 rounded-lg p-2"><i data-lucide="alert-triangle" class="w-6 h-6 text-blue-600"></i></div>
			<div>
				<div class="text-lg font-bold text-gray-900">{{ $kelasTanpaWali }}</div>
				<div class="text-xs text-gray-500">Kelas Tanpa Wali</div>
			</div>
		</div>
	</div>
	<!-- Filter & Actions -->
	<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
		<div class="flex flex-wrap gap-4 items-center w-full md:w-auto">
			<input type="text" class="input min-w-[180px] md:min-w-[220px] w-full md:w-auto" placeholder="Cari kelas / wali...">
			<select class="input min-w-[170px] md:min-w-[200px] w-full md:w-auto">
				<option value="">Filter Jurusan</option>
				@foreach($daftarJurusan as $jurusan)
					<option value="{{ $jurusan }}">{{ $jurusan }}</option>
				@endforeach
			</select>
			<select class="input min-w-[130px] md:min-w-[150px] w-full md:w-auto">
				<option value="">Filter Tingkat</option>
				@foreach($daftarTingkat as $tingkat)
					<option value="{{ $tingkat }}">{{ $tingkat }}</option>
				@endforeach
			</select>
		</div>  
		<button
	type="button"
	onclick="toggleFormKelas()"
	class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition whitespace-nowrap">
			<i data-lucide="plus" class="w-5 h-5"></i>
			Tambah Kelas
		</button>
	</div>
	<!-- Tabel Data Kelas -->
	<div class="bg-white border rounded-2xl shadow p-6 overflow-x-auto mb-10">
		<table class="min-w-full text-sm">
			<thead>
				<tr class="bg-gray-50 text-gray-700">
					<th class="py-2 px-3 text-left">Nama Kelas</th>
					<th class="py-2 px-3 text-left">Tingkat</th>
					<th class="py-2 px-3 text-left">Jurusan</th>
					<th class="py-2 px-3 text-left">Wali Kelas</th>
					<th class="py-2 px-3 text-center">Jumlah Siswa</th>
					<th class="py-2 px-3 text-center">Status</th>
					<th class="py-2 px-3 text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($kelas as $k)
				<tr class="border-b last:border-0 hover:bg-blue-50/30">
					<td class="py-2 px-3 font-semibold">{{ $k['nama_kelas'] }}</td>
					<td class="py-2 px-3">{{ $k['tingkat'] }}</td>
					<td class="py-2 px-3">{{ $k['jurusan'] }}</td>
					<td class="py-2 px-3">{{ $k['wali_kelas'] ?? '-' }}</td>
					<td class="py-2 px-3 text-center">{{ $k['jumlah_siswa'] }}</td>
					<td class="py-2 px-3 text-center">
						@if($k['status'] === 'Aktif')
							<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium"><i data-lucide="check-circle" class="w-4 h-4"></i>Aktif</span>
						@else
							<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-xs font-medium"><i data-lucide="x-circle" class="w-4 h-4"></i>Tidak Aktif</span>
						@endif
					</td>
					<td class="py-2 px-3 text-center">
						<button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-gray-100 hover:bg-blue-100 text-blue-600 font-semibold text-xs mr-1"><i data-lucide="eye" class="w-4 h-4"></i>Detail</button>
						<button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs"><i data-lucide="edit-3" class="w-4 h-4"></i>Edit</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!-- Form Tambah/Edit Kelas (Card Inline) -->
	<div id="formKelas" class="max-w-2xl mx-auto mb-8 hidden">
		<div class="bg-white border rounded-2xl shadow p-8">
			<div class="flex items-center gap-2 mb-4">
				<i data-lucide="plus-square" class="w-5 h-5 text-blue-500"></i>
				<h2 class="text-lg font-semibold text-gray-800">Tambah / Edit Kelas</h2>
			</div>
			<form>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
						<input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Contoh: X RPL 1">
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
						<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option value="">Pilih Tingkat</option>
							<option value="X">X</option>
							<option value="XI">XI</option>
							<option value="XII">XII</option>
						</select>
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
						<input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Contoh: Rekayasa Perangkat Lunak">
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
						<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option value="">Pilih Wali Kelas</option>
							@foreach($waliKelas as $w)
								<option value="{{ $w['nama'] }}">{{ $w['nama'] }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Status Kelas</label>
						<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option value="Aktif">Aktif</option>
							<option value="Tidak Aktif">Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="flex justify-end gap-2 mt-8">
					<button
	type="button"
	onclick="toggleFormKelas()"
	class="px-6 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 font-semibold hover:bg-gray-100">
	Batal
</button>
					<button type="submit" class="flex items-center gap-2 px-7 py-2.5 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
						<i data-lucide="save" class="w-5 h-5"></i>
						Simpan
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

function toggleFormKelas() {
	const form = document.getElementById('formKelas');
	if (!form) return;

	form.classList.toggle('hidden');

	// scroll ke form kalau dibuka
	if (!form.classList.contains('hidden')) {
		form.scrollIntoView({ behavior: 'smooth', block: 'start' });
	}
}
</script>
@endpush
