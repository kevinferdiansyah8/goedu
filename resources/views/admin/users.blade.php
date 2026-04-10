@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ 
	showForm: false, 
	isEdit: false, 
	formAction: '{{ route('admin.users.store') }}',
	formMethod: 'POST',
	siswa: {
		nis: '',
		nisn: '',
		nama: '',
		kelas: '',
		jenis_kelamin: '',
		telepon: ''
	},
	edit(s) {
		this.isEdit = true;
		this.showForm = true;
		this.formAction = '/admin/users/' + s.id;
		this.formMethod = 'PUT';
		this.siswa = {
			nis: s.nis,
			nisn: s.nisn,
			nama: s.nama,
			kelas: s.kelas,
			jenis_kelamin: s.jenis_kelamin,
			telepon: s.telepon
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('admin.users.store') }}';
		this.formMethod = 'POST';
		this.siswa = {nis: '', nisn: '', nama: '', kelas: '', jenis_kelamin: '', telepon: ''};
	}
}">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center shadow-lg shadow-indigo-200">
					<i data-lucide="graduation-cap" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Data Siswa (Users)</h1>
					<p class="text-gray-400 text-xs">Kelola data siswa</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
			<i data-lucide="user-plus" class="w-4 h-4"></i>
			Tambah Siswa
		</button>
	</div>

	<!-- Alerts -->
	@if(session('success'))
	<div class="mb-4 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
		<i data-lucide="check-circle" class="w-5 h-5"></i>
		<div>{{ session('success') }}</div>
	</div>
	@endif
	@if($errors->any())
	<div class="mb-4 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 flex items-center gap-3">
		<i data-lucide="alert-circle" class="w-5 h-5"></i>
		<div>
			<ul class="list-disc pl-5">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif

	<!-- Filter Bar -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
		<form method="GET" class="flex flex-wrap items-center gap-3">
			<div class="relative flex-1 min-w-[200px]">
				<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
					<i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
				</div>
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, atau NISN..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 focus:bg-white transition-all">
			</div>
			
			<select name="kelas" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all min-w-[140px]">
				<option value="">Semua Kelas</option>
				@foreach($daftarKelas as $k)
					<option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
				@endforeach
			</select>

			<button type="submit" class="px-4 py-2.5 bg-indigo-50 text-indigo-600 font-bold text-sm rounded-xl hover:bg-indigo-100 transition-all border border-indigo-100">
				Filter
			</button>
			<a href="{{ route('admin.users') }}" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
				Reset
			</a>
		</form>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="list" class="w-4 h-4 text-indigo-500"></i>
				<span class="text-sm font-bold text-gray-700">Daftar Siswa ({{ $totalSiswa }})</span>
			</div>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIS / NISN</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Siswa</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">L/P</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@forelse($siswa as $s)
					<tr class="hover:bg-indigo-50/30 transition-colors">
						<td class="px-5 py-3.5">
							<span class="text-xs font-bold text-blue-700">{{ $s->nis }}</span><br>
							<span class="text-[10px] text-gray-500">{{ $s->nisn ?: '-' }}</span>
						</td>
						<td class="px-5 py-3.5 font-semibold text-gray-800">{{ $s->nama }}</td>
						<td class="px-5 py-3.5">
							<span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">{{ $s->kelas }}</span>
						</td>
						<td class="px-5 py-3.5 text-xs text-gray-600">{{ $s->jenis_kelamin ?: '-' }}</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								<button @click="edit({{ json_encode($s) }})" class="w-8 h-8 rounded-lg bg-indigo-50 hover:bg-indigo-100 flex items-center justify-center transition-colors group" title="Edit">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-700"></i>
								</button>
								<form action="{{ route('admin.users.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
									@csrf
									@method('DELETE')
									<button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors group" title="Hapus">
										<i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500 group-hover:text-red-700"></i>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="5" class="px-5 py-10 text-center text-gray-500 text-sm">Tidak ada data siswa</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<!-- Pagination -->
		<div class="px-5 py-3 border-t border-gray-100">
			{{ $siswa->links('pagination::tailwind') }}
		</div>
	</div>

	<!-- Form Tambah/Edit (Slide down) -->
	<div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-2xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="user-plus" class="w-5 h-5 text-indigo-200" x-show="!isEdit"></i>
					<i data-lucide="edit" class="w-5 h-5 text-indigo-200" x-show="isEdit" style="display: none;"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider" x-text="isEdit ? 'Edit Data Siswa' : 'Tambah Data Siswa'"></span>
				</div>
			</div>
			<form :action="formAction" method="POST" class="p-6">
				@csrf
				<template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NIS <span class="text-red-400">*</span></label>
						<input name="nis" x-model="siswa.nis" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Nomor Induk Siswa">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NISN</label>
						<input name="nisn" x-model="siswa.nisn" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Nomor Induk Siswa Nasional">
					</div>
					<div class="md:col-span-2">
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
						<input name="nama" x-model="siswa.nama" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Nama Siswa">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kelas <span class="text-red-400">*</span></label>
						<!-- Fallback to input for flexibility -->
						<input name="kelas" x-model="siswa.kelas" required list="daftar-kelas-list" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Ketik kelas (Misal: X IPA 1)">
						<datalist id="daftar-kelas-list">
							@foreach($daftarKelas as $k)
								<option value="{{ $k }}">
							@endforeach
						</datalist>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
						<select name="jenis_kelamin" x-model="siswa.jenis_kelamin" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
							<option value="">Pilih L/P</option>
							<option value="L">Laki-laki (L)</option>
							<option value="P">Perempuan (P)</option>
						</select>
					</div>
					<div class="md:col-span-2">
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">No Telepon/WA</label>
						<input name="telepon" x-model="siswa.telepon" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="08xxxx">
					</div>
				</div>
				<div class="flex justify-end gap-2.5 mt-6 pt-5 border-t border-gray-100">
					<button type="button" @click="resetForm()" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</button>
					<button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
						<i data-lucide="save" class="w-4 h-4"></i>
						Simpan Data
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