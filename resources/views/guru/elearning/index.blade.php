@extends('layouts.sidebar-guru')
@section('title', 'E-Learning')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                    <i data-lucide="monitor-play" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">E-Learning</h1>
                    <p class="text-sm text-gray-500">Kelola pertemuan dan materi pembelajaran interaktif</p>
                </div>
            </div>
            <button onclick="document.getElementById('modalBuatPertemuan').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i> Buat Pertemuan
            </button>
        </div>

        @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium flex items-center gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalPertemuan = $sessions->count();
                $published = $sessions->where('is_published', true)->count();
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-3xl font-extrabold text-indigo-600">{{ $totalPertemuan }}</div>
                <div class="text-xs text-gray-500 mt-1 font-medium">Total Pertemuan</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-3xl font-extrabold text-green-600">{{ $published }}</div>
                <div class="text-xs text-gray-500 mt-1 font-medium">Dipublikasikan</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-3xl font-extrabold text-amber-500">{{ $totalPertemuan - $published }}</div>
                <div class="text-xs text-gray-500 mt-1 font-medium">Draft</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-3xl font-extrabold text-purple-600">{{ $sessions->pluck('school_class_id')->unique()->count() }}</div>
                <div class="text-xs text-gray-500 mt-1 font-medium">Kelas Aktif</div>
            </div>
        </div>

        {{-- Session Cards --}}
        @if($sessions->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="monitor-off" class="w-8 h-8 text-indigo-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-400 mb-2">Belum Ada Pertemuan</h3>
            <p class="text-sm text-gray-400">Klik "Buat Pertemuan" untuk memulai E-Learning</p>
        </div>
        @else
        {{-- Group by subject + class --}}
        @php
            $grouped = $sessions->groupBy(fn($s) => ($s->subject->nama ?? '-') . ' — ' . ($s->schoolClass->tingkat ?? '') . ' ' . ($s->schoolClass->nama_kelas ?? ''));
        @endphp
        @foreach($grouped as $label => $group)
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-px flex-1 bg-gradient-to-r from-indigo-200 to-transparent"></div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-3 py-1 rounded-full">{{ $label }}</span>
                <div class="h-px flex-1 bg-gradient-to-l from-indigo-200 to-transparent"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($group as $session)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-indigo-100 text-xs font-medium">Pertemuan {{ $session->urutan }}</span>
                                <h3 class="text-white font-bold text-base mt-0.5 line-clamp-2">{{ $session->judul }}</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $session->is_published ? 'bg-green-400 text-white' : 'bg-white/20 text-white' }}">
                                {{ $session->is_published ? 'Publik' : 'Draft' }}
                            </span>
                        </div>
                        @if($session->deskripsi)
                        <p class="text-indigo-200 text-xs mt-2 line-clamp-2">{{ $session->deskripsi }}</p>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <span class="flex items-center gap-1"><i data-lucide="help-circle" class="w-3 h-3"></i> {{ $session->pretestQuestions->count() }}/5 Soal</span>
                            <span class="text-gray-300">•</span>
                            <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i> {{ $session->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('guru.elearning.show', $session->id) }}"
                               class="flex-1 text-center py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">
                                Kelola
                            </a>
                            <form action="{{ route('guru.elearning.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Hapus pertemuan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-500 text-xs font-bold rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

{{-- Modal Buat Pertemuan --}}
<div id="modalBuatPertemuan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="font-extrabold text-gray-800 text-lg">Buat Pertemuan Baru</h3>
            <button onclick="document.getElementById('modalBuatPertemuan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('guru.elearning.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Mata Pelajaran</label>
                <select name="subject_id" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kelas</label>
                <select name="school_class_id" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->tingkat }} {{ $class->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Pertemuan</label>
                <input type="text" name="judul" required placeholder="Contoh: Pertemuan 1 — Pengenalan Aljabar"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Deskripsi (opsional)</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat topik pertemuan..."
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" id="cbPublish">
                <label for="cbPublish" class="text-sm text-gray-600">Langsung publikasikan ke siswa</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalBuatPertemuan').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                    Buat Pertemuan
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
</script>
@endpush
