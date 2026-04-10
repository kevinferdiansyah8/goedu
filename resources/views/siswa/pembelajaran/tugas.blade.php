@extends('layouts.admin')

@section('title', 'Upload Tugas')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{
    selectedTugasId: '',
    selectedTugasTitle: '',
    selectedTugasMapel: '',
    formAction: '#',
    selectTugas(tugas) {
        this.selectedTugasId = tugas.id;
        this.selectedTugasTitle = tugas.judul;
        this.selectedTugasMapel = tugas.subject.nama;
        this.formAction = '/siswa/pembelajaran/tugas/submit/' + tugas.id;
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
}">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Upload Tugas</h1>
        <p class="text-gray-600">Kirim tugas yang diberikan oleh guru Anda berdasarkan kelas dan mata pelajaran.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- List Tugas -->
        <div class="lg:col-span-2 space-y-4">
            @forelse($tugas_pending as $tugas)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between hover:shadow-md transition-shadow">
                <div>
                     <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-600 mb-2 uppercase">{{ $tugas->subject->nama }}</span>
                    <h3 class="text-lg font-bold text-gray-800 max-w-md">{{ $tugas->judul }}</h3>
                    <p class="text-gray-500 text-sm mt-1">{{ $tugas->deskripsi ?: 'Tidak ada instruksi khusus.' }}</p>
                    
                    @if($tugas->file_path)
                    <div class="mt-2">
                        <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-2 py-1 rounded-lg transition-colors border border-indigo-100">
                            <i data-lucide="paperclip" class="w-3 h-3"></i>
                            Download Lampiran Instruksi
                        </a>
                    </div>
                    @endif
                    <div class="flex items-center gap-2 mt-3 text-sm text-gray-500">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-red-500"></i>
                        <span>Deadline: 
                            <span class="font-semibold {{ \Carbon\Carbon::parse($tugas->deadline)->isPast() ? 'text-red-500 line-through' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }}
                            </span>
                        </span>
                    </div>
                </div>
                <!-- Disable if past deadline or optionally allow late submission -->
                @if(\Carbon\Carbon::parse($tugas->deadline)->isPast())
                <button disabled title="Tenggat waktu telah berakhir" class="w-full md:w-auto px-5 py-2.5 bg-gray-300 text-gray-500 font-bold rounded-lg cursor-not-allowed">
                    Terlewat
                </button>
                @else
                <button @click="selectTugas({{ htmlspecialchars(json_encode($tugas)) }})" class="w-full md:w-auto px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md shadow-blue-200 active:scale-95 whitespace-nowrap">
                    Pilih & Upload
                </button>
                @endif
            </div>
            @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-500"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Hebat!</h3>
                <p class="text-gray-500 text-sm max-w-sm">Anda telah menyelesaikan semua tugas atau tidak ada tugas baru yang diberikan saat ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Form Upload -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4 flex items-center gap-2">
                    <i data-lucide="file-up" class="w-5 h-5 text-white"></i>
                    <h3 class="font-bold text-sm text-white uppercase tracking-wider">Form Pengumpulan</h3>
                </div>
                <form :action="formAction" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="space-y-5">
                        <!-- Message when nothing selected -->
                        <div x-show="!selectedTugasId" class="text-center p-4 bg-orange-50 border border-orange-100 rounded-xl">
                            <i data-lucide="mouse-pointer-click" class="w-6 h-6 text-orange-400 mx-auto mb-2"></i>
                            <p class="text-xs text-orange-600 font-medium">Pilih salah satu tugas dari daftar di samping untuk mulai mengunggah jawaban.</p>
                        </div>

                        <div x-show="selectedTugasId" style="display: none;" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tugas Terpilih</label>
                                <div class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 flex flex-col items-start gap-1">
                                    <span class="text-[10px] font-bold text-blue-600 uppercase" x-text="selectedTugasMapel"></span>
                                    <span class="text-sm font-semibold text-gray-800" x-text="selectedTugasTitle"></span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">File Jawaban <span class="text-red-500">*</span></label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50/50 hover:border-blue-400 transition-colors cursor-pointer relative group">
                                    <input type="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.png,.jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 group-hover:text-blue-500 mx-auto mb-2 transition-colors"></i>
                                    <p class="text-sm font-bold text-gray-700">Pilih berkas jawaban Anda</p>
                                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Batas maksimal: 10MB (PDF/Word/Images)</p>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                                <i data-lucide="send" class="w-4 h-4"></i> Unggah Jawaban
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {});
</script>
@endpush
