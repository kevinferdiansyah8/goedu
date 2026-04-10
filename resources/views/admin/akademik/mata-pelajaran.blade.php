@extends('layouts.admin')

@section('title', 'Mata Pelajaran')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ 
	showForm: false, 
	isEdit: false, 
	formAction: '{{ route('admin.akademik.mata-pelajaran.store') }}',
	formMethod: 'POST',
	mapel: {
		kode: '',
		nama: '',
		jurusan: '',
		tingkat: '',
		teacher_id: '',
		jumlah_jam: '',
		status: 'Aktif'
	},
	edit(m) {
		this.isEdit = true;
		this.showForm = true;
		this.formAction = '/admin/akademik/mata-pelajaran/' + m.id;
		this.formMethod = 'PUT';
		this.mapel = {
			kode: m.kode,
			nama: m.nama,
			jurusan: m.jurusan,
			tingkat: m.tingkat,
			teacher_id: m.teacher_id,
			jumlah_jam: m.jumlah_jam,
			status: m.status
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('admin.akademik.mata-pelajaran.store') }}';
		this.formMethod = 'POST';
		this.mapel = {kode: '', nama: '', jurusan: '', tingkat: '', teacher_id: '', jumlah_jam: '', status: 'Aktif'};
	}
}">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
					<i data-lucide="book-open" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Mata Pelajaran</h1>
					<p class="text-gray-400 text-xs">Kelola data mata pelajaran berdasarkan jurusan dan tingkat</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
			<i data-lucide="plus" class="w-4 h-4"></i>
			Tambah Mapel
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
				<div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
					<i data-lucide="book-open" class="w-4 h-4 text-blue-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalMapel }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Mapel</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
					<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-emerald-600">{{ $totalAktif }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Aktif</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
					<i data-lucide="x-circle" class="w-4 h-4 text-red-500"></i>
				</div>
				<span class="text-2xl font-extrabold text-red-500">{{ $totalNonAktif }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Non-Aktif</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
					<i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-amber-600">{{ $totalJam }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Jam/Minggu</p>
		</div>
	</div>

	<!-- Filter Bar -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 mb-5">
		<form method="GET" class="flex flex-wrap items-center gap-3">
			<div class="relative flex-1 min-w-[200px]">
				<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
					<i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
				</div>
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode mapel..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all">
			</div>
			<select name="jurusan" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all min-w-[180px]">
				<option value="">Semua Jurusan</option>
				@foreach($daftarJurusan as $j)
					<option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
				@endforeach
			</select>
			<select name="tingkat" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all min-w-[140px]">
				<option value="">Semua Tingkat</option>
				@foreach($daftarTingkat as $t)
					<option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
				@endforeach
			</select>
			<select name="status" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all min-w-[130px]">
				<option value="">Semua Status</option>
				<option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
				<option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
			</select>
			<button type="submit" class="px-4 py-2.5 bg-blue-50 text-blue-600 font-bold text-sm rounded-xl hover:bg-blue-100 transition-all border border-blue-100">
				Filter
			</button>
			<a href="{{ route('admin.akademik.mata-pelajaran') }}" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
				Reset
			</a>
		</form>
	</div>

	<!-- Table -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
		<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
			<div class="flex items-center gap-2">
				<i data-lucide="list" class="w-4 h-4 text-blue-500"></i>
				<span class="text-sm font-bold text-gray-700">Daftar Mata Pelajaran</span>
			</div>
			<span class="text-xs text-gray-400">{{ $mataPelajaran->total() }} data</span>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/80">
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kode</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jurusan</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tingkat</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jam</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
						<th class="px-5 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@forelse($mataPelajaran as $mp)
					<tr class="hover:bg-blue-50/30 transition-colors">
						<td class="px-5 py-3.5">
							<span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold">{{ $mp->kode }}</span>
						</td>
						<td class="px-5 py-3.5">
							<div>
								<p class="font-semibold text-gray-800">{{ $mp->nama }}</p>
								<p class="text-[11px] text-gray-400">Pengajar: {{ $mp->teacher ? $mp->teacher->nama : '-' }}</p>
							</div>
						</td>
						<td class="px-5 py-3.5">
							<span class="text-xs text-gray-600">{{ $mp->jurusan ?: '-' }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold">{{ $mp->tingkat }}</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							<span class="text-sm font-bold text-gray-700">{{ $mp->jumlah_jam }}</span>
							<span class="text-[10px] text-gray-400">/mggu</span>
						</td>
						<td class="px-5 py-3.5 text-center">
							@if($mp->status === 'Aktif')
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
								<button @click="edit({{ json_encode($mp) }})" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors group" title="Edit">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-blue-500 group-hover:text-blue-700"></i>
								</button>
								<form action="{{ route('admin.akademik.mata-pelajaran.destroy', $mp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
									@csrf
									@method('DELETE')
									<button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors group" title="Hapus">
										<i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-400 group-hover:text-red-600"></i>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7" class="px-5 py-10 text-center text-gray-500 text-sm">Tidak ada data mata pelajaran</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<!-- Pagination -->
		<div class="px-5 py-3 border-t border-gray-100">
			{{ $mataPelajaran->links('pagination::tailwind') }}
		</div>
	</div>

	<!-- Form Tambah/Edit (Slide down) -->
	<div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="max-w-2xl mx-auto mb-10">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
			<div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
				<div class="flex items-center gap-2">
					<i data-lucide="plus-square" class="w-5 h-5 text-blue-200" x-show="!isEdit"></i>
					<i data-lucide="edit" class="w-5 h-5 text-blue-200" x-show="isEdit" style="display: none;"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider" x-text="isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran'"></span>
				</div>
				<p class="text-blue-200 text-xs mt-1">Isi data mata pelajaran dengan benar</p>
			</div>
			<form :action="formAction" method="POST" class="p-6">
				@csrf
				<template x-if="isEdit">
					<input type="hidden" name="_method" value="PUT">
				</template>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kode Mapel <span class="text-red-400">*</span></label>
						<input name="kode" required x-model="mapel.kode" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all" placeholder="MP006">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Mapel <span class="text-red-400">*</span></label>
						<input name="nama" required x-model="mapel.nama" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all" placeholder="Nama mata pelajaran">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jurusan</label>
						<input name="jurusan" x-model="mapel.jurusan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all" placeholder="Kosongkan jika semua jurusan">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tingkat <span class="text-red-400">*</span></label>
						<input name="tingkat" required x-model="mapel.tingkat" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all" placeholder="Contoh: X, XI, atau 10, 11">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Guru Pengajar <span class="text-red-400">*</span></label>
						<select name="teacher_id" required x-model="mapel.teacher_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
							<option value="">Pilih Guru</option>
							@foreach($teachers as $teacher)
								<option value="{{ $teacher->id }}">{{ $teacher->nama }}</option>
							@endforeach
						</select>
					</div>
					<div class="grid grid-cols-2 gap-3">
						<div>
							<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jam / Minggu</label>
							<input name="jumlah_jam" required type="number" x-model="mapel.jumlah_jam" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all" placeholder="4">
						</div>
						<div>
							<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status <span class="text-red-400">*</span></label>
							<select name="status" required x-model="mapel.status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
								<option value="Aktif">Aktif</option>
								<option value="Tidak Aktif">Tidak Aktif</option>
							</select>
						</div>
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
