@extends('layouts.ppdb')
@section('title', 'Cek Status Pendaftaran — PPDB EDUGO')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-lg">

    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
        <i data-lucide="search" class="w-7 h-7 text-white"></i>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900">Cek Status Pendaftaran</h1>
      <p class="text-gray-500 text-sm mt-1.5 max-w-xs mx-auto">Masukkan NISN atau Nomor Peserta untuk melihat status pendaftaran PPDB Anda.</p>
    </div>

    {{-- Search Card --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/80 border border-gray-100 overflow-hidden" 
         x-data="{ searched: false, query: '', method: 'nisn', applicant: null, formatted_date: '', errorMsg: '', pollingInterval: null,
            doSearch() {
                if(this.query.length === 0) return;
                fetch('{{ route('ppdb.cek-status.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ query_input: this.query })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.searched = true;
                        this.applicant = data.applicant;
                        this.formatted_date = data.formatted_date;
                        this.errorMsg = '';
                        this.startPolling(data.applicant.id);
                    } else {
                        this.searched = false;
                        this.applicant = null;
                        this.errorMsg = data.message;
                    }
                })
                .catch(err => {
                    this.errorMsg = 'Terjadi kesalahan sistem.';
                });
            },
            startPolling(id) {
                if(this.pollingInterval) clearInterval(this.pollingInterval);
                this.pollingInterval = setInterval(() => {
                    fetch('{{ url('/ppdb/api/status') }}?id=' + id)
                    .then(res => res.json())
                    .then(data => {
                        if(this.applicant) {
                            this.applicant.status = data.status;
                            this.applicant.berkas_status = data.berkas_status;
                            this.applicant.status_pembayaran = data.status_pembayaran;
                        }
                    });
                }, 5000);
            }
         }">
      <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <div class="flex items-center gap-2">
          <i data-lucide="scan-search" class="w-5 h-5 text-blue-200"></i>
          <span class="text-white text-sm font-bold uppercase tracking-wider">Pencarian Status</span>
        </div>
      </div>

      <div class="px-6 py-6">
        {{-- Method Toggle --}}
        <div class="flex bg-gray-100 rounded-xl p-1 mb-5">
          <button type="button" @click="method = 'nisn'" :class="method === 'nisn' ? 'bg-white shadow text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'" class="flex-1 text-xs py-2 rounded-lg transition-all duration-200 text-center">
            <i data-lucide="hash" class="w-3.5 h-3.5 inline-block mr-1 mb-0.5"></i> NISN
          </button>
          <button type="button" @click="method = 'nopeserta'" :class="method === 'nopeserta' ? 'bg-white shadow text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'" class="flex-1 text-xs py-2 rounded-lg transition-all duration-200 text-center">
            <i data-lucide="ticket" class="w-3.5 h-3.5 inline-block mr-1 mb-0.5"></i> No. Peserta
          </button>
        </div>

        {{-- Input --}}
        <div class="relative mb-4">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
          </div>
          <input type="text" x-model="query"
            :placeholder="method === 'nisn' ? 'Masukkan 10 digit NISN' : 'Masukkan Nomor Peserta (cth: PPDB0001)'"
            :maxlength="method === 'nisn' ? 10 : 20"
            @keyup.enter="doSearch()"
            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all">
        </div>

        {{-- Error message --}}
        <template x-if="errorMsg">
          <div class="mb-4 text-xs font-bold text-red-600 bg-red-50 p-3 border border-red-100 rounded-xl" x-text="errorMsg"></div>
        </template>

        {{-- Search Button --}}
        <button type="button" @click="doSearch()"
          :disabled="query.length === 0"
          class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition-all text-sm active:scale-[0.98]">
          <i data-lucide="search" class="w-4 h-4"></i>
          Cek Status Sekarang
        </button>

        {{-- Result Area --}}
        <div x-show="searched" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-6 space-y-4">

          <div class="bg-amber-50 border border-amber-200 rounded-2xl overflow-hidden" :class="applicant && applicant.status === 'Lulus' ? 'bg-green-50 border-green-200' : (applicant && applicant.status === 'Tidak Lulus' ? 'bg-red-50 border-red-200' : '')">
            <div class="bg-amber-500 px-4 py-2.5 flex items-center gap-2" :class="applicant && applicant.status === 'Lulus' ? 'bg-green-600' : (applicant && applicant.status === 'Tidak Lulus' ? 'bg-red-600' : '')">
              <i data-lucide="clock" class="w-4 h-4 text-white"></i>
              <span class="text-white text-xs font-bold uppercase tracking-wider" x-text="'Status Pendaftaran: ' + (applicant ? applicant.status : '-')"></span>
            </div>
            <div class="px-5 py-4 space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 font-medium">No. Peserta</span>
                <span class="text-xs font-bold text-gray-800" x-text="applicant ? applicant.no_daftar : ''"></span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 font-medium">Nama</span>
                <span class="text-xs font-bold text-gray-800" x-text="applicant ? applicant.nama : ''"></span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 font-medium">Jurusan / Jalur</span>
                <span class="text-xs font-bold text-gray-800" x-text="applicant ? applicant.jurusan + ' — ' + applicant.jalur : ''"></span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 font-medium">Tanggal Daftar</span>
                <span class="text-xs font-bold text-gray-800" x-text="formatted_date"></span>
              </div>

              {{-- Progress Steps --}}
              <div class="border-t border-dashed border-gray-200 pt-3">
                <p class="text-xs font-semibold text-gray-600 mb-3">Progres Pendaftaran:</p>
                <div class="space-y-2.5">
                  <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center shrink-0 mt-0.5">
                      <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div>
                      <p class="text-xs font-semibold text-gray-800">Formulir Diterima</p>
                    </div>
                  </div>
                  
                  <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5" 
                         :class="applicant && (applicant.berkas_status === 'Sudah Upload' || applicant.berkas_status === 'Terverifikasi' || ['Diverifikasi', 'Lulus', 'Tidak Lulus'].includes(applicant.status)) ? 'bg-green-500' : 'bg-gray-200'">
                      <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div>
                      <p class="text-xs font-semibold text-gray-800">Berkas Di-upload</p>
                    </div>
                  </div>

                  <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5" 
                         :class="applicant && (applicant.berkas_status === 'Terverifikasi' || ['Diverifikasi', 'Lulus', 'Tidak Lulus'].includes(applicant.status)) ? 'bg-green-500' : (applicant && applicant.berkas_status === 'Sudah Upload' ? 'bg-amber-400 animate-pulse' : 'bg-gray-200')">
                      <i data-lucide="circle" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div>
                      <p class="text-xs font-semibold text-gray-800" x-text="'Verifikasi Berkas: ' + (applicant ? (['Diverifikasi', 'Lulus', 'Tidak Lulus'].includes(applicant.status) || applicant.berkas_status === 'Terverifikasi' ? 'Terverifikasi' : applicant.berkas_status) : '-')"></p>
                    </div>
                  </div>

                  <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5" 
                         :class="applicant && applicant.status === 'Lulus' ? 'bg-green-500' : (applicant && applicant.status === 'Tidak Lulus' ? 'bg-red-500' : 'bg-gray-200')">
                      <i data-lucide="circle" class="w-3.5 h-3.5 text-white"></i>
                    </div>
                    <div>
                      <p class="text-xs font-medium text-gray-800" x-text="'Pengumuman Kelulusan: ' + (applicant ? applicant.status : '-')"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Helpdesk --}}
          <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 flex items-start gap-2.5">
            <i data-lucide="headphones" class="w-4 h-4 text-blue-500 shrink-0 mt-0.5"></i>
            <div>
              <p class="text-xs font-semibold text-blue-800">Ada pertanyaan?</p>
              <p class="text-xs text-blue-600 mt-0.5">Hubungi Helpdesk PPDB: <strong>0812-3456-7890</strong> (Senin–Jumat, 08.00–15.00 WIB)</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- Back --}}
    <div class="text-center mt-5">
      <a href="{{ url('/ppdb') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Halaman PPDB
      </a>
    </div>

  </div>
</section>

@endsection
