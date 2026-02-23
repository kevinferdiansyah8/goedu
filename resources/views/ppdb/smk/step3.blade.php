@extends('layouts.ppdb')
@section('title', 'Pendaftaran SMK - Step 3 | Dokumen')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-xl">

    {{-- PROGRESS STEPPER --}}
    <div class="flex items-center justify-center mb-8">
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-green-200 ring-4 ring-green-100"><i data-lucide="check" class="w-4 h-4"></i></div>
        <span class="text-xs font-semibold text-green-500 mt-1.5">Data Diri</span>
      </div>
      <div class="w-16 h-0.5 bg-green-300 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-green-200 ring-4 ring-green-100"><i data-lucide="check" class="w-4 h-4"></i></div>
        <span class="text-xs font-semibold text-green-500 mt-1.5">Data Keluarga</span>
      </div>
      <div class="w-16 h-0.5 bg-green-300 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-amber-200 ring-4 ring-amber-100">3</div>
        <span class="text-xs font-semibold text-amber-500 mt-1.5">Dokumen</span>
      </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/80 border border-gray-100 overflow-hidden">
      <div class="bg-gradient-to-r from-amber-500 to-amber-400 px-8 py-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center"><i data-lucide="file-text" class="w-5 h-5 text-white"></i></div>
          <div>
            <p class="text-amber-100 text-xs font-medium uppercase tracking-widest">Pendaftaran SMK • Langkah 3 dari 3</p>
            <h1 class="text-white font-extrabold text-lg">Kelengkapan Dokumen SMK</h1>
          </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4">
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold"><i data-lucide="school" class="w-3 h-3"></i> Jenjang: SMK</span>
          @if(request('jalur'))
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold"><i data-lucide="route" class="w-3 h-3"></i> Jalur: {{ ucfirst(request('jalur')) }}</span>
          @endif
        </div>
      </div>

      <div class="px-8 py-8">
        <form action="{{ url('/ppdb/register/smk/success') }}" method="get" class="space-y-5">
          <input type="hidden" name="jalur" value="{{ request('jalur') }}">

          <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3.5 flex gap-2.5">
            <i data-lucide="triangle-alert" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"></i>
            <p class="text-xs text-amber-700 leading-relaxed">Siapkan dokumen fisik berikut sebelum hari H pendaftaran. Centang semua yang sudah disiapkan.</p>
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Dokumen Wajib SMK <span class="text-red-400">*</span></label>
            <div class="space-y-2.5">
              @php
                $dokumen = [
                  ['icon' => 'scroll-text',  'label' => 'Ijazah SMP / MTs (asli + fotokopi)'],
                  ['icon' => 'file-check',   'label' => 'SKHUN SMP / MTs'],
                  ['icon' => 'file-badge',   'label' => 'Akta Kelahiran (asli + fotokopi)'],
                  ['icon' => 'id-card',      'label' => 'Kartu Keluarga (asli + fotokopi)'],
                  ['icon' => 'book-open',    'label' => 'Rapor SMP kelas 7–9 semester 1–5 (fotokopi)'],
                  ['icon' => 'image',        'label' => 'Pas Foto 3×4 berwarna (2 lembar)'],
                  ['icon' => 'stethoscope', 'label' => 'Surat Keterangan Sehat dari Dokter'],
                ];
              @endphp
              @foreach($dokumen as $dok)
              <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-amber-300 hover:bg-amber-50 transition-all has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/60 group">
                <input type="checkbox" name="dokumen[]" value="{{ $dok['label'] }}" class="w-4 h-4 accent-amber-500 shrink-0">
                <i data-lucide="{{ $dok['icon'] }}" class="w-4 h-4 text-gray-400 group-has-[:checked]:text-amber-500 shrink-0 transition-colors"></i>
                <span class="text-sm text-gray-700 group-has-[:checked]:text-amber-700 font-medium transition-colors">{{ $dok['label'] }}</span>
              </label>
              @endforeach
            </div>
          </div>

          {{-- Dokumen Jalur --}}
          @if(request('jalur') === 'zonasi')
          <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Dokumen Tambahan — Jalur Zonasi</label>
            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-blue-100 bg-blue-50/50 cursor-pointer hover:border-blue-300 transition-all has-[:checked]:border-blue-400 has-[:checked]:bg-blue-50 group">
              <input type="checkbox" name="dokumen[]" value="Bukti alamat" class="w-4 h-4 accent-blue-600 shrink-0">
              <i data-lucide="zap" class="w-4 h-4 text-blue-300 group-has-[:checked]:text-blue-600 shrink-0"></i>
              <span class="text-sm text-gray-700 font-medium">Bukti alamat (tagihan listrik / air / rekening bank)</span>
            </label>
          </div>
          @endif
          @if(request('jalur') === 'afirmasi')
          <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Dokumen Tambahan — Jalur Afirmasi</label>
            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-green-100 bg-green-50/50 cursor-pointer hover:border-green-300 transition-all has-[:checked]:border-green-400 has-[:checked]:bg-green-50 group">
              <input type="checkbox" name="dokumen[]" value="KIP atau SKTM" class="w-4 h-4 accent-green-600 shrink-0">
              <i data-lucide="badge-check" class="w-4 h-4 text-green-300 group-has-[:checked]:text-green-600 shrink-0"></i>
              <span class="text-sm text-gray-700 font-medium">Kartu Indonesia Pintar (KIP) atau SKTM</span>
            </label>
          </div>
          @endif

          <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5">
            <label class="flex items-start gap-3 cursor-pointer">
              <input type="checkbox" name="setuju" required class="w-4 h-4 accent-amber-500 mt-0.5 shrink-0">
              <span class="text-xs text-gray-600 leading-relaxed">
                Saya menyatakan bahwa seluruh data yang diisikan adalah <strong class="text-gray-800">benar dan dapat dipertanggungjawabkan</strong>.
                Jika ditemukan data palsu, pendaftaran dapat <strong class="text-red-500">dibatalkan</strong>.
              </span>
            </label>
          </div>

          <div class="border-t border-dashed border-gray-200 pt-2"></div>

          <div class="flex gap-3">
            <a href="{{ url('/ppdb/register/smk/step2?jalur='.request('jalur')) }}"
              class="flex-1 flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3.5 rounded-xl text-sm transition-all">
              <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit"
              class="flex-1 flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition-all text-sm">
              <i data-lucide="send" class="w-4 h-4"></i> Kirim Pendaftaran
            </button>
          </div>
        </form>
      </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-5">
      <i data-lucide="shield-check" class="w-3.5 h-3.5 inline-block mr-1 text-green-400"></i>
      Data yang Anda masukkan aman dan terenkripsi
    </p>
  </div>
</section>
@endsection
