@extends('layouts.sidebar-siswa')
@section('title', 'Mengerjakan Posttest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-orange-500 to-rose-600 p-6 text-white">
            <span class="text-xs font-bold text-orange-200 uppercase tracking-wider">Tes Akhir (Posttest)</span>
            <h1 class="text-xl font-extrabold mt-1">{{ $session->judul }}</h1>
            <p class="text-xs text-orange-100 mt-2">Pilih salah satu jawaban yang menurut Anda paling benar. Setiap jawaban benar bernilai 20 poin.</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('siswa.elearning.posttest.submit', $session->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            @foreach($session->posttestQuestions as $idx => $q)
            <div class="border border-gray-100 rounded-2xl p-5 bg-slate-50/50 space-y-4">
                <div class="flex items-start gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                        {{ $idx + 1 }}
                    </span>
                    <p class="text-sm font-bold text-gray-800">{!! nl2br(e($q->pertanyaan)) !!}</p>
                </div>

                <div class="grid grid-cols-1 gap-2.5 pl-8.5">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white hover:bg-slate-50 cursor-pointer transition-all">
                        <input type="radio" name="jawaban[{{ $q->id }}]" value="a" required class="text-orange-500 focus:ring-orange-200">
                        <span class="text-xs text-gray-700"><strong>A.</strong> {{ $q->opsi_a }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white hover:bg-slate-50 cursor-pointer transition-all">
                        <input type="radio" name="jawaban[{{ $q->id }}]" value="b" required class="text-orange-500 focus:ring-orange-200">
                        <span class="text-xs text-gray-700"><strong>B.</strong> {{ $q->opsi_b }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white hover:bg-slate-50 cursor-pointer transition-all">
                        <input type="radio" name="jawaban[{{ $q->id }}]" value="c" required class="text-orange-500 focus:ring-orange-200">
                        <span class="text-xs text-gray-700"><strong>C.</strong> {{ $q->opsi_c }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white hover:bg-slate-50 cursor-pointer transition-all">
                        <input type="radio" name="jawaban[{{ $q->id }}]" value="d" required class="text-orange-500 focus:ring-orange-200">
                        <span class="text-xs text-gray-700"><strong>D.</strong> {{ $q->opsi_d }}</span>
                    </label>
                </div>
            </div>
            @endforeach

            <div class="flex gap-4 pt-4">
                <a href="{{ route('siswa.elearning.show', $session->id) }}" class="flex-1 py-3 border border-gray-200 rounded-xl text-center text-sm text-gray-600 hover:bg-gray-50 font-bold transition-all">
                    Batal
                </a>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-orange-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-sm font-bold shadow-lg shadow-orange-100 transition-all active:scale-95">
                    Selesai & Kumpulkan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
