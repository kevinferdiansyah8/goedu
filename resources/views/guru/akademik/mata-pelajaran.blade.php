@extends('layouts.sidebar-guru')

@section('title', 'Mata Pelajaran')

@section('content')

<div class="max-w-7xl mx-auto">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
		<div>
			<div class="flex items-center gap-3 mb-2">
				<div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-100">
					<i data-lucide="book-open" class="w-6 h-6 text-white"></i>
				</div>
				<div>
					<h1 class="text-3xl font-bold text-gray-900 tracking-tight">Mata Pelajaran</h1>
					<p class="text-gray-500 text-sm">Daftar mata pelajaran yang Anda ampu (Dikelola oleh Admin).</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Stats & Filtering -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1 grid grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Mapel</div>
                <div class="text-3xl font-black text-gray-900">{{ $mataPelajaran->total() }}</div>
            </div>
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Jam</div>
                <div class="text-3xl font-black text-indigo-600">{{ $totalJam }}<span class="text-xs font-bold text-gray-400 ml-1">Jam</span></div>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex items-center h-full">
                <form method="GET" class="flex items-center gap-3 w-full">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-4 top-3.5"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode mapel..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-50 focus:bg-white focus:border-indigo-200 transition-all outline-none">
                    </div>
                    <button type="submit" class="px-6 py-3 bg-gray-900 text-white font-bold text-sm rounded-2xl hover:bg-black transition-all">Filter</button>
                </form>
            </div>
        </div>
    </div>

	<!-- Table -->
	<div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden mb-8">
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead>
					<tr class="bg-gray-50/50">
						<th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kode</th>
						<th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Mata Pelajaran</th>
						<th class="px-6 py-5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jurusan</th>
						<th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tingkat</th>
						<th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jam</th>
						<th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
						<th class="px-6 py-5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-24">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-50">
					@forelse($mataPelajaran as $mp)
					<tr class="hover:bg-indigo-50/20 transition-colors group">
						<td class="px-6 py-4">
							<span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-black">{{ $mp->kode }}</span>
						</td>
						<td class="px-6 py-4">
							<div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $mp->nama }}</div>
						</td>
						<td class="px-6 py-4">
							<span class="text-xs font-bold text-gray-500">{{ $mp->jurusan ?: '-' }}</span>
						</td>
						<td class="px-6 py-4 text-center">
							<span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-100 text-gray-700 text-xs font-black">{{ $mp->tingkat }}</span>
						</td>
						<td class="px-6 py-4 text-center">
							<span class="text-sm font-black text-gray-700">{{ $mp->jumlah_jam }}</span>
							<span class="text-[10px] font-bold text-gray-400 lowercase">Jam</span>
						</td>
						<td class="px-6 py-4 text-center">
							<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $mp->status === 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
								<span class="w-1.5 h-1.5 rounded-full {{ $mp->status === 'Aktif' ? 'bg-emerald-500' : 'bg-rose-400' }}"></span> {{ $mp->status }}
							</span>
						</td>
						<td class="px-6 py-4">
							<div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
								<a href="{{ route('guru.akademik.jadwal-mengajar', ['subject_id' => $mp->id]) }}" class="p-2 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Kelola Alur Akademik">
									<i data-lucide="external-link" class="w-4 h-4"></i>
								</a>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7" class="px-6 py-20 text-center text-gray-400 font-bold">
                            <i data-lucide="book-x" class="w-12 h-12 mx-auto mb-2 opacity-20"></i>
                            Belum ada data mata pelajaran yang ditugaskan.
                        </td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
			{{ $mataPelajaran->links() }}
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
