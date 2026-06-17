@extends('layouts.ppdb')
@section('title', 'Dashboard Pendaftaran — PPDB EDUGO')
@section('content')

<section class="py-8">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl font-bold text-sm shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl font-bold text-sm shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
          <span class="text-white font-extrabold text-xl">{{ strtoupper(substr($applicant->nama, 0, 2)) }}</span>
        </div>
        <div>
          <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Selamat Datang,</p>
          <h1 class="text-xl font-extrabold text-gray-900">{{ $applicant->nama }}</h1>
          <p class="text-xs text-gray-500">No. Peserta: <span class="font-bold text-blue-600">{{ $applicant->no_daftar }}</span></p>
        </div>
      </div>
      <form action="{{ route('ppdb.logout') }}" method="POST">
        @csrf
        <button type="submit" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-red-500 transition-colors cursor-pointer">
          <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
        </button>
      </form>
    </div>

    {{-- Status Banner --}}
    @php
      $bannerColor = match($applicant->status) {
          'Lulus' => 'from-green-500 to-emerald-500 shadow-green-100',
          'Tidak Lulus' => 'from-red-500 to-rose-500 shadow-red-100',
          'Diverifikasi' => 'from-sky-500 to-blue-500 shadow-blue-100',
          default => 'from-amber-500 to-orange-500 shadow-amber-100'
      };
      $bannerIcon = match($applicant->status) {
          'Lulus' => 'check-circle',
          'Tidak Lulus' => 'x-circle',
          'Diverifikasi' => 'check',
          default => 'clock'
      };
    @endphp
    <div class="bg-gradient-to-r {{ $bannerColor }} rounded-2xl p-5 shadow-lg relative overflow-hidden">
      <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"></div>
      <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
          <i data-lucide="{{ $bannerIcon }}" class="w-6 h-6 text-white"></i>
        </div>
        <div>
          <p class="text-white/80 text-xs font-semibold uppercase tracking-wider">Status Seleksi Akhir</p>
          <p class="text-white text-lg font-extrabold">{{ $applicant->status }}</p>
          <p class="text-white/70 text-xs mt-0.5">{{ $applicant->catatan ?? 'Pantau terus halaman ini untuk progres verifikasi berkas dan seleksi.' }}</p>
        </div>
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
      <a href="{{ route('ppdb.cek-status') }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-100 transition-colors">
          <i data-lucide="search" class="w-5 h-5 text-blue-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Cek Status</p>
      </a>
      <a href="{{ route('ppdb.cetak-bukti') }}" target="_blank" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-emerald-100 transition-colors">
          <i data-lucide="printer" class="w-5 h-5 text-emerald-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Cetak Bukti</p>
      </a>
      <a href="mailto:support@edugo.com" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-violet-100 transition-colors">
          <i data-lucide="mail" class="w-5 h-5 text-violet-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Email Panitia</p>
      </a>
      <a href="tel:081234567890" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-amber-100 transition-colors">
          <i data-lucide="headphones" class="w-5 h-5 text-amber-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Helpdesk</p>
      </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      {{-- Left: Data Ringkasan & Uploads --}}
      <div class="md:col-span-2 space-y-6">

        {{-- PEMBAYARAN KOTAK (IF LULUS) --}}
        @if($applicant->status === 'Lulus')
        <div class="bg-white border border-green-200 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 bg-green-50 border-b border-green-100 flex items-center gap-2">
            <i data-lucide="wallet" class="w-4 h-4 text-green-600"></i>
            <span class="text-sm font-bold text-green-800">Pembayaran Biaya PPDB & Daftar Ulang</span>
          </div>
          <div class="p-5 space-y-4">
            @if($applicant->status_pembayaran === 'Belum Bayar' || $applicant->status_pembayaran === 'Ditolak')
              <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-xs text-blue-800">
                <p class="font-bold">Panduan Pembayaran Transfer Bank:</p>
                <p class="mt-1">Kirim biaya pendaftaran sebesar <strong>Rp 250.000</strong> ke rekening berikut:</p>
                <p class="mt-2 font-mono text-sm bg-white p-2 rounded border">
                  BANK MANDIRI: <strong>123-456789-0</strong><br>
                  Atas Nama: <strong>YAYASAN EDUGO INDONESIA</strong>
                </p>
              </div>

              @if($applicant->status_pembayaran === 'Ditolak')
              <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl text-xs font-semibold">
                Pembayaran Anda sebelumnya ditolak. Catatan admin: {{ $payment->keterangan ?? '-' }}
              </div>
              @endif

              <form action="{{ route('ppdb.upload-payment') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                  <label class="block text-xs font-bold text-gray-700 mb-1">Upload Bukti Transfer (JPG, PNG, atau PDF max 2MB)</label>
                  <input type="file" name="file" accept="image/*,application/pdf" class="w-full px-4 py-2 border rounded-xl text-xs" required>
                </div>
                <div>
                  <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                  <input type="text" name="catatan" placeholder="Contoh: Transfer via ATM Mandiri a.n Pengirim" class="w-full px-4 py-2 border rounded-xl text-xs">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-xl shadow transition cursor-pointer">
                  Kirim Bukti Pembayaran
                </button>
              </form>
            @elseif($applicant->status_pembayaran === 'Sudah Bayar')
              <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl text-xs font-semibold flex items-center gap-2">
                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                Bukti pembayaran telah diunggah. Menunggu verifikasi oleh bendahara/admin.
              </div>
            @elseif($applicant->status_pembayaran === 'Lunas')
              <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-xs font-semibold flex items-center gap-2">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                Pembayaran Anda LUNAS. Silakan cetak bukti pendaftaran untuk diserahkan ke panitia saat daftar ulang offline.
              </div>
              <a href="{{ route('ppdb.cetak-bukti') }}" target="_blank" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs shadow-md transition">
                <i data-lucide="printer" class="w-4 h-4"></i> Cetak Bukti Pendaftaran & Lunas
              </a>
            @endif
          </div>
        </div>
        @endif

        {{-- Dokumen Upload --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="paperclip" class="w-4 h-4 text-violet-500"></i>
            <span class="text-sm font-bold text-gray-800">Unggah Dokumen Persyaratan</span>
          </div>
          <div class="px-5 py-4 space-y-4">
            @php
              $docs = [
                'kk' => 'Kartu Keluarga (KK)',
                'akta' => 'Akta Kelahiran',
                'raport' => 'Rapor Nilai SD',
                'foto' => 'Pas Foto 3x4 Latar Merah',
                'ijazah' => 'Ijazah / SKL SD'
              ];
            @endphp
            @foreach($docs as $key => $label)
              <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/50 space-y-3">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    @php
                      $status = $applicant->{'status_' . $key};
                      $docFile = $applicant->{'berkas_' . $key};
                      $icon = match($status) {
                          'Valid' => 'check-circle-2',
                          'Perbaikan' => 'alert-triangle',
                          'Tidak Valid' => 'x-circle',
                          'Sudah Upload' => 'clock',
                          default => 'file-text'
                      };
                      $color = match($status) {
                          'Valid' => 'text-green-600',
                          'Perbaikan' => 'text-amber-500',
                          'Tidak Valid' => 'text-red-500',
                          'Sudah Upload' => 'text-blue-500',
                          default => 'text-gray-400'
                      };
                    @endphp
                    <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $color }}"></i>
                    <span class="text-xs font-bold text-gray-800">{{ $label }}</span>
                  </div>
                  <span class="text-[10px] font-bold uppercase tracking-wider {{ $color }}">
                    {{ $status }}
                  </span>
                </div>

                @if($applicant->{'catatan_' . $key})
                <p class="text-[11px] text-amber-700 bg-amber-50 border border-amber-100 rounded-lg p-2">
                  Catatan: {{ $applicant->{'catatan_' . $key} }}
                </p>
                @endif

                <div class="flex items-center justify-between gap-4 flex-wrap">
                  <div>
                    @if($docFile)
                      <a href="{{ asset('storage/' . $docFile) }}" target="_blank" class="text-xs text-blue-600 font-bold hover:underline inline-flex items-center gap-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat Dokumen Anda
                      </a>
                    @else
                      <span class="text-[10px] text-gray-400 italic">Belum ada berkas</span>
                    @endif
                  </div>

                  @if($status === 'Belum Upload' || $status === 'Perbaikan' || $status === 'Tidak Valid')
                    <form action="{{ route('ppdb.upload-document') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                      @csrf
                      <input type="hidden" name="document_type" value="{{ $key }}">
                      <input type="file" name="file" accept="image/*,application/pdf" class="text-xs px-2 py-1 border rounded-lg max-w-[180px]" required>
                      <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-[10px] rounded-lg transition cursor-pointer">
                        Upload
                      </button>
                    </form>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Data Diri --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
            <span class="text-sm font-bold text-gray-800">Data Diri</span>
          </div>
          <div class="px-5 py-4 space-y-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Nama Lengkap</span>
              <span class="text-xs font-semibold text-gray-800">{{ $applicant->nama }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">NISN</span>
              <span class="text-xs font-semibold text-gray-800">{{ $applicant->nisn ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Tanggal Lahir</span>
              <span class="text-xs font-semibold text-gray-800">{{ $applicant->tanggal_lahir ? \Carbon\Carbon::parse($applicant->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Telepon</span>
              <span class="text-xs font-semibold text-gray-800">{{ $applicant->telepon ?? '-' }}</span>
            </div>
          </div>
        </div>

      </div>

      {{-- Right: Timeline & Notifications --}}
      <div class="space-y-6">

        {{-- Progres Timeline --}}
        @php
          $allRequired = ['kk', 'akta', 'raport', 'foto', 'ijazah'];
          $uploadedCount = 0;
          foreach ($allRequired as $req) {
              if (!empty($applicant->{'berkas_' . $req})) $uploadedCount++;
          }
        @endphp
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="git-branch" class="w-4 h-4 text-amber-500"></i>
            <span class="text-sm font-bold text-gray-800">Progres Tahapan</span>
          </div>
          <div class="px-5 py-4 space-y-5">
            {{-- Step 1 --}}
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-800">Formulir Dikirim</p>
                <p class="text-[10px] text-gray-400">{{ $applicant->created_at ? $applicant->created_at->translatedFormat('d M, H:i') : '-' }}</p>
              </div>
            </div>

            {{-- Step 2 --}}
            @php
              $isUploadDone = $uploadedCount === 5;
              $step2Bg = $isUploadDone ? 'bg-green-500' : ($uploadedCount > 0 ? 'bg-amber-400 animate-pulse' : 'bg-gray-200');
              $step2Icon = $isUploadDone ? 'check' : ($uploadedCount > 0 ? 'loader-2' : 'circle');
            @endphp
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full {{ $step2Bg }} flex items-center justify-center shrink-0">
                <i data-lucide="{{ $step2Icon }}" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-800">Dokumen Di-upload</p>
                <p class="text-[10px] text-gray-400">Terunggah: {{ $uploadedCount }}/5 berkas</p>
              </div>
            </div>

            {{-- Step 3 --}}
            @php
              $isVerified = $applicant->berkas_status === 'Terverifikasi';
              $isPerbaikan = $applicant->berkas_status === 'Perlu Perbaikan';
              $step3Bg = $isVerified ? 'bg-green-500' : ($isPerbaikan ? 'bg-red-500' : ($applicant->berkas_status === 'Sudah Upload' ? 'bg-amber-400 animate-pulse' : 'bg-gray-200'));
              $step3Icon = $isVerified ? 'check' : ($isPerbaikan ? 'alert-triangle' : ($applicant->berkas_status === 'Sudah Upload' ? 'loader-2' : 'circle'));
            @endphp
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full {{ $step3Bg }} flex items-center justify-center shrink-0">
                <i data-lucide="{{ $step3Icon }}" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-800">Verifikasi Data</p>
                <p class="text-[10px] text-gray-400">Status: {{ $applicant->berkas_status }}</p>
              </div>
            </div>

            {{-- Step 4 --}}
            @php
              $isLulus = $applicant->status === 'Lulus';
              $isGagal = $applicant->status === 'Tidak Lulus';
              $step4Bg = $isLulus ? 'bg-green-500' : ($isGagal ? 'bg-red-500' : 'bg-gray-200');
              $step4Icon = $isLulus ? 'check' : ($isGagal ? 'x' : 'circle');
            @endphp
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full {{ $step4Bg }} flex items-center justify-center shrink-0">
                <i data-lucide="{{ $step4Icon }}" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-medium text-gray-800">Pengumuman Hasil</p>
                <p class="text-[10px] text-gray-400">Hasil: {{ $applicant->status }}</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Notifikasi / Alur Info --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="bell" class="w-4 h-4 text-red-500"></i>
            <span class="text-sm font-bold text-gray-800">Notifikasi Informasi</span>
          </div>
          <div class="px-5 py-4 space-y-3">
            @php $notifCount = 0; @endphp

            @foreach($docs as $k => $l)
              @if($applicant->{'status_' . $k} === 'Perbaikan')
                @php $notifCount++; @endphp
                <div class="flex items-start gap-2.5 p-3 bg-red-50 border border-red-100 rounded-xl">
                  <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 shrink-0 mt-0.5"></i>
                  <div>
                    <p class="text-xs font-bold text-red-800">{{ $l }} Perlu Perbaikan</p>
                    <p class="text-[10px] text-red-600/70">Alasan: {{ $applicant->{'catatan_' . $k} }}</p>
                  </div>
                </div>
              @endif
            @endforeach

            @if($applicant->status === 'Lulus' && $applicant->status_pembayaran === 'Belum Bayar')
              @php $notifCount++; @endphp
              <div class="flex items-start gap-2.5 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0 mt-0.5"></i>
                <div>
                  <p class="text-xs font-bold text-blue-800">Menunggu Pembayaran Formulir</p>
                  <p class="text-[10px] text-blue-600/70">Segera unggah bukti transfer Rp 250.000 untuk mendapatkan kartu bukti pendaftaran.</p>
                </div>
              </div>
            @endif

            @if($notifCount === 0)
              <p class="text-xs text-gray-400 italic text-center py-4">Belum ada notifikasi baru.</p>
            @endif
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

{{-- Realtime Polling Script --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Poll status every 5 seconds
      setInterval(function() {
          fetch('{{ route("ppdb.api.status") }}')
              .then(response => response.json())
              .then(data => {
                  const currentStatus = "{{ $applicant->status }}";
                  const currentBerkasStatus = "{{ $applicant->berkas_status }}";
                  const currentPaymentStatus = "{{ $applicant->status_pembayaran }}";
                  
                  const currentKK = "{{ $applicant->status_kk }}";
                  const currentAkta = "{{ $applicant->status_akta }}";
                  const currentRaport = "{{ $applicant->status_raport }}";
                  const currentFoto = "{{ $applicant->status_foto }}";
                  const currentIjazah = "{{ $applicant->status_ijazah }}";

                  if (
                      data.status !== currentStatus ||
                      data.berkas_status !== currentBerkasStatus ||
                      data.status_pembayaran !== currentPaymentStatus ||
                      data.status_kk !== currentKK ||
                      data.status_akta !== currentAkta ||
                      data.status_raport !== currentRaport ||
                      data.status_foto !== currentFoto ||
                      data.status_ijazah !== currentIjazah
                  ) {
                      window.location.reload();
                  }
              })
              .catch(err => console.error("Error polling PPDB status:", err));
      }, 5000);
  });
</script>

@endsection
