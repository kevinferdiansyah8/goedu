@extends('layouts.ppdb')
@section('title', 'PPDB SMP - Pilih Jalur Pendaftaran')
@section('content')

<section class="py-10 px-4">
  <div class="max-w-5xl mx-auto">

    {{-- BREADCRUMB --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
      <a href="{{ url('/ppdb') }}" class="hover:text-indigo-600 transition-colors">PPDB</a>
      <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
      <span class="text-gray-800 font-medium">Sekolah Menengah Pertama (SMP)</span>
    </nav>

    {{-- HEADER --}}
    <div class="text-center mb-10">
      <span class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
        <i data-lucide="school" class="w-3.5 h-3.5"></i> Jenjang SMP
      </span>
      <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3 leading-tight">
        Penerimaan Peserta Didik Baru<br class="hidden md:block">
        <span class="text-indigo-600">Sekolah Menengah Pertama (SMP)</span>
      </h1>
      <p class="text-gray-500 text-sm md:text-base max-w-lg mx-auto">
        Silakan pilih jalur pendaftaran sesuai dengan kriteria yang berlaku.
      </p>
      <div class="flex items-center justify-center gap-3 mt-6">
        <div class="h-px w-16 bg-gray-200"></div>
        <i data-lucide="star" class="w-4 h-4 text-indigo-400"></i>
        <div class="h-px w-16 bg-gray-200"></div>
      </div>
    </div>

    {{-- CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-10">

      {{-- 1. Zonasi --}}
      <a href="{{ url('/ppdb/register/smp/step1?jalur=zonasi') }}"
        class="group relative block rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 cursor-pointer overflow-hidden">
        <div class="h-1.5 w-full bg-blue-600 rounded-t-2xl"></div>
        <div class="bg-white px-6 pt-6 pb-7">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-colors">
            <i data-lucide="map-pin" class="w-7 h-7 text-blue-600"></i>
          </div>
          <span class="text-xs font-bold text-blue-400 tracking-widest uppercase mb-1 block">Jalur 01</span>
          <h2 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Jalur Zonasi</h2>
          <div class="space-y-1.5 mb-4">
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="home" class="w-3 h-3 text-blue-600"></i>
              </span>
              Alamat rumah sesuai zona sekolah
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="ruler" class="w-3 h-3 text-blue-600"></i>
              </span>
              Prioritas berdasarkan jarak terdekat ke sekolah
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="file-text" class="w-3 h-3 text-blue-600"></i>
              </span>
              KK diterbitkan <strong>min. 1 tahun</strong> sebelum pendaftaran
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="percent" class="w-3 h-3 text-blue-600"></i>
              </span>
              Kuota <strong>min. 50%</strong> dari daya tampung
            </div>
          </div>
          <div class="flex items-center gap-1.5 text-blue-600 text-sm font-semibold">
            Pilih Jalur Ini <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      {{-- 2. Afirmasi --}}
      <a href="{{ url('/ppdb/register/smp/step1?jalur=afirmasi') }}"
        class="group relative block rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 cursor-pointer overflow-hidden">
        <div class="h-1.5 w-full bg-green-600 rounded-t-2xl"></div>
        <div class="bg-white px-6 pt-6 pb-7">
          <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
            <i data-lucide="heart-handshake" class="w-7 h-7 text-green-600"></i>
          </div>
          <span class="text-xs font-bold text-green-400 tracking-widest uppercase mb-1 block">Jalur 02</span>
          <h2 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Jalur Afirmasi</h2>
          <div class="space-y-1.5 mb-4">
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i data-lucide="id-card" class="w-3 h-3 text-green-600"></i>
              </span>
              Pemegang KIP / SKTM / terdaftar PKH
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i data-lucide="accessibility" class="w-3 h-3 text-green-600"></i>
              </span>
              Penyandang disabilitas
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i data-lucide="percent" class="w-3 h-3 text-green-600"></i>
              </span>
              Kuota <strong>min. 15%</strong> dari daya tampung
            </div>
          </div>
          <div class="flex items-center gap-1.5 text-green-600 text-sm font-semibold">
            Pilih Jalur Ini <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      {{-- 3. Perpindahan --}}
      <a href="{{ url('/ppdb/register/smp/step1?jalur=perpindahan') }}"
        class="group relative block rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 cursor-pointer overflow-hidden">
        <div class="h-1.5 w-full bg-orange-500 rounded-t-2xl"></div>
        <div class="bg-white px-6 pt-6 pb-7">
          <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-4 group-hover:bg-orange-100 transition-colors">
            <i data-lucide="truck" class="w-7 h-7 text-orange-500"></i>
          </div>
          <span class="text-xs font-bold text-orange-400 tracking-widest uppercase mb-1 block">Jalur 03</span>
          <h2 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-orange-500 transition-colors">Jalur Perpindahan Orang Tua</h2>
          <div class="space-y-1.5 mb-4">
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                <i data-lucide="briefcase" class="w-3 h-3 text-orange-500"></i>
              </span>
              Orang tua pindah tugas resmi (PNS/ASN, TNI, POLRI)
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                <i data-lucide="file-signature" class="w-3 h-3 text-orange-500"></i>
              </span>
              Surat Tugas / SK Pindah masih berlaku aktif
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                <i data-lucide="percent" class="w-3 h-3 text-orange-500"></i>
              </span>
              Kuota <strong>max. 5%</strong> dari daya tampung sekolah
            </div>
          </div>
          <div class="flex items-center gap-1.5 text-orange-500 text-sm font-semibold">
            Pilih Jalur Ini <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      {{-- 4. Prestasi --}}
      <a href="{{ url('/ppdb/register/smp/step1?jalur=prestasi') }}"
        class="group relative block rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 cursor-pointer overflow-hidden">
        <div class="h-1.5 w-full bg-violet-600 rounded-t-2xl"></div>
        <div class="bg-white px-6 pt-6 pb-7">
          <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center mb-4 group-hover:bg-violet-100 transition-colors">
            <i data-lucide="trophy" class="w-7 h-7 text-violet-600"></i>
          </div>
          <span class="text-xs font-bold text-violet-400 tracking-widest uppercase mb-1 block">Jalur 04</span>
          <h2 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-violet-600 transition-colors">Jalur Prestasi</h2>
          <div class="space-y-1.5 mb-4">
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                <i data-lucide="book-open" class="w-3 h-3 text-violet-600"></i>
              </span>
              Nilai rapor SD rata-rata <strong>min. 75</strong> (akademik)
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                <i data-lucide="medal" class="w-3 h-3 text-violet-600"></i>
              </span>
              Juara 1–3 kejuaraan, sertifikat <strong>max. 3 tahun</strong> terakhir
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-600">
              <span class="w-5 h-5 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                <i data-lucide="percent" class="w-3 h-3 text-violet-600"></i>
              </span>
              Kuota <strong>30%</strong> (15% akademik + 15% non-akademik)
            </div>
          </div>
          <div class="flex items-center gap-1.5 text-violet-600 text-sm font-semibold">
            Pilih Jalur Ini <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

    </div>

    {{-- INFO BOX --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-5 py-4 flex items-start gap-3 mb-8">
      <i data-lucide="info" class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5"></i>
      <p class="text-sm text-indigo-700 leading-relaxed">
        Pastikan Anda memilih jalur yang sesuai dengan kondisi dan dokumen yang dimiliki.
        Siapkan ijazah SD, SKHUN, dan dokumen pendukung lainnya sebelum mendaftar.
      </p>
    </div>

    {{-- BACK BUTTON --}}
    <div class="flex justify-start">
      <a href="{{ url('/ppdb') }}"
        class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-full shadow-sm transition-all duration-200">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke Halaman PPDB
      </a>
    </div>

  </div>
</section>

@endsection
