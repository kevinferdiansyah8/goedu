@extends('layouts.admin')

@section('title', 'Tugas & Penugasan')

@section('content')

<div x-data="{ 
    showForm: false, 
    isEdit: false, 
    formAction: '{{ route('guru.tugas.store') }}',
    formMethod: 'POST',
    tugas: {
        subject_id: '',
        school_class_id: '',
        judul: '',
        deskripsi: '',
        deadline: '',
        file_path: ''
    },
    edit(t) {
        this.isEdit = true;
        this.showForm = true;
        this.formAction = '/guru/materi/tugas/' + t.id;
        this.formMethod = 'PUT';
        this.tugas = {
            subject_id: t.subject_id,
            school_class_id: t.school_class_id,
            judul: t.judul,
            deskripsi: t.deskripsi,
            deadline: t.deadline,
            file_path: t.file_path || ''
        };
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    },
    resetForm() {
        this.isEdit = false;
        this.showForm = false;
        this.formAction = '{{ route('guru.tugas.store') }}';
        this.formMethod = 'POST';
        this.tugas = {subject_id: '', school_class_id: '', judul: '', deskripsi: '', deadline: ''};
    }
}">

    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Penugasan Siswa</h1>
            <p class="text-gray-600">Buat dan kelola tugas untuk kelas yang Anda ampu</p>
        </div>
        <button @click="resetForm(); showForm = true; window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })" class="px-5 py-2.5 bg-orange-600 text-white rounded-xl font-bold hover:bg-orange-700 transition-colors shadow-lg shadow-orange-200 flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Buat Tugas Baru
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-medium">{{ session('success') }}</div>
    </div>
    @endif
    @if($errors->any())
    <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 flex items-center gap-3">
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse($tugas as $t)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative group overflow-hidden flex flex-col">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-[100px] -z-10 group-hover:bg-orange-100 transition-colors"></div>
            
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-bold px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full mb-1">
                        {{ count($t->studentAssignments) }} Terkumpul
                    </span>
                    <span class="text-[10px] uppercase font-bold tracking-wider {{ \Carbon\Carbon::parse($t->deadline)->isPast() ? 'text-red-500' : 'text-emerald-500' }}">
                        {{ \Carbon\Carbon::parse($t->deadline)->isPast() ? 'Ditutup' : 'Aktif' }}
                    </span>
                </div>
            </div>
            
            <h3 class="font-bold text-lg text-gray-800 mb-1 line-clamp-1" title="{{ $t->judul }}">{{ $t->judul }}</h3>
            <p class="text-xs text-gray-500 mb-3 font-medium">{{ $t->subject->nama }} &bull; {{ $t->schoolClass->nama_kelas ?? 'Tanpa Kelas' }}</p>
            
            <p class="text-sm text-gray-600 mb-4 line-clamp-2 min-h-[40px]">{{ $t->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>

            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                <span class="text-xs font-semibold text-gray-600">Deadline: {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y, H:i') }}</span>
            </div>

            @if($t->file_path)
            <div class="mb-4">
                <a href="{{ Storage::url($t->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded-lg transition-colors">
                    <i data-lucide="paperclip" class="w-3 h-3"></i>
                    Lampiran Instruksi
                </a>
            </div>
            @endif
            
            <div class="flex items-center justify-end pt-4 border-t border-gray-100 mt-auto gap-1.5">
                <a href="{{ route('guru.tugas.penilaian') }}" class="flex-1 py-2 text-center rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors font-bold text-xs" title="Lihat Nilai">
                    Lihat Pengumpulan
                </a>
                <button @click="edit({{ json_encode($t) }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors cursor-pointer" title="Edit">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </button>
                <form action="{{ route('guru.tugas.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini? Ini akan menghapus jawaban siswa yang sudah terkumpul juga.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors cursor-pointer" title="Hapus">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                <i data-lucide="clipboard-x" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Tugas</h3>
            <p class="text-gray-500 text-sm text-center max-w-sm mb-4">Anda belum membuat penugasan apapun untuk siswa.</p>
            <button @click="showForm = true" class="text-orange-600 font-bold hover:underline text-sm">Buat Tugas Baru &rarr;</button>
        </div>
        @endforelse
    </div>

    <!-- Upload/Edit Form -->
    <div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-3xl mx-auto mb-10 pb-10">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <i data-lucide="plus-square" class="w-5 h-5"></i>
                    <h2 class="font-bold text-sm tracking-wide uppercase" x-text="isEdit ? 'Edit Tugas' : 'Buat Tugas Baru'"></h2>
                </div>
                <button @click="resetForm()" class="text-orange-100 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form :action="formAction" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select name="subject_id" x-model="tugas.subject_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all font-medium">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tujuan Kelas <span class="text-red-500">*</span></label>
                        <select name="school_class_id" x-model="tugas.school_class_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all font-medium">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" x-model="tugas.judul" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all" placeholder="Contoh: Merangkum Bab 1">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Tugas</label>
                        <textarea name="deskripsi" x-model="tugas.deskripsi" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all" placeholder="Tuliskan instruksi penugasan di sini... (Optional)"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tenggat Waktu (Deadline) <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" x-model="tugas.deadline" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">File Instruksi / Lampiran (Optional)</label>
                        <div class="border-2 border-dashed border-gray-100 rounded-2xl p-6 text-center hover:bg-orange-50/50 hover:border-orange-200 transition-all cursor-pointer relative group">
                            <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <i data-lucide="file-up" class="w-8 h-8 text-orange-200 group-hover:text-orange-500 mx-auto mb-2 transition-colors"></i>
                            <p class="text-[11px] text-gray-400 font-medium">Klik atau tarik file instruksi ke sini (Max 10MB)</p>
                            <p class="text-[9px] text-orange-400 mt-1" x-show="tugas.file_path" x-text="'File saat ini: ' + tugas.file_path.split('/').pop()"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="resetForm()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold hover:bg-orange-700 transition-colors shadow-lg shadow-orange-200 flex items-center gap-2 text-sm">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Bagikan Tugas'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {});
</script>
@endpush
