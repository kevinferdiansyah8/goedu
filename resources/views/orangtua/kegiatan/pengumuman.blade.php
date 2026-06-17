@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{ selectedAnn: null, showModal: false }">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengumuman Sekolah</h1>
        <p class="text-gray-600">Informasi penting dari pihak sekolah.</p>
    </div>

    <div class="space-y-4">
        @forelse($pengumuman as $p)
        <!-- Announcement Item -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-bold uppercase tracking-wider">
                            {{ $p->status === 'Aktif' ? 'Penting' : 'Info' }}
                        </span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                    </div>
                    <button @click="selectedAnn = @json($p); showModal = true" class="block text-xl font-bold text-gray-800 hover:text-blue-600 text-left transition-colors mb-2">
                        {{ $p->judul }}
                    </button>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        {{ $p->deskripsi }}
                    </p>
                </div>
                <div class="flex items-center">
                    <button @click="selectedAnn = @json($p); showModal = true" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200 whitespace-nowrap">
                        Baca Selengkapnya
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="py-12 flex flex-col items-center justify-center text-gray-400 bg-white rounded-xl border border-gray-100">
            <i data-lucide="megaphone" class="w-12 h-12 mb-4 text-gray-300"></i>
            <span class="text-lg font-medium">Belum ada pengumuman sekolah</span>
        </div>
        @endforelse
    </div>

    {{-- DETAIL MODAL --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 p-4 transition-opacity" style="display: none;">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg overflow-y-auto max-h-[90vh]" @click.away="showModal = false">
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-bold">
                    <i data-lucide="megaphone"></i>
                </span>
                <h3 class="text-2xl font-bold text-gray-950" x-text="selectedAnn ? selectedAnn.judul : ''"></h3>
            </div>

            <div class="mb-6 text-gray-700 text-base leading-relaxed whitespace-pre-wrap" x-text="selectedAnn ? selectedAnn.deskripsi : ''"></div>

            <div class="space-y-3 border-t border-gray-100 pt-4 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                    <span>Tanggal Terbit: <strong x-text="selectedAnn ? selectedAnn.tanggal_pelaksanaan : ''"></strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="users" class="w-4 h-4 text-gray-400"></i>
                    <span>Target Audiens: <strong x-text="selectedAnn ? (selectedAnn.jenis || 'Semua') : ''"></strong></span>
                </div>
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-gray-150">
                <button type="button" @click="showModal = false" class="px-7 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-bold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
