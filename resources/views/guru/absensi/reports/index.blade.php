@extends('layouts.admin')

@section('title', 'Manajemen Laporan Pembelajaran')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="{ 
    showForm: false, 
    isEdit: false, 
    formAction: '{{ route('guru.absensi.reports.store') }}',
    formMethod: 'POST',
    report: {
        subject_id: '',
        school_class_id: '',
        tanggal: '{{ date('Y-m-d') }}',
        materi: '',
        catatan: ''
    },
    edit(r) {
        this.isEdit = true;
        this.showForm = true;
        this.formAction = '/guru/absensi/reports/' + r.id;
        this.formMethod = 'PUT';
        this.report = {
            subject_id: r.subject_id,
            school_class_id: r.school_class_id,
            tanggal: r.tanggal,
            materi: r.materi,
            catatan: r.catatan || ''
        };
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    resetForm() {
        this.isEdit = false;
        this.showForm = false;
        this.formAction = '{{ route('guru.absensi.reports.store') }}';
        this.formMethod = 'POST';
        this.report = {
            subject_id: '',
            school_class_id: '',
            tanggal: '{{ date('Y-m-d') }}',
            materi: '',
            catatan: ''
        };
    }
}">
    
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Pembelajaran</h1>
            <p class="text-gray-600">Riwayat Berita Acara Perkuliahan (BAP) Anda</p>
        </div>
        <button @click="resetForm(); showForm = true" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat Laporan Baru
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-medium">{{ session('success') }}</div>
    </div>
    @endif

    <!-- Form Section -->
    <div x-show="showForm" style="display: none;" x-transition class="mb-10">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden max-w-4xl mx-auto">
            <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <h2 class="font-bold text-sm uppercase tracking-wider" x-text="isEdit ? 'Edit Laporan' : 'Tambah Laporan Pembelajaran'"></h2>
                </div>
                <button @click="resetForm()" class="text-indigo-100 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form :action="formAction" method="POST" class="p-6">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                        <select name="subject_id" x-model="report.subject_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kelas</label>
                        <select name="school_class_id" x-model="report.school_class_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Pembelajaran</label>
                        <input type="date" name="tanggal" x-model="report.tanggal" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Materi Pembahasan</label>
                        <textarea name="materi" x-model="report.materi" rows="3" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400" placeholder="Tuliskan pokok bahasan hari ini..."></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Tambahan / Kendala (Opsional)</label>
                        <textarea name="catatan" x-model="report.catatan" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400" placeholder="Contoh: Siswa kurang kondusif, proyektor bermasalah, dsb."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="resetForm()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span x-text="isEdit ? 'Update Laporan' : 'Simpan Laporan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Mapel / Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Materi Pembahasan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $r)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-800">{{ $r->subject->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $r->schoolClass->tingkat }} - {{ $r->schoolClass->nama_kelas }}</div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-sm text-gray-600 line-clamp-2" title="{{ $r->materi }}">{{ $r->materi }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <button @click="edit({{ json_encode($r) }})" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('guru.absensi.reports.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="file-x" class="w-12 h-12 text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-medium">Belum ada riwayat laporan pembelajaran.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
