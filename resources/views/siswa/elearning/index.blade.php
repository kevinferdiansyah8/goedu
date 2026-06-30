@extends('layouts.sidebar-siswa')
@section('title', 'E-Learning Siswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-rose-600 flex items-center justify-center shadow-lg shadow-orange-200">
                <i data-lucide="monitor-play" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">E-Learning Pembelajaran</h1>
                <p class="text-sm text-gray-500">Akses modul, ikuti tes, dan kumpulkan tugas sekolah secara mandiri</p>
            </div>
        </div>

        @if(session('info'))
        <div class="mb-5 px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-700 text-sm font-medium flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4"></i> {{ session('info') }}
        </div>
        @endif

        {{-- Group by subject --}}
        @if($sessionsWithProgress->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="monitor-off" class="w-8 h-8 text-orange-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-400 mb-2">Belum Ada Pertemuan Aktif</h3>
            <p class="text-sm text-gray-400">Guru pengampu belum mempublikasikan pertemuan E-Learning untuk kelas Anda.</p>
        </div>
        @else
        @php
            $grouped = $sessionsWithProgress->groupBy('subject.nama');
        @endphp
        
        @foreach($grouped as $subjectName => $group)
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-px flex-1 bg-gradient-to-r from-orange-200 to-transparent"></div>
                <span class="text-xs font-bold text-orange-600 uppercase bg-orange-50 px-3.5 py-1 rounded-full tracking-wider">{{ $subjectName }}</span>
                <div class="h-px flex-1 bg-gradient-to-l from-orange-200 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($group as $session)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="bg-gradient-to-br from-orange-500 to-rose-600 p-4 text-white">
                            <span class="text-orange-200 text-xs font-semibold">Pertemuan {{ $session->urutan }}</span>
                            <h3 class="font-extrabold text-base mt-0.5 line-clamp-2">{{ $session->judul }}</h3>
                            @if($session->deskripsi)
                            <p class="text-xs text-orange-100 mt-2 line-clamp-2">{{ $session->deskripsi }}</p>
                            @endif
                        </div>

                        {{-- Progress checklist --}}
                        <div class="p-4 space-y-2 border-b border-slate-50">
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <span class="flex items-center gap-1.5 font-medium">
                                    <i data-lucide="{{ $session->pretest_done ? 'check-circle-2' : 'circle' }}" class="w-3.5 h-3.5 {{ $session->pretest_done ? 'text-green-500' : 'text-gray-300' }}"></i>
                                    Pretest (Wajib Awal)
                                </span>
                                @if($session->pretest_done)
                                <span class="text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded">Lulus</span>
                                @else
                                <span class="text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded">Belum</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <span class="flex items-center gap-1.5 font-medium">
                                    <i data-lucide="{{ $session->tugas_done ? 'check-circle-2' : 'circle' }}" class="w-3.5 h-3.5 {{ $session->tugas_done ? 'text-green-500' : 'text-gray-300' }}"></i>
                                    Tugas Terstruktur
                                </span>
                                @if($session->tugas_done)
                                <span class="text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded">Terkumpul</span>
                                @else
                                <span class="text-gray-400 font-bold bg-gray-50 px-1.5 py-0.5 rounded">Belum</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <span class="flex items-center gap-1.5 font-medium">
                                    <i data-lucide="{{ $session->posttest_done ? 'check-circle-2' : 'circle' }}" class="w-3.5 h-3.5 {{ $session->posttest_done ? 'text-green-500' : 'text-gray-300' }}"></i>
                                    Posttest (Wajib Akhir)
                                </span>
                                @if($session->posttest_done)
                                <span class="text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded">Selesai</span>
                                @else
                                <span class="text-gray-400 font-bold bg-gray-50 px-1.5 py-0.5 rounded">Belum</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50/50">
                        <a href="{{ route('siswa.elearning.show', $session->id) }}"
                           class="w-full block text-center py-2.5 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white text-xs font-bold rounded-xl shadow-md shadow-orange-100 transition-all">
                            Buka Pertemuan
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
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
