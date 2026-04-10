@extends('layouts.admin')

@section('title', 'Data Guru & Staf')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ 
	showForm: false, 
	isEdit: false, 
	formAction: '{{ route('admin.kepegawaian.data-guru.store') }}',
	formMethod: 'POST',
	guru: {
		nip: '',
		nama: '',
		telepon: ''
	},
	edit(g) {
		this.isEdit = true;
		this.showForm = true;
		this.formAction = '/admin/kepegawaian/data-guru/' + g.id;
		this.formMethod = 'PUT';
		this.guru = {
			nip: g.nip,
			nama: g.nama,
			telepon: g.telepon
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('admin.kepegawaian.data-guru.store') }}';
		this.formMethod = 'POST';
		this.guru = {nip: '', nama: '', telepon: ''};
	}
}">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
					<i data-lucide="users" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Data Guru</h1>
					<p class="text-gray-400 text-xs">Kelola data informasi guru sekolah</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
			<i data-lucide="user-plus" class="w-4 h-4"></i>
			Tambah Guru
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
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all">
			</div>
			
			<button type="submit" class="px-4 py-2.5 bg-blue-50 text-blue-600 font-bold text-sm rounded-xl hover:bg-blue-100 transition-all border border-blue-100">
				Cari
			</button>
			<a href="{{ route('admin.kepegawaian.data-guru') }}" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
				Reset
			</a>
		</form>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="list" class="w-4 h-4 text-blue-500"></i>
				<span class="text-sm font-bold text-gray-700">Daftar Guru ({{ $totalGuru }})</span>
			</div>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIP</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Guru</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">No. Telepon</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@forelse($guru as $g)
					<tr class="hover:bg-blue-50/30 transition-colors">
						<td class="px-5 py-3.5 text-xs text-gray-600">{{ $g->nip ?: '-' }}</td>
						<td class="px-5 py-3.5 font-semibold text-gray-800">{{ $g->nama }}</td>
						<td class="px-5 py-3.5 text-xs text-gray-600">{{ $g->telepon ?: '-' }}</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								<button @click="edit({{ json_encode($g) }})" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors group" title="Edit">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-blue-500 group-hover:text-blue-700"></i>
								</button>
								<form action="{{ route('admin.kepegawaian.data-guru.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
						<td colspan="4" class="px-5 py-10 text-center text-gray-500 text-sm">Tidak ada data guru</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<!-- Pagination -->
		<div class="px-5 py-3 border-t border-gray-100">
			{{ $guru->links('pagination::tailwind') }}
		</div>
	</div>

	<!-- Form Tambah/Edit (Slide down) -->
	<div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="user-plus" class="w-5 h-5 text-blue-200" x-show="!isEdit"></i>
					<i data-lucide="edit" class="w-5 h-5 text-blue-200" x-show="isEdit" style="display: none;"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider" x-text="isEdit ? 'Edit Data Guru' : 'Tambah Data Guru'"></span>
				</div>
			</div>
			<form :action="formAction" method="POST" class="p-6">
				@csrf
				<template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
				<div class="space-y-4">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NIP</label>
						<input name="nip" x-model="guru.nip" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all" placeholder="Nomor Induk Pegawai">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Guru <span class="text-red-400">*</span></label>
						<input name="nama" x-model="guru.nama" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all" placeholder="Nama Lengkap dengan Gelar">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">No. Telepon</label>
						<input name="telepon" x-model="guru.telepon" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all" placeholder="08xxx">
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
