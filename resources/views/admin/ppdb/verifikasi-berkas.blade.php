@extends('layouts.admin')

@section('title', 'Verifikasi Berkas PPDB')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Verifikasi Berkas PPDB</h1>
            <p class="text-gray-500 mt-1">Periksa dan verifikasi kelengkapan berkas pendaftar baru</p>
        </div>
        @if($selectedApplicant)
        <a href="{{ route('admin.ppdb.verifikasi-berkas') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
        </a>
        @endif
    </div>

    @if(!$selectedApplicant)
        {{-- ================= LIST VIEW ================= --}}
        
        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-amber-50"><i data-lucide="clock" class="w-7 h-7 text-amber-500"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Belum Upload</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['belum'] }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-50"><i data-lucide="file-text" class="w-7 h-7 text-blue-600"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sudah Upload</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['sudah'] }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-green-50"><i data-lucide="check-circle" class="w-7 h-7 text-green-600"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Terverifikasi</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['terverifikasi'] }}</div>
                </div>
            </div>
        </div>

        {{-- FILTER FORM --}}
        <form class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-4 flex flex-wrap gap-4 items-center" method="GET">
            <select name="status_berkas" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-sm font-semibold" onchange="this.form.submit()">
                <option value="">Semua Status Berkas</option>
                @foreach(['Belum Upload', 'Sudah Upload', 'Terverifikasi', 'Perlu Perbaikan'] as $st)
                    <option value="{{ $st }}" {{ request('status_berkas') == $st ? 'selected' : '' }}>{{ $st }}</option>
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
                        <th class="px-6 py-4 text-left font-semibold">Jurusan</th>
                        <th class="px-6 py-4 text-left font-semibold">Jalur</th>
                        <th class="px-6 py-4 text-center font-semibold">Status Berkas</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $p)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $p->no_daftar }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $p->nama }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->jurusan }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->jalur }}</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badge = match($p->berkas_status) {
                                    'Belum Upload' => 'bg-gray-100 text-gray-600 border-gray-200',
                                    'Sudah Upload' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'Terverifikasi' => 'bg-green-50 text-green-700 border-green-200',
                                    'Perlu Perbaikan' => 'bg-amber-50 text-amber-600 border-amber-200',
                                    default => 'bg-gray-50 text-gray-500'
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                                {{ $p->berkas_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.ppdb.verifikasi-berkas', ['id' => $p->id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-bold transition shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4"></i> Periksa Berkas
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada pendaftar dengan status tersebut.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pendaftar->links() }}</div>

    @else
        {{-- ================= DETAIL VERIFICATION VIEW ================= --}}

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
            <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                {{ $selectedApplicant->berkas_status }}
            </span>
        </div>

        {{-- FORM VERIFIKASI BERKAS --}}
        <form action="{{ route('admin.ppdb.update-berkas', $selectedApplicant->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
                <table class="w-full text-base">
                    <thead class="bg-slate-50 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-bold w-1/4">Nama Dokumen</th>
                            <th class="px-6 py-4 text-center font-bold w-1/5">Berkas Fisik</th>
                            <th class="px-6 py-4 text-center font-bold w-1/5">Status Verifikasi</th>
                            <th class="px-6 py-4 text-left font-bold w-2/5">Catatan Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $docs = [
                                'kk' => 'Kartu Keluarga (KK)',
                                'akta' => 'Akta Kelahiran',
                                'ijazah' => 'Ijazah / SKL',
                                'raport' => 'Raport Nilai',
                                'foto' => 'Pas Foto 3x4'
                            ];
                        @endphp
                        @foreach($docs as $key => $label)
                        <tr class="hover:bg-gray-50/30 transition">
                            <td class="px-6 py-5 font-semibold text-gray-800">{{ $label }}</td>
                            <td class="px-6 py-5 text-center">
                                @if($selectedApplicant->{'berkas_' . $key})
                                <a href="{{ asset('storage/' . $selectedApplicant->{'berkas_' . $key}) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-bold transition shadow-sm">
                                    <i data-lucide="external-link" class="w-4 h-4"></i> Lihat File
                                </a>
                                @else
                                <span class="text-xs text-gray-400 italic">Belum Di-upload</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <select name="status_{{ $key }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                                    <option value="Belum Upload" {{ $selectedApplicant->{'status_' . $key} === 'Belum Upload' ? 'selected' : '' }}>Belum Upload</option>
                                    <option value="Sudah Upload" {{ $selectedApplicant->{'status_' . $key} === 'Sudah Upload' ? 'selected' : '' }}>Sudah Upload</option>
                                    <option value="Valid" {{ $selectedApplicant->{'status_' . $key} === 'Valid' ? 'selected' : '' }}>Valid</option>
                                    <option value="Perbaikan" {{ $selectedApplicant->{'status_' . $key} === 'Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                    <option value="Tidak Valid" {{ $selectedApplicant->{'status_' . $key} === 'Tidak Valid' ? 'selected' : '' }}>Tidak Valid</option>
                                </select>
                            </td>
                            <td class="px-6 py-5">
                                <input type="text" name="catatan_{{ $key }}" value="{{ $selectedApplicant->{'catatan_' . $key} }}" placeholder="Tulis catatan jika perlu perbaikan..." class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- KEPUTUSAN AKHIR VERIFIKASI -->
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i> Keputusan Akhir Verifikasi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Keseluruhan Berkas</label>
                        <select name="berkas_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                            <option value="Belum Upload" {{ $selectedApplicant->berkas_status === 'Belum Upload' ? 'selected' : '' }}>Belum Upload</option>
                            <option value="Sudah Upload" {{ $selectedApplicant->berkas_status === 'Sudah Upload' ? 'selected' : '' }}>Sudah Upload</option>
                            <option value="Terverifikasi" {{ $selectedApplicant->berkas_status === 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi (Lolos Berkas)</option>
                            <option value="Perlu Perbaikan" {{ $selectedApplicant->berkas_status === 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan/Pesan Tambahan untuk Calon Siswa</label>
                        <textarea name="catatan" rows="2" placeholder="Tuliskan catatan umum mengenai berkas pendaftar..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">{{ $selectedApplicant->catatan }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t pt-6">
                    <a href="{{ route('admin.ppdb.verifikasi-berkas') }}" class="px-6 py-3 border border-gray-200 rounded-xl font-bold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-md transition">
                        Simpan Hasil Verifikasi
                    </button>
                </div>
            </div>
        </form>
    @endif

</div>
@endsection
