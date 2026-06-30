@extends('layouts.sidebar-siswa')
@section('title', 'Hasil Test - E-Learning')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-6">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Top Info Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden text-center p-8">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 uppercase tracking-wider">
                Hasil {{ ucfirst($tipe) }}
            </span>
            
            <h1 class="text-2xl font-extrabold text-gray-900 mt-3">{{ $session->judul }}</h1>
            <p class="text-sm text-gray-400 mt-1">Evaluasi pengerjaan Anda telah diperiksa secara otomatis</p>

            <div class="mt-6 flex justify-center gap-8 items-center">
                <div class="text-center">
                    <span class="text-3xl font-extrabold text-green-600 block">{{ $totalBenar }}</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Benar</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="p-6 bg-gradient-to-br from-orange-500 to-rose-600 rounded-2xl text-white shadow-lg shadow-orange-100">
                    <span class="text-[10px] text-orange-200 font-bold uppercase block tracking-wider">Skor Akhir</span>
                    <span class="text-4xl font-extrabold mt-1 block">{{ $totalNilai }} <span class="text-base text-orange-200 font-normal">/ 100</span></span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-center">
                    <span class="text-3xl font-extrabold text-red-500 block">{{ $totalSalah }}</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Salah</span>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="{{ route('siswa.elearning.show', $session->id) }}"
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-gray-700 text-xs font-bold rounded-xl transition-all">
                    Kembali ke Detail Pertemuan
                </a>
            </div>
        </div>

        {{-- Question Discussion --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6">
            <h2 class="text-base font-extrabold text-gray-800 border-b pb-4 mb-4 flex items-center gap-2">
                <i data-lucide="check-square" class="text-orange-500"></i> Pembahasan Soal
            </h2>

            <div class="space-y-6">
                @foreach($answers as $idx => $ans)
                @php
                    $q = $ans->question;
                @endphp
                <div class="border border-gray-100 rounded-2xl p-5 bg-slate-50/50 space-y-4">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                            {{ $idx + 1 }}
                        </span>
                        <p class="text-sm font-bold text-gray-800">{!! nl2br(e($q->pertanyaan)) !!}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-2 pl-8.5 text-xs">
                        @php
                            $options = ['a' => $q->opsi_a, 'b' => $q->opsi_b, 'c' => $q->opsi_c, 'd' => $q->opsi_d];
                        @endphp
                        
                        @foreach($options as $key => $val)
                        @php
                            $bgClass = 'bg-white border-gray-100 text-gray-600';
                            $icon = null;

                            if ($key === $q->jawaban_benar) {
                                // Jawaban yang benar (selalu di-highlight hijau)
                                $bgClass = 'bg-green-100 border-green-400 text-green-900 font-bold shadow-sm';
                                $icon = '<i data-lucide="check-circle" class="w-3.5 h-3.5 text-green-700"></i>';
                            } elseif ($key === $ans->jawaban && !$ans->is_correct) {
                                // Jawaban siswa salah (di-highlight merah)
                                $bgClass = 'bg-red-100 border-red-400 text-red-900 font-bold shadow-sm';
                                $icon = '<i data-lucide="x-circle" class="w-3.5 h-3.5 text-red-700"></i>';
                            }
                        @endphp
                        <div class="flex items-center justify-between p-3 rounded-xl border {{ $bgClass }}">
                            <span><strong>{{ strtoupper($key) }}.</strong> {{ $val }}</span>
                            @if($icon)
                            <span>{!! $icon !!}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="pl-8.5 pt-2 flex items-center justify-between border-t border-dashed text-xs text-gray-500">
                        <span>Pilihan Anda: <strong class="uppercase text-gray-700">{{ $ans->jawaban ?? '-' }}</strong></span>
                        @if($ans->is_correct)
                        <span class="text-green-600 font-bold flex items-center gap-1"><i data-lucide="check" class="w-3.5 h-3.5"></i> Benar (+20 Poin)</span>
                        @else
                        <span class="text-red-500 font-bold flex items-center gap-1"><i data-lucide="x" class="w-3.5 h-3.5"></i> Salah (+0 Poin)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

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
