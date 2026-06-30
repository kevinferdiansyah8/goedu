@extends('layouts.sidebar-siswa')
@section('title', 'Pembelajaran E-Learning')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6" 
    x-data="{ 
        tab: 'pretest', 
        pretestDone: {{ $pretestDone ? 'true' : 'false' }},
        materiDone: false,
        tugasDone: {{ $mySubmission ? 'true' : 'false' }},
        forumDone: {{ $forumDone ? 'true' : 'false' }},
        posttestDone: {{ $posttestDone ? 'true' : 'false' }},
        init() {
            const keyMateri = 'elearning_materi_' + {{ $session->id }} + '_' + {{ Auth::id() }};
            const keyForum = 'elearning_forum_' + {{ $session->id }} + '_' + {{ Auth::id() }};
            if (localStorage.getItem(keyMateri) === 'true') {
                this.materiDone = true;
            }
            if (localStorage.getItem(keyForum) === 'true') {
                this.forumDone = true;
            }
        }
    }">
    <div class="max-w-7xl mx-auto">
        
        {{-- Back button & Header --}}
        <div class="mb-6">
            <a href="{{ route('siswa.elearning.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-orange-600 transition-colors mb-3">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Daftar Modul
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-orange-600 uppercase bg-orange-50 px-2.5 py-1 rounded-full">
                        Pertemuan {{ $session->urutan }} — {{ $session->subject->nama }}
                    </span>
                    <h1 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $session->judul }}</h1>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium flex items-center gap-2">
            <i data-lucide="alert-triangle" class="w-4 h-4"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Tab Headers --}}
        <div class="bg-white rounded-2xl p-1.5 border border-gray-100 shadow-sm flex flex-wrap gap-1 mb-6">
            <button @click="tab = 'pretest'" :class="tab === 'pretest' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i x-show="!pretestDone" data-lucide="help-circle" class="w-4 h-4"></i>
                <i x-show="pretestDone" data-lucide="check-circle-2" class="w-4 h-4" :class="tab === 'pretest' ? 'text-white' : 'text-emerald-500'"></i>
                <span>1. Pretest</span>
            </button>
            
            {{-- Materi (selalu bisa diakses) --}}
            <button @click="tab = 'materi'; localStorage.setItem('elearning_materi_' + {{ $session->id }} + '_' + {{ Auth::id() }}, 'true'); materiDone = true" 
                :class="tab === 'materi' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i x-show="!materiDone" data-lucide="book-open" class="w-4 h-4"></i>
                <i x-show="materiDone" data-lucide="check-circle-2" class="w-4 h-4" :class="tab === 'materi' ? 'text-white' : 'text-emerald-500'"></i>
                <span>2. Link Pembelajaran</span>
            </button>

            {{-- Tugas --}}
            <button @click="tab = 'tugas'"
                :class="tab === 'tugas' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2 relative">
                <i x-show="!tugasDone" data-lucide="file-text" class="w-4 h-4"></i>
                <i x-show="tugasDone" data-lucide="check-circle-2" class="w-4 h-4" :class="tab === 'tugas' ? 'text-white' : 'text-emerald-500'"></i>
                <span>3. Penugasan</span>
            </button>

            {{-- Forum Diskusi --}}
            <button @click="tab = 'forum'; localStorage.setItem('elearning_forum_' + {{ $session->id }} + '_' + {{ Auth::id() }}, 'true'); forumDone = true"
                :class="tab === 'forum' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2 relative">
                <i x-show="!forumDone" data-lucide="message-square" class="w-4 h-4"></i>
                <i x-show="forumDone" data-lucide="check-circle-2" class="w-4 h-4" :class="tab === 'forum' ? 'text-white' : 'text-emerald-500'"></i>
                <span>4. Forum Diskusi</span>
            </button>

            {{-- Posttest --}}
            <button @click="tab = 'posttest'"
                :class="tab === 'posttest' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2 relative">
                <i x-show="!posttestDone" data-lucide="check-square" class="w-4 h-4"></i>
                <i x-show="posttestDone" data-lucide="check-circle-2" class="w-4 h-4" :class="tab === 'posttest' ? 'text-white' : 'text-emerald-500'"></i>
                <span>5. Posttest</span>
            </button>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: PRETEST --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'pretest'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="help-circle" class="text-orange-500"></i> Tes Awal (Pretest)
                </h2>
                
                @if($pretestDone)
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 text-center max-w-md mx-auto">
                    <div class="w-16 h-16 bg-green-100 text-green-600 flex items-center justify-center rounded-full mx-auto mb-4">
                        <i data-lucide="check-circle-2" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Pretest Telah Selesai!</h3>
                    <p class="text-xs text-gray-500 mt-1">Anda sudah mengerjakan Pretest untuk pertemuan ini.</p>
                    
                    <div class="mt-4 p-4 bg-white rounded-xl border border-green-200 inline-block">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block tracking-wider">Skor Pretest Anda</span>
                        <span class="text-3xl font-extrabold text-green-600">{{ $nilaiPretest }} / 100</span>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('siswa.elearning.hasil', [$session->id, 'pretest']) }}" class="text-xs text-indigo-600 hover:underline font-bold">
                            Lihat Pembahasan Jawaban
                        </a>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-600 text-sm max-w-md mx-auto mb-5">
                        Sebelum memulai pembelajaran, silakan kerjakan pretest singkat yang terdiri dari **5 soal pilihan ganda** seputar topik yang akan dipelajari.
                    </p>
                    @if($session->pretestQuestions->isEmpty())
                    <p class="text-xs text-gray-400 italic">Soal belum dipersiapkan oleh guru pengampu.</p>
                    @else
                    <a href="{{ route('siswa.elearning.pretest', $session->id) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white font-bold rounded-xl text-sm shadow-md shadow-orange-100 transition-all">
                        <i data-lucide="play" class="w-4 h-4"></i> Mulai Pretest (5 Pertanyaan)
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: LINK PEMBELAJARAN --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'materi'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="book-open" class="text-orange-500"></i> Bahan & Link Pembelajaran
                </h2>

                @if($session->materials->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">Bahan ajar belum diunggah oleh guru.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($session->materials as $mat)
                    <div class="border border-gray-100 rounded-xl p-4 bg-slate-50/50 hover:bg-slate-50 transition-all flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                                <i data-lucide="{{ $mat->icon }}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $mat->judul }}</h4>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $mat->tipe }}</span>
                            </div>
                        </div>
                        @if($mat->tipe === 'file')
                        <a href="{{ asset('storage/' . $mat->konten) }}" target="_blank"
                           class="px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                            Buka File <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        </a>
                        @else
                        <a href="{{ $mat->konten }}" target="_blank"
                           class="px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                            Buka Link <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: PENUGASAN --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'tugas'" class="space-y-6">
            @if(!$pretestDone)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center text-amber-700">
                <i data-lucide="lock" class="w-10 h-10 mx-auto mb-2 opacity-70"></i>
                <h3 class="font-bold">Menu Penugasan Terkunci!</h3>
                <p class="text-xs mt-1">Harap selesaikan **Pretest** terlebih dahulu untuk mengakses pengumpulan tugas.</p>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="text-orange-500"></i> Petunjuk / Instruksi Tugas
                </h2>
                @if(!$session->assignment)
                <p class="text-xs text-gray-400 italic">Belum ada tugas terstruktur untuk pertemuan ini.</p>
                @else
                <div class="prose prose-sm max-w-none text-gray-700 mb-6 bg-slate-50 p-5 rounded-xl border border-slate-100">
                    {!! nl2br(e($session->assignment->instruksi)) !!}
                </div>
                
                @if($session->assignment->deadline)
                <div class="text-xs text-gray-500 font-medium mb-6">
                    Batas Pengumpulan: <strong class="text-red-500">{{ $session->assignment->deadline->format('d M Y H:i') }}</strong>
                </div>
                @endif

                {{-- Status / Form Submit --}}
                <div class="border-t pt-6">
                    <h3 class="font-bold text-gray-800 text-sm mb-4">Pengumpulan Jawaban Anda</h3>
                    
                    @if($mySubmission)
                    <div class="bg-slate-50 border rounded-2xl p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div>
                                <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Status Pengumpulan</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 inline-block mt-1">
                                    Sudah Dikumpulkan
                                </span>
                            </div>
                            @if($mySubmission->nilai !== null)
                            <div class="text-right">
                                <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Skor Nilai</span>
                                <span class="text-2xl font-extrabold text-green-600 block">{{ $mySubmission->nilai }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="text-xs text-gray-600 space-y-2 mb-4">
                            <p><strong>Format Kirim:</strong> <span class="uppercase font-semibold">{{ $mySubmission->tipe_submit }}</span></p>
                            @if($mySubmission->tipe_submit === 'link')
                            <p><strong>Link URL:</strong> <a href="{{ $mySubmission->konten }}" target="_blank" class="text-indigo-600 hover:underline">{{ $mySubmission->konten }}</a></p>
                            @else
                            <p><strong>File:</strong> <a href="{{ asset('storage/' . $mySubmission->file_path) }}" target="_blank" class="text-indigo-600 hover:underline font-bold">{{ $mySubmission->nama_file }}</a></p>
                            @endif
                            @if($mySubmission->catatan)
                            <p><strong>Catatan Anda:</strong> {{ $mySubmission->catatan }}</p>
                            @endif
                        </div>

                        @if($mySubmission->feedback)
                        <div class="bg-white border border-slate-100 p-4 rounded-xl">
                            <span class="text-[10px] text-gray-400 font-bold block uppercase tracking-wider">Catatan/Umpan Balik Guru</span>
                            <p class="text-xs text-gray-700 mt-1 font-medium italic">{{ $mySubmission->feedback }}</p>
                        </div>
                        @endif

                        {{-- Tombol Kumpul Ulang --}}
                        <button onclick="document.getElementById('formKumpulTugas').classList.remove('hidden')" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">
                            Kirim Ulang Jawaban (Re-upload)
                        </button>
                    </div>
                    @endif

                    {{-- Form upload --}}
                    <form id="formKumpulTugas" action="{{ route('siswa.elearning.submission.store', $session->id) }}" method="POST" enctype="multipart/form-data"
                        class="{{ $mySubmission ? 'hidden' : '' }} space-y-4 max-w-lg" x-data="{ tipeSubmit: 'file' }">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Pilih Metode Pengumpulan</label>
                            <select name="tipe_submit" x-model="tipeSubmit" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none">
                                <option value="file">Unggah Dokumen (PDF, PPT, Word)</option>
                                <option value="gambar">Unggah Gambar</option>
                                <option value="video">Unggah Video</option>
                                <option value="link">Kirim Tautan / Link URL</option>
                            </select>
                        </div>

                        <div x-show="tipeSubmit !== 'link'">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Pilih File</label>
                            <input type="file" name="file" :required="tipeSubmit !== 'link'"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none">
                            <span class="text-[10px] text-gray-400 mt-1 block">Maksimal file 50MB.</span>
                        </div>

                        <div x-show="tipeSubmit === 'link'">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Tautan URL Tugas</label>
                            <input type="url" name="konten" placeholder="https://example.com/..." :required="tipeSubmit === 'link'"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Catatan Pengantar (opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Tuliskan catatan singkat kepada guru..."
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white font-bold rounded-xl text-xs shadow-md">
                            Kirim Jawaban Tugas
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: FORUM DISKUSI --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'forum'" class="space-y-6">
            @if(!$pretestDone)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center text-amber-700">
                <i data-lucide="lock" class="w-10 h-10 mx-auto mb-2 opacity-70"></i>
                <h3 class="font-bold">Forum Diskusi Terkunci!</h3>
                <p class="text-xs mt-1">Harap selesaikan **Pretest** terlebih dahulu untuk bergabung ke forum diskusi.</p>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="message-square" class="text-orange-500"></i> Forum Diskusi Modul
                </h2>

                {{-- Post Message Form --}}
                <form action="{{ route('siswa.elearning.diskusi.store', $session->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100">
                    @csrf
                    <div class="mb-3">
                        <textarea name="pesan" rows="3" required placeholder="Tulis pesan atau pertanyaan Anda di forum diskusi..."
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none resize-none"></textarea>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <label class="cursor-pointer inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-orange-600 font-bold">
                                <input type="file" name="file" class="hidden">
                                <i data-lucide="paperclip" class="w-4 h-4"></i> Lampirkan File
                            </label>
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white font-bold rounded-xl text-xs shadow-md">
                            Kirim Pesan
                        </button>
                    </div>
                </form>

                {{-- Discussion List --}}
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                    @forelse($discussions as $disc)
                    <div class="border-b border-gray-100 pb-5 last:border-0">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-500 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($disc->user->name, 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-800">{{ $disc->user->name }}</span>
                                        @if($disc->user->role === 'guru')
                                        <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700">GURU</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-gray-400">{{ $disc->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{!! nl2br(e($disc->pesan)) !!}</p>
                                
                                @if($disc->file_path)
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-xs text-gray-400">Lampiran:</span>
                                    <a href="{{ asset('storage/' . $disc->file_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline flex items-center gap-1 font-bold">
                                        {{ $disc->nama_file }} <i data-lucide="external-link" class="w-3 h-3"></i>
                                    </a>
                                </div>
                                @endif

                                {{-- Reply Form --}}
                                <button onclick="toggleReplyForm({{ $disc->id }})" class="mt-2.5 text-xs text-orange-600 hover:underline font-bold flex items-center gap-1">
                                    <i data-lucide="corner-down-right" class="w-3 h-3"></i> Balas
                                </button>

                                <form id="reply-form-{{ $disc->id }}" action="{{ route('siswa.elearning.diskusi.store', $session->id) }}" method="POST" class="hidden mt-3 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $disc->id }}">
                                    <textarea name="pesan" rows="2" required placeholder="Tulis balasan Anda..."
                                        class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-xs focus:ring-1 focus:ring-orange-300 focus:border-orange-400 outline-none resize-none"></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" class="px-3.5 py-1.5 bg-gradient-to-r from-orange-500 to-rose-600 text-white rounded-lg text-xs font-bold">Kirim Balasan</button>
                                    </div>
                                </form>

                                {{-- Replies List --}}
                                @if($disc->replies->isNotEmpty())
                                <div class="mt-4 space-y-4 pl-6 border-l-2 border-slate-100">
                                    @foreach($disc->replies as $rep)
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-slate-400 text-white flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($rep->user->name, 0, 2)) }}
                                        </div>
                                        <div class="flex-1 bg-slate-50 p-3 rounded-xl border border-slate-100/50">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-bold text-gray-800">{{ $rep->user->name }}</span>
                                                    @if($rep->user->role === 'guru')
                                                    <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700">GURU</span>
                                                    @endif
                                                </div>
                                                <span class="text-[9px] text-gray-400">{{ $rep->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">{!! nl2br(e($rep->pesan)) !!}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 text-gray-400">
                        <i data-lucide="message-square" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                        <p class="text-sm font-semibold">Forum diskusi belum dimulai. Kirim pesan pertama untuk membuka diskusi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: POSTTEST --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'posttest'" class="space-y-6">
            @if(!$pretestDone)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center text-amber-700">
                <i data-lucide="lock" class="w-10 h-10 mx-auto mb-2 opacity-70"></i>
                <h3 class="font-bold">Posttest Terkunci!</h3>
                <p class="text-xs mt-1">Selesaikan **Pretest** terlebih dahulu untuk mengaktifkan posttest.</p>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="check-square" class="text-orange-500"></i> Tes Akhir (Posttest)
                </h2>
                
                @if($posttestDone)
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 text-center max-w-md mx-auto">
                    <div class="w-16 h-16 bg-green-100 text-green-600 flex items-center justify-center rounded-full mx-auto mb-4">
                        <i data-lucide="check-circle-2" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Posttest Telah Selesai!</h3>
                    <p class="text-xs text-gray-500 mt-1">Anda sudah menyelesaikan Posttest untuk pertemuan ini.</p>
                    
                    <div class="mt-4 p-4 bg-white rounded-xl border border-green-200 inline-block">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block tracking-wider">Skor Posttest Anda</span>
                        <span class="text-3xl font-extrabold text-green-600">{{ $nilaiPosttest }} / 100</span>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('siswa.elearning.hasil', [$session->id, 'posttest']) }}" class="text-xs text-indigo-600 hover:underline font-bold">
                            Lihat Pembahasan Jawaban
                        </a>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-600 text-sm max-w-md mx-auto mb-5">
                        Selesaikan pembelajaran dengan melakukan posttest. Soal-soal posttest akan sama persis dengan pretest untuk mengukur tingkat peningkatan pemahaman Anda.
                    </p>
                    @if($session->posttestQuestions->isEmpty())
                    <p class="text-xs text-gray-400 italic">Soal belum dipersiapkan oleh guru pengampu.</p>
                    @else
                    <a href="{{ route('siswa.elearning.posttest', $session->id) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white font-bold rounded-xl text-sm shadow-md shadow-orange-100 transition-all">
                        <i data-lucide="play" class="w-4 h-4"></i> Mulai Posttest (5 Pertanyaan)
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) lucide.createIcons();
});

function toggleReplyForm(id) {
    const form = document.getElementById(`reply-form-${id}`);
    form.classList.toggle('hidden');
}
</script>
@endpush
