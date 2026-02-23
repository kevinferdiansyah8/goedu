@extends('layouts.admin')

@section('title', 'Arsip Dokumen')

@section('content')
@php
$dokumen = [
	[
		'kategori' => 'Surat Keputusan',
		'icon' => 'file-badge',
		'color' => 'blue',
		'items' => [
			['nama' => 'SK Mengajar TA 2025/2026', 'file' => 'SK_Mengajar_2025.pdf', 'ukuran' => '245 KB', 'tanggal' => '10 Jun 2025', 'status' => 'Aktif'],
			['nama' => 'SK Wali Kelas X RPL 1', 'file' => 'SK_WaliKelas_XRPL1.pdf', 'ukuran' => '180 KB', 'tanggal' => '12 Jun 2025', 'status' => 'Aktif'],
			['nama' => 'SK Mengajar TA 2024/2025', 'file' => 'SK_Mengajar_2024.pdf', 'ukuran' => '230 KB', 'tanggal' => '8 Jun 2024', 'status' => 'Arsip'],
		]
	],
	[
		'kategori' => 'Sertifikat & Pelatihan',
		'icon' => 'award',
		'color' => 'emerald',
		'items' => [
			['nama' => 'Sertifikat Pelatihan Kurikulum Merdeka', 'file' => 'Sertif_KurMer_2025.pdf', 'ukuran' => '520 KB', 'tanggal' => '15 Mar 2025', 'status' => 'Aktif'],
			['nama' => 'Sertifikat Workshop Asesmen Digital', 'file' => 'Sertif_AsesDig_2024.pdf', 'ukuran' => '410 KB', 'tanggal' => '22 Nov 2024', 'status' => 'Arsip'],
			['nama' => 'Sertifikat Pendidik (Serdik)', 'file' => 'Serdik_Bambang.pdf', 'ukuran' => '1.2 MB', 'tanggal' => '5 Aug 2018', 'status' => 'Aktif'],
		]
	],
	[
		'kategori' => 'Ijazah & Transkrip',
		'icon' => 'graduation-cap',
		'color' => 'violet',
		'items' => [
			['nama' => 'Ijazah S2 — Pend. Matematika UPI', 'file' => 'Ijazah_S2_UPI.pdf', 'ukuran' => '2.1 MB', 'tanggal' => '20 Sep 2015', 'status' => 'Aktif'],
			['nama' => 'Transkrip Nilai S2', 'file' => 'Transkrip_S2.pdf', 'ukuran' => '850 KB', 'tanggal' => '20 Sep 2015', 'status' => 'Aktif'],
			['nama' => 'Ijazah S1 — Pend. Matematika UNPAD', 'file' => 'Ijazah_S1_UNPAD.pdf', 'ukuran' => '1.8 MB', 'tanggal' => '15 Jul 2009', 'status' => 'Aktif'],
		]
	],
	[
		'kategori' => 'Dokumen Lainnya',
		'icon' => 'folder',
		'color' => 'amber',
		'items' => [
			['nama' => 'KTP', 'file' => 'KTP_Bambang.pdf', 'ukuran' => '320 KB', 'tanggal' => '1 Jan 2022', 'status' => 'Aktif'],
			['nama' => 'NPWP', 'file' => 'NPWP_Bambang.pdf', 'ukuran' => '180 KB', 'tanggal' => '15 Feb 2020', 'status' => 'Aktif'],
		]
	],
];
$totalDokumen = collect($dokumen)->sum(fn($d) => count($d['items']));
$totalAktif = collect($dokumen)->sum(fn($d) => collect($d['items'])->where('status', 'Aktif')->count());
@endphp

<div class="max-w-5xl mx-auto" x-data="{ showUpload: false }">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200">
					<i data-lucide="archive" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Arsip Dokumen</h1>
					<p class="text-gray-400 text-xs">Kelola dan simpan dokumen penting kepegawaian</p>
				</div>
			</div>
		</div>
		<button @click="showUpload = !showUpload" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all active:scale-95">
			<i data-lucide="upload" class="w-4 h-4"></i>
			Upload Dokumen
		</button>
	</div>

	<!-- Stats -->
	<div class="grid grid-cols-3 gap-3 mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
					<i data-lucide="files" class="w-4 h-4 text-indigo-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalDokumen }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Dokumen</p>
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
				<div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
					<i data-lucide="folder-archive" class="w-4 h-4 text-violet-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-violet-600">{{ count($dokumen) }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Kategori</p>
		</div>
	</div>

	<!-- Upload Form -->
	<div x-show="showUpload" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4" class="mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3">
				<span class="text-white text-sm font-bold uppercase tracking-wider">Upload Dokumen Baru</span>
			</div>
			<div class="p-5">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Dokumen</label>
						<input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 focus:bg-white transition-all" placeholder="cth: SK Mengajar 2025">
					</div>
					<div>
						<label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
						<select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all">
							<option>Surat Keputusan</option>
							<option>Sertifikat & Pelatihan</option>
							<option>Ijazah & Transkrip</option>
							<option>Dokumen Lainnya</option>
						</select>
					</div>
				</div>
				<div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-indigo-300 transition-colors cursor-pointer">
					<i data-lucide="cloud-upload" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
					<p class="text-sm text-gray-500 font-medium">Klik atau seret file ke sini</p>
					<p class="text-[10px] text-gray-400 mt-1">PDF, JPG, PNG (maks 5 MB)</p>
				</div>
				<div class="flex justify-end gap-2.5 mt-4">
					<button type="button" @click="showUpload = false" class="px-5 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-600 font-semibold text-sm transition-all">Batal</button>
					<button class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all active:scale-95">
						<i data-lucide="upload" class="w-4 h-4"></i> Upload
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Document Categories -->
	<div class="space-y-5">
		@foreach($dokumen as $kat)
		<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
			<div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
				<div class="flex items-center gap-2">
					<div class="w-7 h-7 rounded-lg bg-{{ $kat['color'] }}-50 flex items-center justify-center">
						<i data-lucide="{{ $kat['icon'] }}" class="w-3.5 h-3.5 text-{{ $kat['color'] }}-600"></i>
					</div>
					<span class="text-sm font-bold text-gray-700">{{ $kat['kategori'] }}</span>
				</div>
				<span class="text-xs text-gray-400">{{ count($kat['items']) }} dokumen</span>
			</div>
			<div class="divide-y divide-gray-50">
				@foreach($kat['items'] as $doc)
				<div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
					<div class="flex items-center gap-3">
						<div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
							<i data-lucide="file-text" class="w-4 h-4 text-red-500"></i>
						</div>
						<div>
							<p class="text-sm font-semibold text-gray-800">{{ $doc['nama'] }}</p>
							<div class="flex items-center gap-2 mt-0.5">
								<span class="text-[10px] text-gray-400">{{ $doc['file'] }}</span>
								<span class="text-[10px] text-gray-300">·</span>
								<span class="text-[10px] text-gray-400">{{ $doc['ukuran'] }}</span>
								<span class="text-[10px] text-gray-300">·</span>
								<span class="text-[10px] text-gray-400">{{ $doc['tanggal'] }}</span>
							</div>
						</div>
					</div>
					<div class="flex items-center gap-2">
						@if($doc['status'] === 'Aktif')
							<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[9px] font-bold uppercase border border-emerald-100">
								<span class="w-1 h-1 rounded-full bg-emerald-500"></span> Aktif
							</span>
						@else
							<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-[9px] font-bold uppercase">
								Arsip
							</span>
						@endif
						<button class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors group" title="Download">
							<i data-lucide="download" class="w-3.5 h-3.5 text-blue-500 group-hover:text-blue-700"></i>
						</button>
						<button class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors group" title="Hapus">
							<i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-400 group-hover:text-red-600"></i>
						</button>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endforeach
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
