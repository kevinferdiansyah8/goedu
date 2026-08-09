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
		email: '',
		password: '',
		school_class_id: '',
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
			email: s.user ? s.user.email : '',
			password: '',
			school_class_id: s.school_class_id,
			jenis_kelamin: s.jenis_kelamin,
			telepon: s.telepon
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('admin.users.store') }}';
		this.formMethod = 'POST';
		this.siswa = {nis: '', nisn: '', nama: '', email: '', password: '', school_class_id: '', jenis_kelamin: '', telepon: ''};
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
					<p class="text-gray-400 text-xs">Kelola data siswa & akun login</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all active:scale-95">
			<i data-lucide="user-plus" class="w-4 h-4"></i>
			Tambah Siswa & Akun
		</button>
	</div>

	<!-- Alerts -->
	@if(session('success'))
	<div class="mb-4 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-sm">
		<div class="flex items-center gap-3">
			<i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-600"></i>
			<div class="font-semibold text-sm">{{ session('success') }}</div>
		</div>
		@if(session('wa_student_id'))
			@php
				$waStudent = \App\Models\Student::with('user')->find(session('wa_student_id'));
			@endphp
			@if($waStudent && $waStudent->telepon)
				@php
					$phoneSuccess = preg_replace('/[^0-9]/', '', $waStudent->telepon);
					if (str_starts_with($phoneSuccess, '0')) $phoneSuccess = '62' . substr($phoneSuccess, 1);
					$pwText = session('wa_plain_password') ?: 'siswa123 (atau password lama)';
					$emailText = $waStudent->user ? $waStudent->user->email : '-';
					$msgText = "Halo {$waStudent->nama},\n\nSelamat! Akun Portal Siswa Anda telah aktif.\n\n*Email Login:* {$emailText}\n*Password Login:* {$pwText}\n*Link Login:* " . route('login') . "\n\nSilakan segera login dan ganti password Anda demi keamanan.";
					$waUrlSuccess = "https://api.whatsapp.com/send?phone={$phoneSuccess}&text=" . urlencode($msgText);
				@endphp
				<a href="{{ $waUrlSuccess }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-md transition whitespace-nowrap">
					<i data-lucide="message-circle" class="w-4 h-4"></i>
					Kirim Akun via WA ke {{ $waStudent->nama }}
				</a>
			@endif
		@endif
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
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NIS, atau NISN..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 focus:bg-white transition-all">
			</div>
			
			<select name="kelas" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all min-w-[140px]">
				<option value="">Semua Kelas</option>
				@foreach($daftarKelas as $k)
					@php $valKelas = $k->nama_display; @endphp
					<option value="{{ $valKelas }}" {{ request('kelas') == $valKelas ? 'selected' : '' }}>{{ $k->nama_lengkap }}</option>
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
						<th class="px-5 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama & Email Login</th>
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
						<td class="px-5 py-3.5">
							<div class="font-semibold text-gray-800">{{ $s->nama }}</div>
							<div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
								<i data-lucide="mail" class="w-3 h-3 text-gray-400"></i>
								<span>{{ $s->user ? $s->user->email : '-' }}</span>
							</div>
						</td>
						<td class="px-5 py-3.5">
							<span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">{{ $s->kelas }}</span>
						</td>
						<td class="px-5 py-3.5 text-xs text-gray-600">{{ $s->jenis_kelamin ?: '-' }}</td>
						<td class="px-5 py-3.5 text-center">
							<div class="flex items-center justify-center gap-1.5">
								@php
									$phone = preg_replace('/[^0-9]/', '', $s->telepon ?? '');
									if (str_starts_with($phone, '0')) {
										$phone = '62' . substr($phone, 1);
									}
									$studentEmail = $s->user ? $s->user->email : '-';
									$loginUrl = route('login');
									$waMessage = "Halo {$s->nama},\n\nSelamat! Akun Portal Siswa Anda telah aktif.\n\n*Email Login:* {$studentEmail}\n*Password Login:* siswa123 (atau password yang ditentukan Admin)\n*Link Login:* {$loginUrl}\n\nSilakan segera login dan ganti password Anda demi keamanan.";
									$waUrlDirect = $phone ? "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($waMessage) : null;
								@endphp
								@if($waUrlDirect)
								<a href="{{ $waUrlDirect }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 flex items-center justify-center transition-colors group" title="Kirim Info Akun via WhatsApp">
									<i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600 group-hover:text-emerald-800"></i>
								</a>
								@endif
								<button @click="edit({{ json_encode($s) }})" class="w-8 h-8 rounded-lg bg-indigo-50 hover:bg-indigo-100 flex items-center justify-center transition-colors group" title="Edit Data & Password">
									<i data-lucide="pencil" class="w-3.5 h-3.5 text-indigo-500 group-hover:text-indigo-700"></i>
								</button>
								<form action="{{ route('admin.users.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
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

	<!-- Modal Form Tambah/Edit (Centered Overlay) -->
	<div x-show="showForm" 
		 class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" 
		 style="display: none;"
		 x-transition:enter="transition ease-out duration-300"
		 x-transition:enter-start="opacity-0"
		 x-transition:enter-end="opacity-100"
		 x-transition:leave="transition ease-in duration-200"
		 x-transition:leave-start="opacity-100"
		 x-transition:leave-end="opacity-0">
		 
		<!-- Backdrop -->
		<div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="resetForm()"></div>

		<!-- Modal content -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden w-full max-w-2xl transform transition-all z-10"
			 x-transition:enter="transition ease-out duration-300"
			 x-transition:enter-start="opacity-0 scale-95"
			 x-transition:enter-end="opacity-100 scale-100"
			 x-transition:leave="transition ease-in duration-200"
			 x-transition:leave-start="opacity-100 scale-100"
			 x-transition:leave-end="opacity-0 scale-95">
			<div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
				<div class="flex items-center gap-2">
					<i data-lucide="user-plus" class="w-5 h-5 text-indigo-200" x-show="!isEdit"></i>
					<i data-lucide="edit" class="w-5 h-5 text-indigo-200" x-show="isEdit" style="display: none;"></i>
					<span class="text-white text-sm font-bold uppercase tracking-wider" x-text="isEdit ? 'Edit Data & Akun Siswa' : 'Tambah Siswa & Akun Login'"></span>
				</div>
				<button type="button" @click="resetForm()" class="text-white/80 hover:text-white transition-colors">
					<i data-lucide="x" class="w-5 h-5"></i>
				</button>
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
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Login <span class="text-red-400">*</span></label>
						<input type="email" name="email" x-model="siswa.email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="siswa@sekolah.sch.id">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
							Password Login
							<span class="text-gray-400 font-normal lowercase" x-show="isEdit">(opsional)</span>
						</label>
						<input type="password" name="password" x-model="siswa.password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="Min. 6 karakter">
						<p class="text-[11px] text-gray-400 mt-1" x-show="!isEdit">Default: <code class="text-indigo-600 font-bold">siswa123</code> jika dikosongkan</p>
						<p class="text-[11px] text-gray-400 mt-1" x-show="isEdit">Biarkan kosong jika tidak ingin mengubah password</p>
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kelas <span class="text-red-400">*</span></label>
						<select name="school_class_id" x-model="siswa.school_class_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
							<option value="">-- Pilih Kelas --</option>
							@foreach($daftarKelas as $k)
								<option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
							@endforeach
						</select>
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
						Simpan Data & Akun
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