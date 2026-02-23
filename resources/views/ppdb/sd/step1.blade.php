@extends('layouts.ppdb')
@section('title', 'Pendaftaran SD - Step 1 | Data Diri')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-xl">

    {{-- PROGRESS STEPPER --}}
    <div class="flex items-center justify-center mb-8">
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-blue-200 ring-4 ring-blue-100">1</div>
        <span class="text-xs font-semibold text-blue-600 mt-1.5">Data Diri</span>
      </div>
      <div class="w-16 h-0.5 bg-gray-200 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold text-sm border-2 border-gray-200">2</div>
        <span class="text-xs font-medium text-gray-400 mt-1.5">Data Keluarga</span>
      </div>
      <div class="w-16 h-0.5 bg-gray-200 mb-5"></div>
      <div class="flex flex-col items-center">
        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold text-sm border-2 border-gray-200">3</div>
        <span class="text-xs font-medium text-gray-400 mt-1.5">Dokumen</span>
      </div>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/80 border border-gray-100 overflow-hidden">

      {{-- Header --}}
      <div class="bg-gradient-to-r from-red-500 to-red-400 px-8 py-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
            <i data-lucide="user-circle-2" class="w-5 h-5 text-white"></i>
          </div>
          <div>
            <p class="text-red-100 text-xs font-medium uppercase tracking-widest">Pendaftaran SD • Langkah 1 dari 3</p>
            <h1 class="text-white font-extrabold text-lg">Data Diri Calon Siswa</h1>
          </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4">
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
            <i data-lucide="school" class="w-3 h-3"></i> Jenjang: SD
          </span>
          @if(request('jalur'))
          <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
            <i data-lucide="route" class="w-3 h-3"></i> Jalur: {{ ucfirst(request('jalur')) }}
          </span>
          @endif
        </div>
      </div>

      {{-- Body --}}
      <div class="px-8 py-8">
        <form action="{{ url('/ppdb/register/sd/step2') }}" method="get" class="space-y-5">
          <input type="hidden" name="jalur" value="{{ request('jalur') }}">

          {{-- INFO BOX ZONASI --}}
          @if(request('jalur') === 'zonasi')
          <div class="bg-blue-50 border border-blue-200 rounded-2xl overflow-hidden">
            <div class="bg-blue-600 px-4 py-2.5 flex items-center gap-2">
              <i data-lucide="map-pin" class="w-4 h-4 text-white shrink-0"></i>
              <span class="text-white text-xs font-bold uppercase tracking-wider">Syarat & Kriteria — Jalur Zonasi SD</span>
            </div>
            <div class="px-4 py-3.5 space-y-2.5">
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="home" class="w-3.5 h-3.5 text-blue-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Berdasarkan Alamat Rumah</p>
                  <p class="text-xs text-gray-500 mt-0.5">Alamat tempat tinggal calon siswa (sesuai KK) harus berada dalam zona wilayah sekolah yang dituju.</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="ruler" class="w-3.5 h-3.5 text-blue-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Prioritas Jarak ke Sekolah</p>
                  <p class="text-xs text-gray-500 mt-0.5">Jika kuota terbatas, diutamakan calon siswa dengan jarak rumah ke sekolah yang paling dekat. Jika jarak sama, diutamakan usia yang lebih tua.</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="file-text" class="w-3.5 h-3.5 text-blue-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Kartu Keluarga (KK) Minimal 1 Tahun</p>
                  <p class="text-xs text-gray-500 mt-0.5">KK harus diterbitkan <strong class="text-blue-700">minimal 1 tahun</strong> sebelum tanggal awal pendaftaran (sesuai Permendikbud No. 1/2021). Contoh: jika pendaftaran mulai 1 Juli 2025, KK harus terbit sebelum 1 Juli 2024.</p>
                </div>
              </div>
            </div>
          </div>
          @endif

          {{-- INFO BOX AFIRMASI --}}
          @if(request('jalur') === 'afirmasi')
          <div class="bg-green-50 border border-green-200 rounded-2xl overflow-hidden">
            <div class="bg-green-600 px-4 py-2.5 flex items-center gap-2">
              <i data-lucide="heart-handshake" class="w-4 h-4 text-white shrink-0"></i>
              <span class="text-white text-xs font-bold uppercase tracking-wider">Syarat & Kriteria — Jalur Afirmasi SD</span>
            </div>
            <div class="px-4 py-3.5 space-y-2.5">
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="badge-check" class="w-3.5 h-3.5 text-green-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Keluarga Kurang Mampu / Ekonomi Rendah</p>
                  <p class="text-xs text-gray-500 mt-0.5">Dibuktikan dengan <strong class="text-green-700">KIP (Kartu Indonesia Pintar)</strong>, SKTM (Surat Keterangan Tidak Mampu) dari desa/kelurahan, atau terdaftar dalam Program Keluarga Harapan (PKH).</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="accessibility" class="w-3.5 h-3.5 text-green-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Penyandang Disabilitas</p>
                  <p class="text-xs text-gray-500 mt-0.5">Anak berkebutuhan khusus yang mendaftar ke sekolah reguler. Dibuktikan dengan surat keterangan dari dokter atau psikolog.</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="percent" class="w-3.5 h-3.5 text-green-600"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Kuota Minimal 15%</p>
                  <p class="text-xs text-gray-500 mt-0.5">Jalur ini mendapat kuota <strong class="text-green-700">minimal 15%</strong> dari total daya tampung sekolah. Domisili tidak harus dalam zona sekolah.</p>
                </div>
              </div>
            </div>
          </div>
          @endif

          {{-- FIELD BUKTI AFIRMASI (hanya saat jalur=afirmasi) --}}
          @if(request('jalur') === 'afirmasi')
          <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
              Jenis Bukti Afirmasi yang Dimiliki <span class="text-red-400">*</span>
            </label>
            <div class="space-y-2.5">

              {{-- KIP --}}
              <label class="flex items-start gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:ring-2 has-[:checked]:ring-green-100">
                <input type="radio" name="jenis_afirmasi" value="KIP" class="accent-green-600 mt-0.5 shrink-0" required>
                <div class="flex items-start gap-2.5">
                  <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">
                    <i data-lucide="credit-card" class="w-4 h-4 text-yellow-600"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-800">KIP — Kartu Indonesia Pintar</p>
                    <p class="text-xs text-gray-400 mt-0.5">Kartu fisik KIP atas nama calon siswa dari Kemdikbud.</p>
                  </div>
                </div>
              </label>

              {{-- SKTM --}}
              <label class="flex items-start gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:ring-2 has-[:checked]:ring-green-100">
                <input type="radio" name="jenis_afirmasi" value="SKTM" class="accent-green-600 mt-0.5 shrink-0">
                <div class="flex items-start gap-2.5">
                  <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                    <i data-lucide="file-badge" class="w-4 h-4 text-blue-600"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-800">SKTM — Surat Keterangan Tidak Mampu</p>
                    <p class="text-xs text-gray-400 mt-0.5">Surat resmi dari RT/RW yang diketahui Kepala Desa/Kelurahan, diterbitkan tahun berjalan.</p>
                  </div>
                </div>
              </label>

              {{-- PKH --}}
              <label class="flex items-start gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:ring-2 has-[:checked]:ring-green-100">
                <input type="radio" name="jenis_afirmasi" value="PKH" class="accent-green-600 mt-0.5 shrink-0">
                <div class="flex items-start gap-2.5">
                  <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                    <i data-lucide="shield-check" class="w-4 h-4 text-purple-600"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-800">PKH — Program Keluarga Harapan</p>
                    <p class="text-xs text-gray-400 mt-0.5">Surat keterangan terdaftar sebagai penerima PKH dari Dinas Sosial setempat.</p>
                  </div>
                </div>
              </label>

              {{-- Disabilitas --}}
              <label class="flex items-start gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:ring-2 has-[:checked]:ring-green-100">
                <input type="radio" name="jenis_afirmasi" value="Disabilitas" class="accent-green-600 mt-0.5 shrink-0">
                <div class="flex items-start gap-2.5">
                  <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center shrink-0">
                    <i data-lucide="accessibility" class="w-4 h-4 text-rose-600"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-800">Penyandang Disabilitas</p>
                    <p class="text-xs text-gray-400 mt-0.5">Surat keterangan dari dokter spesialis atau psikolog klinis bersertifikat.</p>
                  </div>
                </div>
              </label>

            </div>
          </div>
          @endif

          {{-- INFO BOX & FIELDS PERPINDAHAN --}}
          @if(request('jalur') === 'perpindahan')
          <div class="bg-orange-50 border border-orange-200 rounded-2xl overflow-hidden">
            <div class="bg-orange-500 px-4 py-2.5 flex items-center gap-2">
              <i data-lucide="truck" class="w-4 h-4 text-white shrink-0"></i>
              <span class="text-white text-xs font-bold uppercase tracking-wider">Syarat & Kriteria — Jalur Perpindahan SD</span>
            </div>
            <div class="px-4 py-3.5 space-y-2.5">
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="briefcase" class="w-3.5 h-3.5 text-orange-500"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Orang Tua Pindah Tugas Resmi</p>
                  <p class="text-xs text-gray-500 mt-0.5">Diperuntukkan bagi anak dari PNS/ASN, TNI, POLRI, atau karyawan yang mendapatkan surat tugas resmi pindah ke daerah ini.</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="file-signature" class="w-3.5 h-3.5 text-orange-500"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Surat Tugas / SK Pindah Masih Berlaku</p>
                  <p class="text-xs text-gray-500 mt-0.5">SK/Surat Penugasan harus masih berlaku aktif saat periode pendaftaran. Surat sudah kadaluarsa tidak dapat diterima.</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center shrink-0 mt-0.5">
                  <i data-lucide="percent" class="w-3.5 h-3.5 text-orange-500"></i>
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-800">Kuota Maksimal 5%</p>
                  <p class="text-xs text-gray-500 mt-0.5">Jalur ini mendapat kuota <strong class="text-orange-600">maksimal 5%</strong> dari total daya tampung. Tidak perlu berada dalam zona sekolah.</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Field khusus Perpindahan --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
              Instansi / Lembaga Tempat Orang Tua Bertugas <span class="text-red-400">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="building-2" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="instansi_ortu" placeholder="Contoh: Polres Kota X / Dinas Kesehatan Kab. Y" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 focus:bg-white transition-all">
            </div>
            <p class="text-xs text-gray-400 mt-1.5 ml-1">Nama instansi/kantor/satuan tempat orang tua ditugaskan.</p>
          </div>

          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
              Nomor Surat Tugas / SK Pindah <span class="text-red-400">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="file-signature" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="no_surat_tugas" placeholder="Contoh: 800/123/IV/2025" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 focus:bg-white transition-all">
            </div>
            <p class="text-xs text-gray-400 mt-1.5 ml-1">Nomor surat resmi dari instansi/perusahaan, akan diverifikasi panitia.</p>
          </div>
          @endif

          {{-- Nama Lengkap --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap Calon Siswa <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="nama" placeholder="Sesuai akta kelahiran" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
          </div>

          {{-- NISN --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NISN <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="nisn" placeholder="10 digit NISN" inputmode="numeric" maxlength="10" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
            <p class="text-xs text-gray-400 mt-1.5 ml-1">NISN dapat ditemukan di Dapodik atau rapor TK.</p>
          </div>

          {{-- NIK --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">NIK (Nomor Induk Kependudukan) <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="credit-card" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="nik" placeholder="16 digit NIK sesuai KK" inputmode="numeric" maxlength="16" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
          </div>

          {{-- Tanggal Lahir --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Lahir <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="date" name="tanggal_lahir" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
            <p class="text-xs text-gray-400 mt-1.5 ml-1">Usia minimal masuk SD adalah <strong>7 tahun</strong> per 1 Juli 2025.</p>
          </div>

          {{-- Jenis Kelamin --}}
          <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-red-400">*</span></label>
            <div class="grid grid-cols-2 gap-3">
              <label class="flex items-center gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-100">
                <input type="radio" name="jenis_kelamin" value="laki-laki" class="accent-blue-600" required>
                <div class="flex items-center gap-2">
                  <i data-lucide="mars" class="w-4 h-4 text-blue-500"></i>
                  <span class="text-sm font-medium text-gray-700">Laki-laki</span>
                </div>
              </label>
              <label class="flex items-center gap-3 px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer hover:border-pink-400 hover:bg-pink-50 transition-all has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 has-[:checked]:ring-2 has-[:checked]:ring-pink-100">
                <input type="radio" name="jenis_kelamin" value="perempuan" class="accent-pink-500">
                <div class="flex items-center gap-2">
                  <i data-lucide="venus" class="w-4 h-4 text-pink-500"></i>
                  <span class="text-sm font-medium text-gray-700">Perempuan</span>
                </div>
              </label>
            </div>
          </div>

          {{-- Tempat Lahir --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tempat Lahir <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="tempat_lahir" placeholder="Kota / Kabupaten tempat lahir" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
          </div>

          {{-- Asal TK/PAUD --}}
          <div class="group">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Asal TK / PAUD <span class="text-red-400">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="school-2" class="w-4 h-4 text-gray-400"></i>
              </div>
              <input type="text" name="asal_tk" placeholder="Nama TK / PAUD yang pernah diikuti" required
                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-400 focus:bg-white transition-all">
            </div>
            <p class="text-xs text-gray-400 mt-1.5 ml-1">Isi "Tidak Ada" jika calon siswa belum pernah bersekolah TK/PAUD.</p>
          </div>

          <div class="border-t border-dashed border-gray-200 pt-2"></div>

          <div class="flex gap-3">
            <a href="{{ url('/ppdb/jenjang/sd?jalur='.request('jalur')) }}"
              class="flex-1 flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3.5 rounded-xl text-sm transition-all">
              <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit"
              class="flex-1 flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-red-200 transition-all text-sm">
              Lanjut ke Data Keluarga <i data-lucide="arrow-right" class="w-4 h-4"></i>
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
