@extends('layouts.admin')

@section('title', 'Mata Pelajaran')

@section('content')
@php
$mataPelajaran = [
	[
		'id' => 1,
		'nama' => 'Pemrograman Dasar',
		'kode' => 'MP001',
		'jurusan' => 'Rekayasa Perangkat Lunak',
		'tingkat' => 'X',
		'jumlah_jam' => 4,
		'status' => 'Aktif'
	],
	[
		'id' => 2,
		'nama' => 'Basis Data',
		'kode' => 'MP002',
		'jurusan' => 'Rekayasa Perangkat Lunak',
		'tingkat' => 'XI',
		'jumlah_jam' => 3,
		'status' => 'Aktif'
	],
	[
		'id' => 3,
		'nama' => 'Akuntansi Dasar',
		'kode' => 'MP003',
		'jurusan' => 'Akuntansi & Keuangan Lembaga',
		'tingkat' => 'X',
		'jumlah_jam' => 4,
		'status' => 'Tidak Aktif'
	],
];
$daftarJurusan = collect($mataPelajaran)->pluck('jurusan')->unique();
$daftarTingkat = collect($mataPelajaran)->pluck('tingkat')->unique();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
	<!-- HEADER -->
	<div class="mb-8">
		<h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 flex items-center gap-2">
			<i data-lucide="book-open" class="w-8 h-8 text-blue-600"></i>
			Mata Pelajaran
		</h1>
		<p class="text-gray-500 text-base">Kelola data mata pelajaran berdasarkan jurusan dan tingkat</p>
	</div>
	<!-- ACTION BAR -->
	<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
		<div class="flex flex-wrap gap-3 bg-white border rounded-xl shadow-sm p-4">
			<input type="text" placeholder="Cari mata pelajaran..." class="px-4 py-2 border border-gray-300 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-blue-200 transition">
			<select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none w-48 transition">
				<option value="">Semua Jurusan</option>
				@foreach($daftarJurusan as $j)
					<option>{{ $j }}</option>
				@endforeach
			</select>
			<select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none w-40 transition">
				<option value="">Semua Tingkat</option>
				@foreach($daftarTingkat as $t)
					<option>{{ $t }}</option>
				@endforeach
			</select>
		</div>
		<button type="button" onclick="toggleFormMapel()" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-xl font-bold shadow hover:bg-blue-700 transition text-base">
			<i data-lucide="plus" class="w-5 h-5"></i>
			Tambah Mata Pelajaran
		</button>
	</div>
	<!-- TABLE -->
	<div class="bg-white border rounded-2xl shadow p-6 overflow-x-auto mb-10">
		<table class="min-w-full text-sm">
			<thead>
				<tr class="bg-gray-50 text-gray-600 uppercase text-xs">
					<th class="px-4 py-3 text-left">Kode</th>
					<th class="px-4 py-3 text-left">Nama Mata Pelajaran</th>
					<th class="px-4 py-3 text-left">Jurusan</th>
					<th class="px-4 py-3 text-center">Tingkat</th>
					<th class="px-4 py-3 text-center">Jam / Minggu</th>
					<th class="px-4 py-3 text-center">Status</th>
					<th class="px-4 py-3 text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($mataPelajaran as $mp)
				<tr class="border-b last:border-0 hover:bg-blue-50/40 transition">
					<td class="px-4 py-2 font-bold text-blue-700">{{ $mp['kode'] }}</td>
					<td class="px-4 py-2 font-medium">{{ $mp['nama'] }}</td>
					<td class="px-4 py-2">{{ $mp['jurusan'] }}</td>
					<td class="px-4 py-2 text-center font-semibold">{{ $mp['tingkat'] }}</td>
					<td class="px-4 py-2 text-center">{{ $mp['jumlah_jam'] }}</td>
					<td class="px-4 py-2 text-center">
						@if($mp['status'] === 'Aktif')
							<span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold border border-green-100">
								<i data-lucide="check-circle" class="w-4 h-4"></i> Aktif
							</span>
						@else
							<span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold border border-gray-200">
								<i data-lucide="x-circle" class="w-4 h-4"></i> Tidak Aktif
							</span>
						@endif
					</td>
					<td class="px-4 py-2 text-center">
						<button class="inline-flex items-center gap-1 px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow transition">
							<i data-lucide="edit-3" class="w-4 h-4"></i> Edit
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!-- FORM TAMBAH / EDIT -->
	<div id="formMapel" class="max-w-2xl mx-auto hidden">
		<div class="bg-white border rounded-2xl shadow-lg p-8">
			<div class="flex items-center gap-2 mb-2">
				<i data-lucide="plus-square" class="w-5 h-5 text-blue-500"></i>
				<h2 class="text-xl font-bold">Tambah / Edit Mata Pelajaran</h2>
			</div>
			<p class="text-sm text-gray-500 mb-6">Isi data mata pelajaran sesuai jurusan dan tingkat</p>
			<form>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="text-sm font-medium mb-1 block">Kode Mapel</label>
						<input class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="MP001">
					</div>
					<div>
						<label class="text-sm font-medium mb-1 block">Nama Mapel</label>
						<input class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Pemrograman Dasar">
					</div>
					<div>
						<label class="text-sm font-medium mb-1 block">Jurusan</label>
						<select class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option value="">Pilih Jurusan</option>
							@foreach($daftarJurusan as $j)
								<option>{{ $j }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="text-sm font-medium mb-1 block">Tingkat</label>
						<select class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option value="">Pilih Tingkat</option>
							@foreach($daftarTingkat as $t)
								<option>{{ $t }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="text-sm font-medium mb-1 block">Jam / Minggu</label>
						<input type="number" class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="4">
					</div>
					<div>
						<label class="text-sm font-medium mb-1 block">Status</label>
						<select class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
							<option>Aktif</option>
							<option>Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="flex justify-end gap-2 mt-8">
					<button type="button" onclick="toggleFormMapel()" class="px-6 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-semibold hover:bg-gray-100">Batal</button>
					<button type="submit" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg font-bold shadow hover:bg-blue-700 transition">
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
function toggleFormMapel() {
	const form = document.getElementById('formMapel');
	form.classList.toggle('hidden');
	if (!form.classList.contains('hidden')) {
		form.scrollIntoView({ behavior: 'smooth', block: 'start' });
	}
}
document.addEventListener('DOMContentLoaded', function() {
	if (window.lucide) lucide.createIcons();
});
</script>
@endpush
