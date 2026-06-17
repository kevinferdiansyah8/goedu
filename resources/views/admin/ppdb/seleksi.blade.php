@extends('layouts.admin')

@section('title', 'PPDB - Seleksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">PPDB – Seleksi</h1>
            <p class="text-gray-500 mt-1">Kelola keputusan kelulusan dan penilaian seleksi calon siswa</p>
        </div>
        @if($selectedApplicant)
        <a href="{{ route('admin.ppdb.seleksi') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
        </a>
        @endif
    </div>

    @if(!$selectedApplicant)
        {{-- ================= LIST VIEW ================= --}}
        
        {{-- FILTER FORM --}}
        <form class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-4 flex flex-wrap gap-4 items-center" method="GET">
            <select name="jurusan" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-sm font-semibold" onchange="this.form.submit()">
                <option value="">Semua Jurusan</option>
                @foreach($jurusanList as $j)
                    <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-bold text-sm transition">Filter</button>
        </form>

        {{-- TABLE LIST --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-base">
                <thead class="bg-slate-50 text-gray-600 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No Daftar</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Pendaftar</th>
                        <th class="px-6 py-4 text-left font-semibold">Status Berkas</th>
                        <th class="px-6 py-4 text-center font-semibold">Nilai Seleksi</th>
                        <th class="px-6 py-4 text-center font-semibold">Keputusan Akhir</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $p)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $p->no_daftar }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <div>{{ $p->nama }}</div>
                            <div class="text-xs text-gray-400 font-normal">{{ $p->jurusan }} — {{ $p->jalur }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $bStatus = match($p->berkas_status) {
                                    'Terverifikasi' => 'bg-green-50 text-green-700 border-green-200',
                                    'Belum Upload' => 'bg-gray-100 text-gray-500 border-gray-200',
                                    default => 'bg-amber-50 text-amber-600 border-amber-200'
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $bStatus }}">
                                {{ $p->berkas_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-gray-900">
                            {{ $p->nilai_seleksi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badge = match($p->status) {
                                    'Lulus' => 'bg-green-100 text-green-700 border-green-300',
                                    'Tidak Lulus' => 'bg-red-100 text-red-700 border-red-300',
                                    'Diverifikasi' => 'bg-sky-100 text-sky-700 border-sky-300',
                                    'Menunggu' => 'bg-gray-100 text-gray-600 border-gray-300',
                                    default => 'bg-yellow-100 text-yellow-700 border-yellow-300'
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->berkas_status !== 'Terverifikasi')
                            <span class="text-xs text-gray-400 italic" title="Berkas harus diverifikasi terlebih dahulu">Berkas Belum Valid</span>
                            @else
                            <a href="{{ route('admin.ppdb.seleksi', ['id' => $p->id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-bold transition shadow-sm">
                                <i data-lucide="edit-3" class="w-4 h-4"></i> Proses Seleksi
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada pendaftar PPDB.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pendaftar->links() }}</div>

    @else
        {{-- ================= DETAIL SELECTION VIEW ================= --}}

        <!-- INFO PENDAFTAR -->
        <div class="flex-1 flex items-center bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl p-6 shadow-sm relative">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-extrabold flex items-center justify-center text-2xl shadow-md border-4 border-white mr-6">
                {{ collect(explode(' ', $selectedApplicant->nama))->map(fn($n)=>$n[0] ?? '')->take(2)->join('') }}
            </div>
            <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">No Pendaftaran</span>
                    <span class="text-lg font-black text-gray-900">{{ $selectedApplicant->no_daftar }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Nama Lengkap</span>
                    <span class="text-lg font-black text-gray-900">{{ $selectedApplicant->nama }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Jurusan</span>
                    <span class="text-lg font-black text-gray-900">{{ $selectedApplicant->jurusan }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Jalur</span>
                    <span class="text-lg font-black text-gray-900">{{ $selectedApplicant->jalur }}</span>
                </div>
            </div>
        </div>

        {{-- FORM PENILAIAN SELEKSI --}}
        <form action="{{ route('admin.ppdb.update-seleksi', $selectedApplicant->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- SECTION SELEKSI -->
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="award" class="w-5 h-5 text-blue-600"></i> Penilaian & Keputusan Seleksi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nilai Seleksi / Tes Akademik</label>
                        <input type="number" name="nilai_seleksi" value="{{ $selectedApplicant->nilai_seleksi }}" min="0" max="100" placeholder="0 - 100" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                        <p class="text-xs text-gray-400 mt-1.5">Masukkan skor hasil seleksi tertulis, wawancara, atau akumulasi nilai rapor.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Akhir Pendaftaran</label>
                        <select name="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                            <option value="Diverifikasi" {{ $selectedApplicant->status === 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi (Proses Seleksi)</option>
                            <option value="Lulus" {{ $selectedApplicant->status === 'Lulus' ? 'selected' : '' }}>Lulus (Diterima)</option>
                            <option value="Tidak Lulus" {{ $selectedApplicant->status === 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus (Ditolak)</option>
                            <option value="Perbaikan" {{ $selectedApplicant->status === 'Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                            <option value="Menunggu" {{ $selectedApplicant->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1.5">Memilih "Lulus" akan membuka tahapan pembayaran biaya pendaftaran bagi calon siswa.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Kelulusan / Pesan Hasil Seleksi</label>
                        <textarea name="catatan" rows="3" placeholder="Masukkan ucapan selamat atau catatan detail alasan kelulusan/ketidaklulusan..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">{{ $selectedApplicant->catatan }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t pt-6">
                    <a href="{{ route('admin.ppdb.seleksi') }}" class="px-6 py-3 border border-gray-200 rounded-xl font-bold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-md transition">
                        Simpan Keputusan Seleksi
                    </button>
                </div>
            </div>
        </form>
    @endif

</div>
@endsection
