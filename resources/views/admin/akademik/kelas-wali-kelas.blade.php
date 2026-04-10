@extends('layouts.admin')

@section('title', 'Kelas & Wali Kelas')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ 
	showForm: false, 
	isEdit: false, 
	formAction: '{{ route('admin.akademik.kelas-wali-kelas.store') }}',
	formMethod: 'POST',
	kelas: {
		tingkat: '',
		nama_kelas: '',
		teacher_id: '',
		tahun_ajaran: ''
	},
	edit(k) {
		this.isEdit = true;
		this.showForm = true;
		this.formAction = '/admin/akademik/kelas-wali-kelas/' + k.id;
		this.formMethod = 'PUT';
		this.kelas = {
			tingkat: k.tingkat,
			nama_kelas: k.nama_kelas,
			teacher_id: k.teacher_id,
			tahun_ajaran: k.tahun_ajaran
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('admin.akademik.kelas-wali-kelas.store') }}';
		this.formMethod = 'POST';
		this.kelas = {tingkat: '', nama_kelas: '', teacher_id: '', tahun_ajaran: ''};
	}
}">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200">
					<i data-lucide="users" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Kelas & Wali Kelas</h1>
					<p class="text-gray-400 text-xs">Kelola data kelas dan penempatan wali kelas</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all active:scale-95">
			<i data-lucide="plus" class="w-4 h-4"></i>
			Tambah Kelas
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

	<!-- Stats Cards -->
	<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
					<i data-lucide="layout-grid" class="w-4 h-4 text-indigo-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalKelas }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Kelas</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
					<i data-lucide="users" class="w-4 h-4 text-purple-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalSiswa }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Siswa</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
					<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-emerald-600">{{ $totalDenganWali }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Ada Wali Kelas</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
					<i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
				</div>
				<span class="text-2xl font-extrabold text-red-500">{{ $totalTanpaWali }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Belum Ada Wali</p>
		</div>
	</div>

	<!-- Filter Bar -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
		<form method="GET" class="flex flex-wrap items-center gap-3">
			<div class="relative flex-1 min-w-[200px]">
				<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
					<i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
				</div>
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 focus:bg-white transition-all">
			</div>
			<select name="tingkat" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all min-w-[140px]">
				<option value="">Semua Tingkat</option>
				@foreach($daftarTingkat as $t)
					<option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
				@endforeach
			</select>
			<select name="tahun_ajaran" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all min-w-[150px]">
				<option value="">Semua Tahun Ajaran</option>
				@foreach($daftarTahunAjaran as $ta)
					<option value="{{ $ta }}" {{ request('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
				@endforeach
			</select>
			<button type="submit" class="px-4 py-2.5 bg-indigo-50 text-indigo-600 font-bold text-sm rounded-xl hover:bg-indigo-100 transition-all border border-indigo-100">
				Filter
			</button>
			<a href="{{ route('admin.akademik.kelas-wali-kelas') }}" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
				Reset
			</a>
		</form>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="list" class="w-4 h-4 text-indigo-500"></i>
				<span class="text-sm font-bold text-gray-700">Daftar Kelas</span>
			</div>
			<span class="text-xs text-gray-400">{{ $kelas->total() }} data</span>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tingkat</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Kelas</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Wali Kelas</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Siswa</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tahun Ajaran</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@forelse($kelas as $k)
					<tr class="hover:bg-indigo-50/30 transition-colors">
						<td class="px-5 py-3.5 text-center">
							<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">{{ $k->tingkat }}</span>
						</td>
						<td class="px-5 py-3.5">
							<span class="font-bold text-gray-800">{{ $k->nama_kelas }}</span>
						</td>
						<td class="px-5 py-3.5">
							@if($k->teacher)
								<div class="flex items-center gap-2">
									<div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs uppercase">{{ substr($k->teacher->nama, 0, 1) }}</div>
									<div>
										<p class="font-medium text-gray-800 text-xs">{{ $k->teacher->nama }}</p>
									</div>
								</div>
							@else
								<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-600 border border-red-100">Belum Ada Wali</span>
							@endif
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-600">
								0 Siswa
							</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="text-xs font-medium text-gray-600">{{ $k->tahun_ajaran }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								<button @click="edit({{ json_encode($k) }})" class="w-8 h-8 rounded-lg bg-indigo-50 hover:bg-indigo-100 flex items-center justify-center transition-colors group" title="Edit">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-700"></i>
								</button>
								<form action="{{ route('admin.akademik.kelas-wali-kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
						<td colspan="6" class="px-5 py-10 text-center text-gray-500 text-sm">Tidak ada data kelas</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<!-- Pagination -->
		<div class="px-5 py-3 border-t border-gray-100">
			{{ $kelas->links('pagination::tailwind') }}
		</div>
	</div>

	<!-- Form Tambah/Edit (Slide down) -->
	<div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="plus-square" class="w-5 h-5 text-indigo-200" x-show="!isEdit"></i>
					<i data-lucide="edit" class="w-5 h-5 text-indigo-200" x-show="isEdit" style="display: none;"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider" x-text="isEdit ? 'Edit Data Kelas' : 'Tambah Data Kelas'"></span>
				</div>
			</div>
			<form :action="formAction" method="POST" class="p-6">
				@csrf
				<template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
				<div class="space-y-4">
					<div class="grid grid-cols-2 gap-4">
						<div>
							<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tingkat <span class="text-red-400">*</span></label>
							<input name="tingkat" x-model="kelas.tingkat" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Misal: X, XI, XII">
						</div>
						<div>
							<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun Ajaran <span class="text-red-400">*</span></label>
							<input name="tahun_ajaran" x-model="kelas.tahun_ajaran" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Misal: 2024/2025">
						</div>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Kelas <span class="text-red-400">*</span></label>
						<input name="nama_kelas" x-model="kelas.nama_kelas" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Misal: X IPA 1">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Wali Kelas (Opsional)</label>
						<select name="teacher_id" x-model="kelas.teacher_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
							<option value="">Pilih Guru...</option>
							@foreach($teachers as $teacher)
								<option value="{{ $teacher->id }}">{{ $teacher->nama }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="flex justify-end gap-2.5 mt-6 pt-5 border-t border-gray-100">
					<button type="button" @click="resetForm()" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</button>
					<button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all active:scale-95">
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
