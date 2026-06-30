@extends('layouts.sidebar-guru')
@section('title', 'Detail Pertemuan - E-Learning')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6" x-data="{ tab: 'pretest' }">
    <div class="max-w-7xl mx-auto">
        
        {{-- Back button & Header --}}
        <div class="mb-6">
            <a href="{{ route('guru.elearning.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-indigo-600 transition-colors mb-3">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke E-Learning
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-indigo-600 uppercase bg-indigo-50 px-2.5 py-1 rounded-full">
                        Pertemuan {{ $session->urutan }} — {{ $session->subject->nama }} ({{ $session->schoolClass->tingkat }} {{ $session->schoolClass->nama_kelas }})
                    </span>
                    <h1 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $session->judul }}</h1>
                    @if($session->deskripsi)
                    <p class="text-sm text-gray-500 mt-1">{{ $session->deskripsi }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('modalEditPertemuan').classList.remove('hidden')" class="px-4 py-2 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all shadow-sm">
                        Edit Informasi
                    </button>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $session->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $session->is_published ? 'Dipublikasikan' : 'Draft / Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Tab Headers --}}
        <div class="bg-white rounded-2xl p-1.5 border border-gray-100 shadow-sm flex flex-wrap gap-1 mb-6">
            <button @click="tab = 'pretest'" :class="tab === 'pretest' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="help-circle" class="w-4 h-4"></i> 1. Pretest
            </button>
            <button @click="tab = 'materi'" :class="tab === 'materi' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="book-open" class="w-4 h-4"></i> 2. Link Pembelajaran
            </button>
            <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4"></i> 3. Penugasan
            </button>
            <button @click="tab = 'forum'" :class="tab === 'forum' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="message-square" class="w-4 h-4"></i> 4. Forum Diskusi
            </button>
            <button @click="tab = 'posttest'" :class="tab === 'posttest' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="check-square" class="w-4 h-4"></i> 5. Posttest
            </button>
            <button @click="tab = 'nilai'" :class="tab === 'nilai' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                class="flex-1 min-w-[120px] text-center py-2.5 px-4 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="award" class="w-4 h-4"></i> Hasil Nilai Siswa
            </button>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: PRETEST --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'pretest'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between border-b pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="help-circle" class="text-indigo-600"></i> Kelola Soal Pretest
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Guru menginputkan 5 soal pilihan ganda untuk test awal.
                        </p>
                    </div>
                    @if($session->pretestQuestions->count() < 5)
                    <button onclick="openTambahSoalModal('pretest')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-md shadow-indigo-100">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Soal ({{ $session->pretestQuestions->count() }}/5)
                    </button>
                    @endif
                </div>

                {{-- Soal List --}}
                @if($session->pretestQuestions->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i data-lucide="help-circle" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">Belum ada soal pretest ditambahkan.</p>
                    <p class="text-xs mt-1">Tambahkan maksimal 5 soal pilihan ganda di bawah ini.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($session->pretestQuestions as $idx => $q)
                    <div class="border border-gray-100 rounded-xl p-5 bg-slate-50/50 hover:bg-slate-50 transition-all relative">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <span class="text-xs font-extrabold text-indigo-600 uppercase">Pertanyaan {{ $idx + 1 }}</span>
                                <p class="text-sm font-bold text-gray-800 mt-1">{!! nl2br(e($q->pertanyaan)) !!}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3 text-xs">
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'a' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        A. {{ $q->opsi_a }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'b' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        B. {{ $q->opsi_b }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'c' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        C. {{ $q->opsi_c }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'd' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        D. {{ $q->opsi_d }}
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('guru.elearning.soal.destroy', [$session->id, $q->id]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: LINK PEMBELAJARAN --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'materi'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between border-b pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="book-open" class="text-indigo-600"></i> Link & Bahan Pembelajaran
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Unggah file presentasi (PPT/PDF/Word) atau cantumkan tautan eksternal (Link Website / Video YouTube).
                        </p>
                    </div>
                    <button onclick="document.getElementById('modalTambahMateri').classList.remove('hidden')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-md">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Bahan Ajar
                    </button>
                </div>

                @if($session->materials->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">Belum ada bahan ajar yang diunggah.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($session->materials as $mat)
                    <div class="border border-gray-100 rounded-xl p-4 bg-slate-50/50 hover:bg-slate-50 transition-all flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i data-lucide="{{ $mat->icon }}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $mat->judul }}</h4>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $mat->tipe }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($mat->tipe === 'file')
                            <a href="{{ asset('storage/' . $mat->konten) }}" target="_blank" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </a>
                            @else
                            <a href="{{ $mat->konten }}" target="_blank" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                            @endif
                            <form action="{{ route('guru.elearning.materi.destroy', [$session->id, $mat->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
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
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="text-indigo-600"></i> Buat / Edit Instruksi Tugas
                </h2>
                
                <form action="{{ route('guru.elearning.tugas.store', $session->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Instruksi Tugas</label>
                        <textarea name="instruksi" rows="5" required placeholder="Tuliskan detail tugas atau petunjuk pengerjaan di sini..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-y">{{ $session->assignment->instruksi ?? '' }}</textarea>
                    </div>
                    <div class="max-w-xs">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 font-bold uppercase tracking-wider">Batas Pengumpulan (Deadline)</label>
                        <input type="datetime-local" name="deadline" value="{{ isset($session->assignment->deadline) ? $session->assignment->deadline->format('Y-m-d\TH:i') : '' }}"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md transition-all active:scale-95">
                        Simpan Instruksi Tugas
                    </button>
                </form>
            </div>

            {{-- Penilaian Submissions Siswa --}}
            @if($session->assignment)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-check" class="text-indigo-600"></i> Pengumpulan Tugas Siswa
                </h2>

                @if($submissions->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">Belum ada siswa yang mengumpulkan tugas.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b">
                                <th class="px-6 py-3">Nama Siswa</th>
                                <th class="px-6 py-3">Format</th>
                                <th class="px-6 py-3">Konten / File</th>
                                <th class="px-6 py-3">Catatan Siswa</th>
                                <th class="px-6 py-3">Tanggal Kirim</th>
                                <th class="px-6 py-3 text-center">Nilai</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($submissions as $sub)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $sub->student->nama }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sub->tipe_submit === 'link' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $sub->tipe_submit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($sub->tipe_submit === 'link')
                                    <a href="{{ $sub->konten }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1">
                                        Link Tugas <i data-lucide="external-link" class="w-3 h-3"></i>
                                    </a>
                                    @else
                                    <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1">
                                        {{ $sub->nama_file ?? 'Download File' }} <i data-lucide="download" class="w-3 h-3"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs max-w-xs truncate">{{ $sub->catatan ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs text-gray-400">{{ $sub->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-center font-bold text-sm text-gray-800">
                                    @if($sub->nilai !== null)
                                    <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-lg">{{ $sub->nilai }}</span>
                                    @else
                                    <span class="text-red-400 italic">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="openGradeModal({{ $sub->id }}, '{{ $sub->student->nama }}', '{{ $sub->nilai ?? '' }}', '{{ $sub->feedback ?? '' }}')"
                                        class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold rounded-lg text-xs transition-colors">
                                        Nilai
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: FORUM DISKUSI --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'forum'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="message-square" class="text-indigo-600"></i> Forum Diskusi Kelas
                </h2>

                {{-- Post Message Form --}}
                <form action="{{ route('guru.elearning.diskusi.store', $session->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100">
                    @csrf
                    <div class="mb-3">
                        <textarea name="pesan" rows="3" required placeholder="Tuliskan topik atau pertanyaan diskusi untuk kelas..."
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-none"></textarea>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <label class="cursor-pointer inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-indigo-600 font-bold">
                                <input type="file" name="file" class="hidden">
                                <i data-lucide="paperclip" class="w-4 h-4"></i> Lampirkan File
                            </label>
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md transition-all">
                            Kirim Diskusi
                        </button>
                    </div>
                </form>

                {{-- Discussion List --}}
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                    @forelse($session->discussions as $disc)
                    <div class="border-b border-gray-100 pb-5 last:border-0">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-500 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($disc->user->name, 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-800">{{ $disc->user->name }}</span>
                                        <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700">GURU</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-gray-400">{{ $disc->created_at->diffForHumans() }}</span>
                                        <form action="{{ route('guru.elearning.diskusi.destroy', [$session->id, $disc->id]) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600"><i data-lucide="trash" class="w-3.5 h-3.5"></i></button>
                                        </form>
                                    </div>
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
                                <button onclick="toggleReplyForm({{ $disc->id }})" class="mt-2.5 text-xs text-indigo-600 hover:underline font-bold flex items-center gap-1">
                                    <i data-lucide="corner-down-right" class="w-3 h-3"></i> Balas
                                </button>

                                <form id="reply-form-{{ $disc->id }}" action="{{ route('guru.elearning.diskusi.store', $session->id) }}" method="POST" class="hidden mt-3 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $disc->id }}">
                                    <textarea name="pesan" rows="2" required placeholder="Tulis balasan Anda..."
                                        class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-xs focus:ring-1 focus:ring-indigo-300 focus:border-indigo-400 outline-none resize-none"></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold">Kirim Balasan</button>
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
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-[9px] text-gray-400">{{ $rep->created_at->diffForHumans() }}</span>
                                                    @if($rep->user_id === Auth::id())
                                                    <form action="{{ route('guru.elearning.diskusi.destroy', [$session->id, $rep->id]) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-600"><i data-lucide="trash" class="w-3.5 h-3.5"></i></button>
                                                    </form>
                                                    @endif
                                                </div>
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
                        <p class="text-sm font-semibold">Forum diskusi belum dimulai.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: POSTTEST --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'posttest'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between border-b pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="check-square" class="text-indigo-600"></i> Kelola Soal Posttest
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Guru menginputkan 5 soal pilihan ganda untuk test akhir.
                        </p>
                    </div>
                    @if($session->posttestQuestions->count() < 5)
                    <button onclick="openTambahSoalModal('posttest')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-md shadow-indigo-100">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Soal ({{ $session->posttestQuestions->count() }}/5)
                    </button>
                    @endif
                </div>

                {{-- Soal List --}}
                @if($session->posttestQuestions->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <i data-lucide="check-square" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">Belum ada soal posttest ditambahkan.</p>
                    <p class="text-xs mt-1">Tambahkan maksimal 5 soal pilihan ganda di bawah ini.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($session->posttestQuestions as $idx => $q)
                    <div class="border border-gray-100 rounded-xl p-5 bg-slate-50/50 hover:bg-slate-50 transition-all relative">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <span class="text-xs font-extrabold text-indigo-600 uppercase">Pertanyaan {{ $idx + 1 }}</span>
                                <p class="text-sm font-bold text-gray-800 mt-1">{!! nl2br(e($q->pertanyaan)) !!}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3 text-xs">
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'a' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        A. {{ $q->opsi_a }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'b' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        B. {{ $q->opsi_b }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'c' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        C. {{ $q->opsi_c }}
                                    </div>
                                    <div class="px-3 py-2 rounded-lg border {{ $q->jawaban_benar === 'd' ? 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm' : 'bg-white border-gray-100 text-gray-600' }}">
                                        D. {{ $q->opsi_d }}
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('guru.elearning.soal.destroy', [$session->id, $q->id]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- TAB: REKAP NILAI SISWA --}}
        {{-- ───────────────────────────────────────────── --}}
        <div x-show="tab === 'nilai'" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 border-b pb-4 mb-4 flex items-center gap-2">
                    <i data-lucide="award" class="text-indigo-600"></i> Rekap Nilai Ujian Siswa
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b">
                                <th class="px-6 py-3">Nama Siswa</th>
                                <th class="px-6 py-3 text-center">Pretest (Skor)</th>
                                <th class="px-6 py-3 text-center">Posttest (Skor)</th>
                                <th class="px-6 py-3 text-center">Status Pretest</th>
                                <th class="px-6 py-3 text-center">Status Posttest</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                            @php
                                $pre = $nilaiPretest[$student->id] ?? null;
                                $post = $nilaiPosttest[$student->id] ?? null;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $student->nama }}</td>
                                <td class="px-6 py-4 text-center font-bold text-base {{ ($pre['nilai'] ?? 0) >= 60 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $pre && $pre['selesai'] ? $pre['nilai'] : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-base {{ ($post['nilai'] ?? 0) >= 60 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $post && $post['selesai'] ? $post['nilai'] : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($pre && $pre['selesai'])
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                        Selesai
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                        Belum Mengerjakan
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($post && $post['selesai'])
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                        Selesai
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                        Belum Mengerjakan
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL: EDIT PERTEMUAN --}}
<div id="modalEditPertemuan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="font-extrabold text-gray-800 text-lg">Edit Informasi Pertemuan</h3>
            <button onclick="document.getElementById('modalEditPertemuan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('guru.elearning.update', $session->id) }}" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Pertemuan</label>
                <input type="text" name="judul" value="{{ $session->judul }}" required
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-none">{{ $session->deskripsi }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" id="cbEditPublish" {{ $session->is_published ? 'checked' : '' }}>
                <label for="cbEditPublish" class="text-sm text-gray-600">Publikasikan ke siswa</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalEditPertemuan').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: TAMBAH SOAL --}}
<div id="modalTambahSoal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg my-8">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="font-extrabold text-gray-800 text-lg" id="modalTambahSoalTitle">Tambah Pertanyaan PG</h3>
            <button onclick="document.getElementById('modalTambahSoal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('guru.elearning.soal.store', $session->id) }}" method="POST" class="p-5 space-y-4">
            @csrf
            <input type="hidden" name="tipe" id="modalTambahSoalTipe" value="pretest">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" required placeholder="Tuliskan butir pertanyaan di sini..."
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-none"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Opsi A</label>
                    <input type="text" name="opsi_a" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Opsi B</label>
                    <input type="text" name="opsi_b" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Opsi C</label>
                    <input type="text" name="opsi_c" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Opsi D</label>
                    <input type="text" name="opsi_d" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pilihan Jawaban yang Benar</label>
                <select name="jawaban_benar" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                    <option value="">-- Pilih Jawaban Benar --</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambahSoal').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                    Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: TAMBAH MATERI --}}
<div id="modalTambahMateri" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" x-data="{ tipe: 'file' }">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="font-extrabold text-gray-800 text-lg">Tambah Bahan Ajar</h3>
            <button onclick="document.getElementById('modalTambahMateri').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('guru.elearning.materi.store', $session->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Materi</label>
                <input type="text" name="judul" required placeholder="Contoh: Slide Modul 1"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jenis Bahan Ajar</label>
                <select name="tipe" x-model="tipe" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                    <option value="file">File (PDF, PPT, Word, dll)</option>
                    <option value="link">Tautan Eksternal / Link URL</option>
                    <option value="youtube">Link Video YouTube</option>
                </select>
            </div>
            
            <div x-show="tipe === 'file'">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pilih File</label>
                <input type="file" name="file" :required="tipe === 'file'"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                <span class="text-[10px] text-gray-400 mt-1 block">Format: PDF, PPT, Word, Excel. Maksimal 50MB.</span>
            </div>

            <div x-show="tipe !== 'file'">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Masukkan URL</label>
                <input type="url" name="url" placeholder="https://example.com/..." :required="tipe !== 'file'"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambahMateri').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: PENILAIAN TUGAS --}}
<div id="modalNilaiTugas" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="font-extrabold text-gray-800 text-lg">Beri Nilai Tugas</h3>
            <button onclick="document.getElementById('modalNilaiTugas').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="formNilaiTugas" action="" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider font-bold">Nama Siswa</label>
                <p id="gradeStudentName" class="text-sm font-extrabold text-gray-800"></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider font-bold">Masukkan Skor (0 - 100)</label>
                <input type="number" name="nilai" id="gradeScoreInput" required min="0" max="100" placeholder="Skor..."
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider font-bold">Catatan Umpan Balik (Feedback)</label>
                <textarea name="feedback" id="gradeFeedbackInput" rows="3" placeholder="Tulis masukan Anda untuk siswa..."
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalNilaiTugas').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) lucide.createIcons();
});

function openTambahSoalModal(tipe) {
    document.getElementById('modalTambahSoalTipe').value = tipe;
    const titleText = tipe === 'pretest' ? 'Tambah Pertanyaan Pretest' : 'Tambah Pertanyaan Posttest';
    document.getElementById('modalTambahSoalTitle').innerText = titleText;
    document.getElementById('modalTambahSoal').classList.remove('hidden');
}

function toggleReplyForm(id) {
    const form = document.getElementById(`reply-form-${id}`);
    form.classList.toggle('hidden');
}

function openGradeModal(id, name, score, feedback) {
    const form = document.getElementById('formNilaiTugas');
    form.action = `/guru/elearning/submission/${id}/grade`;
    
    document.getElementById('gradeStudentName').innerText = name;
    document.getElementById('gradeScoreInput').value = score;
    document.getElementById('gradeFeedbackInput').value = feedback;
    
    document.getElementById('modalNilaiTugas').classList.remove('hidden');
}
</script>
@endpush
