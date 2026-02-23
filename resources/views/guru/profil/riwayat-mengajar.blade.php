@extends('layouts.admin')

@section('title', 'Riwayat Mengajar')

@section('content')
@php
$riwayat = [
	[
		'tahun' => '2025/2026',
		'semester' => 'Ganjil',
		'status' => 'Berjalan',
		'kelas' => [
			['nama' => 'X RPL 1', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 32, 'wali' => true],
			['nama' => 'X RPL 2', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 30, 'wali' => false],
			['nama' => 'XI TKJ 1', 'mapel' => 'Matematika', 'jam' => 3, 'siswa' => 30, 'wali' => false],
		]
	],
	[
		'tahun' => '2024/2025',
		'semester' => 'Genap',
		'status' => 'Selesai',
		'kelas' => [
			['nama' => 'X IPA 1', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 34, 'wali' => true],
			['nama' => 'X IPA 2', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 32, 'wali' => false],
		]
	],
	[
		'tahun' => '2024/2025',
		'semester' => 'Ganjil',
		'status' => 'Selesai',
		'kelas' => [
			['nama' => 'X IPA 1', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 34, 'wali' => true],
			['nama' => 'X IPA 2', 'mapel' => 'Matematika', 'jam' => 4, 'siswa' => 32, 'wali' => false],
		]
	],
	[
		'tahun' => '2023/2024',
		'semester' => 'Genap',
		'status' => 'Selesai',
		'kelas' => [
			['nama' => 'XI IPA 2', 'mapel' => 'Matematika', 'jam' => 3, 'siswa' => 30, 'wali' => false],
			['nama' => 'XII IPA 1', 'mapel' => 'Matematika', 'jam' => 3, 'siswa' => 28, 'wali' => true],
		]
	],
	[
		'tahun' => '2023/2024',
		'semester' => 'Ganjil',
		'status' => 'Selesai',
		'kelas' => [
			['nama' => 'XI IPA 2', 'mapel' => 'Matematika', 'jam' => 3, 'siswa' => 30, 'wali' => false],
			['nama' => 'XII IPA 1', 'mapel' => 'Matematika', 'jam' => 3, 'siswa' => 28, 'wali' => true],
		]
	],
];
$totalKelas = collect($riwayat)->sum(fn($r) => count($r['kelas']));
$totalTahun = collect($riwayat)->pluck('tahun')->unique()->count();
@endphp

<div class="max-w-5xl mx-auto">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
		<div>
			<div class="flex items-center gap-3 mb-1">
				<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-200">
					<i data-lucide="history" class="w-5 h-5 text-white"></i>
				</div>
				<div>
					<h1 class="text-2xl font-extrabold text-gray-900">Riwayat Mengajar</h1>
					<p class="text-gray-400 text-xs">Track record mengajar selama bertugas di EduGo</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Stats -->
	<div class="grid grid-cols-3 gap-3 mb-6">
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-cyan-50 flex items-center justify-center">
					<i data-lucide="calendar" class="w-4 h-4 text-cyan-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-gray-900">{{ $totalTahun }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Tahun Ajaran</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
					<i data-lucide="layers" class="w-4 h-4 text-blue-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-blue-600">{{ $totalKelas }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Total Kelas</p>
		</div>
		<div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
			<div class="flex items-center justify-between mb-2">
				<div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
					<i data-lucide="book-open" class="w-4 h-4 text-emerald-600"></i>
				</div>
				<span class="text-2xl font-extrabold text-emerald-600">{{ count($riwayat) }}</span>
			</div>
			<p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Semester</p>
		</div>
	</div>

	<!-- Timeline -->
	<div class="relative">
		<!-- Vertical line -->
		<div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gradient-to-b from-cyan-400 via-blue-400 to-gray-200 rounded-full hidden md:block"></div>

		<div class="space-y-4">
			@foreach($riwayat as $idx => $r)
			<div class="relative flex items-start gap-4">
				<!-- Timeline dot -->
				<div class="w-10 h-10 rounded-xl {{ $r['status'] === 'Berjalan' ? 'bg-gradient-to-br from-cyan-500 to-blue-600 shadow-lg shadow-cyan-200' : 'bg-gray-200' }} flex items-center justify-center shrink-0 z-10">
					@if($r['status'] === 'Berjalan')
						<i data-lucide="play" class="w-4 h-4 text-white"></i>
					@else
						<i data-lucide="check" class="w-4 h-4 text-gray-500"></i>
					@endif
				</div>

				<!-- Content Card -->
				<div class="flex-1 bg-white border {{ $r['status'] === 'Berjalan' ? 'border-cyan-200' : 'border-gray-100' }} rounded-2xl shadow-sm overflow-hidden">
					<!-- Semester header -->
					<div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between {{ $r['status'] === 'Berjalan' ? 'bg-cyan-50/50' : '' }}">
						<div class="flex items-center gap-2">
							<span class="text-sm font-bold text-gray-800">TA {{ $r['tahun'] }}</span>
							<span class="text-[10px] text-gray-400">—</span>
							<span class="text-xs text-gray-500 font-medium">Semester {{ $r['semester'] === 'Ganjil' ? '1 (Ganjil)' : '2 (Genap)' }}</span>
						</div>
						@if($r['status'] === 'Berjalan')
							<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-cyan-100 text-cyan-700 text-[10px] font-bold uppercase tracking-wider border border-cyan-200">
								<span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Aktif
							</span>
						@else
							<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider">
								<i data-lucide="check-circle-2" class="w-3 h-3"></i> Selesai
							</span>
						@endif
					</div>

					<!-- Kelas list -->
					<div class="p-4 space-y-2">
						@foreach($r['kelas'] as $k)
						<div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100 hover:bg-blue-50/30 transition-colors">
							<div class="flex items-center gap-3">
								<div class="w-9 h-9 rounded-lg bg-gradient-to-br {{ $idx === 0 ? 'from-cyan-500 to-blue-600' : 'from-gray-400 to-gray-500' }} flex items-center justify-center">
									<span class="text-white text-[9px] font-extrabold">{{ explode(' ', $k['nama'])[0] }}</span>
								</div>
								<div>
									<p class="text-sm font-bold text-gray-800">{{ $k['nama'] }}</p>
									<p class="text-[10px] text-gray-400">{{ $k['mapel'] }} · {{ $k['jam'] }} jam/minggu</p>
								</div>
							</div>
							<div class="flex items-center gap-2">
								<span class="text-xs text-gray-500 font-medium">{{ $k['siswa'] }} siswa</span>
								@if($k['wali'])
									<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[9px] font-bold border border-amber-100">
										<i data-lucide="star" class="w-2.5 h-2.5"></i> Wali
									</span>
								@endif
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			@endforeach
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
