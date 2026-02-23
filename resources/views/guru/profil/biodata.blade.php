@extends('layouts.admin')

@section('title', 'Biodata Guru')

@section('content')
@php
$guru = [
	'nama' => 'Bambang Suryanto, S.Pd., M.Pd.',
	'nip' => '198706152010011003',
	'nuptk' => '4647750652200003',
	'email' => 'bambang.suryanto@edugo.sch.id',
	'telp' => '0812-3456-7890',
	'tempat_lahir' => 'Bandung',
	'tanggal_lahir' => '15 Juni 1987',
	'jenis_kelamin' => 'Laki-laki',
	'agama' => 'Islam',
	'alamat' => 'Jl. Merdeka No. 45, Kel. Cibinong, Kec. Cibinong, Kab. Bogor, Jawa Barat 16911',
	'status' => 'PNS',
	'jabatan' => 'Guru Mata Pelajaran',
	'golongan' => 'III/c',
	'pendidikan' => 'S2 — Pendidikan Matematika, Universitas Pendidikan Indonesia',
	'mapel' => 'Matematika',
	'kelas_diampu' => ['X RPL 1', 'X RPL 2', 'XI TKJ 1'],
	'tahun_masuk' => '2010',
	'wali_kelas' => 'X RPL 1',
];
@endphp

<div class="max-w-5xl mx-auto">

	<!-- Profile Header Card -->
	<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-5">
		<div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-8 relative overflow-hidden">
			<div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
			<div class="relative flex flex-col md:flex-row items-center gap-5">
				<!-- Avatar -->
				<div class="w-20 h-20 rounded-2xl bg-white/20 border-2 border-white/30 flex items-center justify-center shadow-lg">
					<span class="text-white text-3xl font-extrabold">BS</span>
				</div>
				<!-- Info -->
				<div class="text-center md:text-left flex-1">
					<h1 class="text-white text-xl font-extrabold">{{ $guru['nama'] }}</h1>
					<div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
						<span class="inline-flex items-center gap-1 bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
							<i data-lucide="briefcase" class="w-3 h-3"></i> {{ $guru['status'] }}
						</span>
						<span class="inline-flex items-center gap-1 bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
							<i data-lucide="book-open" class="w-3 h-3"></i> {{ $guru['mapel'] }}
						</span>
						<span class="inline-flex items-center gap-1 bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
							<i data-lucide="award" class="w-3 h-3"></i> Gol. {{ $guru['golongan'] }}
						</span>
					</div>
				</div>
				<!-- Action -->
				<button class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-sm font-semibold transition-all">
					<i data-lucide="pencil" class="w-4 h-4"></i> Edit Profil
				</button>
			</div>
		</div>

		<!-- Quick Stats -->
		<div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
			<div class="p-4 text-center">
				<p class="text-lg font-extrabold text-teal-600">{{ count($guru['kelas_diampu']) }}</p>
				<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Kelas Diampu</p>
			</div>
			<div class="p-4 text-center">
				<p class="text-lg font-extrabold text-blue-600">{{ $guru['wali_kelas'] }}</p>
				<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Wali Kelas</p>
			</div>
			<div class="p-4 text-center">
				<p class="text-lg font-extrabold text-gray-800">{{ $guru['tahun_masuk'] }}</p>
				<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Tahun Masuk</p>
			</div>
			<div class="p-4 text-center">
				<p class="text-lg font-extrabold text-emerald-600">{{ date('Y') - (int)$guru['tahun_masuk'] }} th</p>
				<p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Masa Kerja</p>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

		<!-- Data Pribadi -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
				<div class="w-7 h-7 rounded-lg bg-teal-50 flex items-center justify-center">
					<i data-lucide="user" class="w-3.5 h-3.5 text-teal-600"></i>
				</div>
				<span class="text-sm font-bold text-gray-700">Data Pribadi</span>
			</div>
			<div class="p-5 space-y-3.5">
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Nama Lengkap</span>
					<span class="text-sm font-semibold text-gray-800">{{ $guru['nama'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">TTL</span>
					<span class="text-sm text-gray-700">{{ $guru['tempat_lahir'] }}, {{ $guru['tanggal_lahir'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Jenis Kelamin</span>
					<span class="text-sm text-gray-700">{{ $guru['jenis_kelamin'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Agama</span>
					<span class="text-sm text-gray-700">{{ $guru['agama'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Alamat</span>
					<span class="text-sm text-gray-700 leading-relaxed">{{ $guru['alamat'] }}</span>
				</div>
			</div>
		</div>

		<!-- Data Kepegawaian -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
				<div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
					<i data-lucide="badge" class="w-3.5 h-3.5 text-blue-600"></i>
				</div>
				<span class="text-sm font-bold text-gray-700">Data Kepegawaian</span>
			</div>
			<div class="p-5 space-y-3.5">
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">NIP</span>
					<span class="text-sm font-mono font-semibold text-gray-800 bg-gray-50 px-2 py-0.5 rounded">{{ $guru['nip'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">NUPTK</span>
					<span class="text-sm font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded">{{ $guru['nuptk'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Status</span>
					<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
						<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $guru['status'] }}
					</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Jabatan</span>
					<span class="text-sm text-gray-700">{{ $guru['jabatan'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Golongan</span>
					<span class="text-sm font-semibold text-gray-800">{{ $guru['golongan'] }}</span>
				</div>
				<div class="flex items-start gap-3">
					<span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold w-28 shrink-0 pt-0.5">Pendidikan</span>
					<span class="text-sm text-gray-700">{{ $guru['pendidikan'] }}</span>
				</div>
			</div>
		</div>

		<!-- Kontak -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
				<div class="w-7 h-7 rounded-lg bg-violet-50 flex items-center justify-center">
					<i data-lucide="phone" class="w-3.5 h-3.5 text-violet-600"></i>
				</div>
				<span class="text-sm font-bold text-gray-700">Kontak</span>
			</div>
			<div class="p-5 space-y-3.5">
				<div class="flex items-center gap-3">
					<div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
						<i data-lucide="mail" class="w-4 h-4 text-blue-500"></i>
					</div>
					<div>
						<p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Email</p>
						<p class="text-sm font-medium text-gray-700">{{ $guru['email'] }}</p>
					</div>
				</div>
				<div class="flex items-center gap-3">
					<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
						<i data-lucide="smartphone" class="w-4 h-4 text-emerald-500"></i>
					</div>
					<div>
						<p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Telepon / WA</p>
						<p class="text-sm font-medium text-gray-700">{{ $guru['telp'] }}</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Kelas Diampu -->
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
				<div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
					<i data-lucide="layers" class="w-3.5 h-3.5 text-amber-600"></i>
				</div>
				<span class="text-sm font-bold text-gray-700">Kelas Diampu</span>
			</div>
			<div class="p-5">
				<div class="space-y-2.5">
					@foreach($guru['kelas_diampu'] as $kls)
					<div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
						<div class="flex items-center gap-3">
							<div class="w-9 h-9 rounded-lg bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center">
								<span class="text-white text-[10px] font-extrabold">{{ explode(' ', $kls)[0] }}</span>
							</div>
							<div>
								<p class="text-sm font-bold text-gray-800">{{ $kls }}</p>
								<p class="text-[10px] text-gray-400">{{ $guru['mapel'] }}</p>
							</div>
						</div>
						@if($kls === $guru['wali_kelas'])
							<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold uppercase border border-teal-100">
								<i data-lucide="star" class="w-3 h-3"></i> Wali Kelas
							</span>
						@endif
					</div>
					@endforeach
				</div>
			</div>
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
