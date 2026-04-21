@extends('layouts.admin')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ 
	showForm: false, 
	isEdit: false, 
	formAction: '{{ route('guru.akademik.mata-pelajaran.store') }}',
	formMethod: 'POST',
	mapel: {
		kode: '',
		nama: '',
		jurusan: '',
		tingkat: '',
		jumlah_jam: '',
		status: 'Aktif'
	},
	edit(m) {
		this.isEdit = true;
		this.showForm = true;
		this.formAction = '/guru/akademik/mata-pelajaran/' + m.id;
		this.formMethod = 'POST';
		this.mapel = {
			id: m.id,
			kode: m.kode,
			nama: m.nama,
			jurusan: m.jurusan,
			tingkat: m.tingkat,
			jumlah_jam: m.jumlah_jam,
			status: m.status
		};
	},
	resetForm() {
		this.isEdit = false;
		this.showForm = false;
		this.formAction = '{{ route('guru.akademik.mata-pelajaran.store') }}';
		this.formMethod = 'POST';
		this.mapel = {kode: '', nama: '', jurusan: '', tingkat: '', jumlah_jam: '', status: 'Aktif'};
	}
}">

	<!-- Header -->
	<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
		<div>
			<div class="flex items-center gap-3 mb-2">
				<div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-100">
					<i data-lucide="book-open" class="w-6 h-6 text-white"></i>
				</div>
				<div>
					<h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Mapel</h1>
					<p class="text-gray-500 text-sm">Kelola daftar mata pelajaran yang Anda ampu.</p>
				</div>
			</div>
		</div>
		<button @click="resetForm(); showForm = true" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm shadow-xl shadow-indigo-100 transition-all active:scale-95">
			<i data-lucide="plus" class="w-4 h-4"></i>
			Tambah Mata Pelajaran
		</button>
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

	<!-- Alerts -->
	@if(session('success'))
	<div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-2xl border border-emerald-100 flex items-center gap-3 animate-fade-in shadow-sm">
		<i data-lucide="check-circle" class="w-5 h-5"></i>
		<div class="font-bold">{{ session('success') }}</div>
	</div>
	@endif

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
								<button @click="edit({{ json_encode($mp) }})" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Edit">
									<i data-lucide="edit-3" class="w-4 h-4"></i>
								</button>
								<form action="{{ route('guru.akademik.mata-pelajaran.destroy', $mp->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')">
									@csrf @method('DELETE')
									<button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm" title="Hapus">
										<i data-lucide="trash-2" class="w-4 h-4"></i>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7" class="px-6 py-20 text-center text-gray-400 font-bold">
                            <i data-lucide="book-x" class="w-12 h-12 mx-auto mb-2 opacity-20"></i>
                            Belum ada data mata pelajaran.
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

	<!-- Modal Form -->
    <div x-show="showForm" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="resetForm()"></div>
        <div class="bg-white rounded-[32px] shadow-2xl relative w-full max-w-lg overflow-hidden" x-transition>
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <i data-lucide="plus-square" class="w-6 h-6" x-show="!isEdit"></i>
                    <i data-lucide="edit-3" class="w-6 h-6" x-show="isEdit" style="display: none;"></i>
                    <h3 class="text-xl font-bold uppercase tracking-widest" x-text="isEdit ? 'Edit Mapel' : 'Tambah Mapel'"></h3>
                </div>
                <button @click="resetForm()" class="hover:bg-white/20 p-2 rounded-xl transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form :action="formAction" method="POST" class="p-8 space-y-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Kode Mapel</label>
                        <input name="kode" required x-model="mapel.kode" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none" placeholder="TKN01">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Status</label>
                        <select name="status" required x-model="mapel.status" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Nama Mata Pelajaran</label>
                    <input name="nama" required x-model="mapel.nama" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none" placeholder="Contoh: Matematika Terapan">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Jurusan</label>
                        <input name="jurusan" x-model="mapel.jurusan" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none" placeholder="Semua Jurusan">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Tingkat</label>
                        <input name="tingkat" required x-model="mapel.tingkat" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none" placeholder="Sepuluh (X)">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Jumlah Jam / Minggu</label>
                    <input name="jumlah_jam" required type="number" x-model="mapel.jumlah_jam" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all outline-none" placeholder="4">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="resetForm()" class="flex-1 py-4 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                    <button type="submit" class="flex-2 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Mapel'"></span>
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
