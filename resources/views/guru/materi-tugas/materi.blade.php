@extends('layouts.admin')

@section('title', 'Materi Pelajaran')

@section('content')

<div x-data="{ 
    showForm: false, 
    isEdit: false, 
    formAction: '{{ route('guru.materi.store') }}',
    formMethod: 'POST',
    materi: {
        subject_id: '',
        school_class_id: '',
        judul: '',
    },
    edit(m) {
        this.isEdit = true;
        this.showForm = true;
        this.formAction = '/guru/materi/materi/' + m.id;
        this.formMethod = 'PUT';
        this.materi = {
            subject_id: m.subject_id,
            school_class_id: m.school_class_id,
            judul: m.judul,
        };
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    },
    resetForm() {
        this.isEdit = false;
        this.showForm = false;
        this.formAction = '{{ route('guru.materi.store') }}';
        this.formMethod = 'POST';
        this.materi = {subject_id: '', school_class_id: '', judul: ''};
    }
}">

    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Materi Pembelajaran</h1>
            <p class="text-gray-600">Kelola dokumen dan bahan ajar Kelas Anda</p>
        </div>
        <button @click="resetForm(); showForm = true; window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Upload Baru
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
        @forelse($materi as $m)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative group overflow-hidden flex flex-col">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[100px] -z-10 group-hover:bg-blue-100 transition-colors"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    @if(str_contains(strtolower($m->file_path), 'pdf'))
                        <i data-lucide="file-text" class="w-6 h-6 text-red-500"></i>
                    @elseif(str_contains(strtolower($m->file_path), 'ppt') || str_contains(strtolower($m->file_path), 'pptx'))
                        <i data-lucide="presentation" class="w-6 h-6 text-orange-500"></i>
                    @else
                        <i data-lucide="file" class="w-6 h-6"></i>
                    @endif
                </div>
                <span class="text-[10px] font-bold px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full">{{ $m->ukuran_file }}</span>
            </div>
            
            <h3 class="font-bold text-lg text-gray-800 mb-1 line-clamp-2" title="{{ $m->judul }}">{{ $m->judul }}</h3>
            <p class="text-xs text-gray-500 mb-4 font-medium">{{ $m->subject->nama }} &bull; {{ $m->schoolClass->nama_kelas ?? 'Tanpa Kelas' }}</p>
            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                <span class="text-[11px] font-bold text-gray-400">{{ \Carbon\Carbon::parse($m->tanggal_upload)->format('d M Y') }}</span>
                <div class="flex items-center gap-1.5">
                    <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors cursor-pointer" title="Download">
                        <i data-lucide="download" class="w-4 h-4"></i>
                    </a>
                    <button @click="edit({{ json_encode($m) }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors cursor-pointer" title="Edit">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <form action="{{ route('guru.materi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors cursor-pointer" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                <i data-lucide="folder-open" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Materi</h3>
            <p class="text-gray-500 text-sm text-center max-w-sm mb-4">Silakan unggah dokumen materi pertama Anda untuk mata pelajaran yang Anda ampu.</p>
            <button @click="showForm = true" class="text-blue-600 font-bold hover:underline text-sm">Upload Sekarang &rarr;</button>
        </div>
        @endforelse
    </div>

    <!-- Upload/Edit Form -->
    <div x-show="showForm" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" id="formSection" class="max-w-2xl mx-auto mb-10 pb-10">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                    <h2 class="font-bold text-sm tracking-wide uppercase" x-text="isEdit ? 'Edit Materi Pembelajaran' : 'Upload Materi Baru'"></h2>
                </div>
                <button @click="resetForm()" class="text-blue-100 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form :action="formAction" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select name="subject_id" x-model="materi.subject_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all font-medium">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tujuan Kelas <span class="text-red-500">*</span></label>
                        <select name="school_class_id" x-model="materi.school_class_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all font-medium">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Judul Materi <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" x-model="materi.judul" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all" placeholder="Contoh: Bab 1: Struktur Atom">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">File Dokumen <span x-show="!isEdit" class="text-red-500">*</span></label>
                        <div class="relative group">
                            <input type="file" name="file" :required="!isEdit" accept=".pdf,.doc,.docx,.ppt,.pptx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full px-4 py-8 bg-gray-50 border-2 border-dashed border-gray-200 group-hover:border-blue-400 group-hover:bg-blue-50/50 rounded-xl text-center transition-all flex flex-col items-center justify-center">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm text-blue-500">
                                    <i data-lucide="file-up" class="w-5 h-5"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-700">Pilih File PDF/PPT/DOCX</span>
                                <span class="text-xs text-gray-400 mt-1" x-text="isEdit ? 'Biarkan kosong jika tidak ingin mengubah file saat ini. (Maks 10MB)' : 'Ukuran maksimal 10MB'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="resetForm()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2 text-sm">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Upload Materi'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    // any extra alpine init
});
</script>
@endpush
