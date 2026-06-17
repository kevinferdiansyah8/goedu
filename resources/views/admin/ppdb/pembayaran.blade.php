@extends('layouts.admin')

@section('title', 'PPDB - Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-10">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Pembayaran PPDB</h1>
            <p class="text-gray-500 mt-1">Verifikasi pembayaran biaya pendaftaran calon siswa</p>
        </div>
        @if($selectedApplicant)
        <a href="{{ route('admin.ppdb.pembayaran') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
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
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Belum Bayar</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['belum'] }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-50"><i data-lucide="wallet" class="w-7 h-7 text-blue-600"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sudah Bayar</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['sudah'] }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-green-50"><i data-lucide="check-circle" class="w-7 h-7 text-green-600"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Lunas</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $summary['lunas'] }}</div>
                </div>
            </div>
        </div>

        {{-- FILTER FORM --}}
        <form class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-4 flex flex-wrap gap-4 items-center" method="GET">
            <select name="status_bayar" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-sm font-semibold" onchange="this.form.submit()">
                <option value="">Semua Status Pembayaran</option>
                @foreach(['Belum Bayar', 'Sudah Bayar', 'Lunas', 'Ditolak'] as $sb)
                    <option value="{{ $sb }}" {{ request('status_bayar') == $sb ? 'selected' : '' }}>{{ $sb }}</option>
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
                        <th class="px-6 py-4 text-center font-semibold">Nominal</th>
                        <th class="px-6 py-4 text-center font-semibold">Status Pembayaran</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $p)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $p->no_daftar }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $p->nama }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->jurusan }}</td>
                        <td class="px-6 py-4 text-center font-bold text-gray-900">
                            Rp {{ number_format($p->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $badge = match($p->status_pembayaran) {
                                    'Lunas' => 'bg-green-50 text-green-700 border-green-200',
                                    'Sudah Bayar' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'Ditolak' => 'bg-red-50 text-red-600 border-red-200',
                                    default => 'bg-gray-100 text-gray-600 border-gray-200'
                                };
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                                {{ $p->status_pembayaran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.ppdb.pembayaran', ['id' => $p->id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-bold transition shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4"></i> Periksa Pembayaran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada data pendaftar lulus seleksi.</td>
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
        </div>

        <!-- INFO TAGIHAN & TRANSAKSI -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex flex-col justify-center">
                <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Biaya Formulir</span>
                <span class="text-2xl font-black text-blue-600 mt-1">Rp 250.000</span>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex flex-col justify-center">
                <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Status Pembayaran</span>
                @php
                    $bStyle = match($selectedApplicant->status_pembayaran) {
                        'Lunas' => 'bg-green-50 text-green-700 border-green-200',
                        'Sudah Bayar' => 'bg-blue-50 text-blue-600 border-blue-200',
                        'Ditolak' => 'bg-red-50 text-red-600 border-red-200',
                        default => 'bg-gray-50 text-gray-500'
                    };
                @endphp
                <span class="inline-flex self-start mt-2 px-3 py-1 rounded-full text-xs font-bold border {{ $bStyle }}">
                    {{ $selectedApplicant->status_pembayaran }}
                </span>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex flex-col justify-center">
                <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Metode & Tanggal</span>
                <span class="font-bold text-gray-900 mt-1">{{ $payment->metode ?? 'Transfer Bank' }}</span>
                <span class="text-xs text-gray-400 mt-0.5">{{ $payment->tanggal ?? '-' }}</span>
            </div>
        </div>

        <!-- BUKTI PEMBAYARAN -->
        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-900">Bukti Pembayaran Pendaftar</h2>
            @if(!$payment || !$payment->bukti)
                <p class="text-gray-400 italic text-sm">Calon siswa belum mengunggah bukti transfer pembayaran.</p>
            @else
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="w-full md:w-64 h-64 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center overflow-hidden relative shadow-sm">
                        <img src="{{ asset('storage/' . $payment->bukti) }}" alt="Bukti Pembayaran" class="object-contain w-full h-full">
                    </div>
                    <div class="space-y-3 flex-1">
                        <div>
                            <span class="text-xs text-gray-400 font-bold block uppercase tracking-wider">Nama File Bukti</span>
                            <span class="text-sm font-semibold text-gray-800">{{ basename($payment->bukti) }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-bold block uppercase tracking-wider">Keterangan Transfer</span>
                            <span class="text-sm text-gray-600">{{ $payment->keterangan ?? 'Tidak ada keterangan tambahan' }}</span>
                        </div>
                        <a href="{{ asset('storage/' . $payment->bukti) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md transition">
                            <i data-lucide="external-link" class="w-4 h-4"></i> Buka File Asli
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- VERIFIKASI ADMIN -->
        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Proses Keputusan Pembayaran</h2>
            <form action="{{ route('admin.ppdb.update-pembayaran', $selectedApplicant->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Keputusan Verifikasi</label>
                        <select name="status_pembayaran" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                            <option value="Belum Bayar" {{ $selectedApplicant->status_pembayaran === 'Belum Bayar' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="Sudah Bayar" {{ $selectedApplicant->status_pembayaran === 'Sudah Bayar' ? 'selected' : '' }}>Sudah Bayar (Menunggu Verifikasi)</option>
                            <option value="Lunas" {{ $selectedApplicant->status_pembayaran === 'Lunas' ? 'selected' : '' }}>Terima (Lunas)</option>
                            <option value="Ditolak" {{ $selectedApplicant->status_pembayaran === 'Ditolak' ? 'selected' : '' }}>Tolak Pembayaran (Bukti Tidak Valid)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Admin</label>
                        <textarea name="catatan" rows="2" placeholder="Contoh: Nominal transfer kurang, atau gambar bukti buram..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">{{ $payment->keterangan ?? '' }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t pt-6">
                    <a href="{{ route('admin.ppdb.pembayaran') }}" class="px-6 py-3 border border-gray-200 rounded-xl font-bold text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-md transition">
                        Simpan Verifikasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
@endsection
