@extends('layouts.ppdb')
@section('title', 'Pendaftaran SMA - Step 2 | Data Keluarga')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-xl">

    {{-- PROGRESS STEPPER --}}
    <div class="flex items-center justify-center mb-8">
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-green-200 ring-4 ring-green-100">
          <i data-lucide="check" class="w-4 h-4"></i>
        </div>
        <span class="text-xs font-semibold text-green-500 mt-1.5">Data Diri</span>
      </div>
      <div class="w-16 h-0.5 bg-green-300 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-emerald-200 ring-4 ring-emerald-100">2</div>
        <span class="text-xs font-semibold text-emerald-600 mt-1.5">Data Keluarga</span>
      </div>
      <div class="w-16 h-0.5 bg-gray-200 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold text-sm border-2 border-gray-200">3</div>
        <span class="text-xs font-medium text-gray-400 mt-1.5">Dokumen</span>
      </div>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/80 border border-gray-100 overflow-hidden">
      <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-8 py-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
            <i data-lucide="users" class="w-5 h-5 text-white"></i>
          </div>
          <div>
            <p class="text-emerald-100 text-xs font-medium uppercase tracking-widest">Pendaftaran SMA • Langkah 2 dari 3</p>
            <h1 class="text-white font-extrabold text-lg">Data Keluarga Calon Siswa</h1>
          </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4">
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
            <i data-lucide="school" class="w-3 h-3"></i> Jenjang: SMA
          </span>
          @if(request('jalur'))
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
            <i data-lucide="route" class="w-3 h-3"></i> Jalur: {{ ucfirst(request('jalur')) }}
          </span>
          @endif
        </div>
      </div>

      <div class="px-8 py-8">
        <form action="{{ url('/ppdb/register/sma/step3') }}" method="get" class="space-y-5">
          <input type="hidden" name="jalur" value="{{ request('jalur') }}">

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Ayah Kandung <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="user" class="w-4 h-4 text-gray-400"></i></div>
              <input type="text" name="nama_ayah" placeholder="Nama lengkap ayah kandung" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Ibu Kandung <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="user" class="w-4 h-4 text-gray-400"></i></div>
              <input type="text" name="nama_ibu" placeholder="Nama lengkap ibu kandung" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NIK Orang Tua / Wali <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="credit-card" class="w-4 h-4 text-gray-400"></i></div>
              <input type="text" name="nik_ortu" placeholder="16 digit NIK sesuai KTP" inputmode="numeric" maxlength="16" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nomor HP Aktif Orang Tua <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="phone" class="w-4 h-4 text-gray-400"></i></div>
              <input type="tel" name="no_hp" placeholder="Contoh: 08123456789" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Orang Tua / Wali <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="mail" class="w-4 h-4 text-gray-400"></i></div>
              <input type="email" name="email" placeholder="contoh@email.com" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all">
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Pekerjaan Orang Tua <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i data-lucide="briefcase" class="w-4 h-4 text-gray-400"></i></div>
              <select name="pekerjaan" required class="w-full pl-11 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all appearance-none cursor-pointer">
                <option value="" disabled selected>Pilih pekerjaan</option>
                <option>PNS / ASN</option><option>TNI / POLRI</option><option>Karyawan Swasta</option>
                <option>Wiraswasta / Pengusaha</option><option>Petani / Buruh Tani</option>
                <option>Guru / Tenaga Pendidik</option><option>Tidak Bekerja</option><option>Lainnya</option>
              </select>
              <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none"><i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i></div>
            </div>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Tempat Tinggal <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute top-3.5 left-0 pl-4 flex items-start pointer-events-none"><i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i></div>
              <textarea name="alamat" rows="3" placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan, Kota" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 focus:bg-white transition-all"></textarea>
            </div>
          </div>

          <div class="border-t border-dashed border-gray-200 pt-2"></div>

          <div class="flex gap-3">
            <a href="{{ url('/ppdb/register/sma/step1?jalur='.request('jalur')) }}"
              class="flex-1 flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3.5 rounded-xl text-sm transition-all">
              <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit"
              class="flex-1 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-200 transition-all text-sm">
              Lanjut ke Dokumen <i data-lucide="arrow-right" class="w-4 h-4"></i>
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
