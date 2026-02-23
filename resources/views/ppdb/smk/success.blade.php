@extends('layouts.ppdb')
@section('title', 'Pendaftaran SMK - Berhasil!')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-lg text-center">

    <div class="flex justify-center mb-6">
      <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center shadow-xl shadow-green-100 ring-8 ring-green-50">
        <i data-lucide="check-circle-2" class="w-12 h-12 text-green-500"></i>
      </div>
    </div>

    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">Pendaftaran Berhasil Dikirim!</h1>
    <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto leading-relaxed">
      Formulir pendaftaran PPDB <strong class="text-gray-700">Sekolah Menengah Kejuruan (SMK)</strong> Anda telah berhasil dikirim.
    </p>

    <div class="bg-white border-2 border-dashed border-green-300 rounded-2xl px-6 py-5 mb-6 shadow-sm">
      <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Nomor Pendaftaran</p>
      <p class="text-3xl font-extrabold text-green-600 tracking-widest">
        SMK-{{ strtoupper(request('jalur', 'ZNS')) }}-{{ date('Ymd') }}-{{ rand(1000,9999) }}
      </p>
      <p class="text-xs text-gray-400 mt-2">Screenshot atau catat nomor ini sebagai bukti pendaftaran.</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-5 mb-6 text-left space-y-3">
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center gap-2"><i data-lucide="school" class="w-4 h-4"></i> Jenjang</span>
        <span class="font-semibold text-gray-800">Sekolah Menengah Kejuruan (SMK)</span>
      </div>
      <div class="border-t border-gray-100"></div>
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center gap-2"><i data-lucide="route" class="w-4 h-4"></i> Jalur</span>
        <span class="font-semibold text-gray-800">{{ ucfirst(request('jalur', '-')) }}</span>
      </div>
      <div class="border-t border-gray-100"></div>
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4"></i> Tanggal Kirim</span>
        <span class="font-semibold text-gray-800">{{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
      </div>
      <div class="border-t border-gray-100"></div>
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4"></i> Status</span>
        <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">
          <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Menunggu Verifikasi
        </span>
      </div>
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-2xl px-5 py-4 mb-8 text-left flex gap-3">
      <i data-lucide="info" class="w-5 h-5 text-blue-400 shrink-0 mt-0.5"></i>
      <div class="text-xs text-blue-700 leading-relaxed space-y-1">
        <p><strong>Langkah Selanjutnya:</strong></p>
        <p>1. Bawa dokumen fisik ke sekolah tujuan sesuai jadwal.</p>
        <p>2. Pantau status dan pengumuman program keahlian melalui halaman PPDB.</p>
        <p>3. Hubungi panitia jika ada pertanyaan lebih lanjut.</p>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="{{ url('/ppdb/dashboard') }}"
        class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3 rounded-xl text-sm shadow-lg shadow-amber-200 transition-all">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Lihat Dashboard
      </a>
      <a href="{{ url('/ppdb/cek-status') }}"
        class="inline-flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold px-6 py-3 rounded-xl text-sm transition-all">
        <i data-lucide="search" class="w-4 h-4"></i> Cek Status Pendaftaran
      </a>
    </div>
  </div>
</section>
@endsection
