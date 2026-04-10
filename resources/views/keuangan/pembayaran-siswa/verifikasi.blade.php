@extends('layouts.sidebar-keuangan')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-foreground">Verifikasi Pembayaran</h1>
            <p class="text-secondary text-sm mt-1">Verifikasi bukti pembayaran SPP dari siswa</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-warning-light text-warning-dark font-medium text-sm">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            <span>{{ count($pending) }} pembayaran menunggu verifikasi</span>
        </div>
    </div>

    <!-- Pending Payment Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($pending as $p)
        <div class="rounded-2xl border-2 border-warning/30 bg-white shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- Card Header -->
            <div class="flex items-center justify-between bg-gradient-to-r from-warning-light to-yellow-50 px-6 py-4 border-b border-warning/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-blue-600 text-white font-bold flex items-center justify-center text-sm">
                        {{ collect(explode(' ', $p['nama']))->map(fn($n) => $n[0])->join('') }}
                    </div>
                    <div>
                        <p class="font-semibold text-foreground">{{ $p['nama'] }}</p>
                        <p class="text-xs text-secondary">{{ $p['nis'] }} • {{ $p['kelas'] }}</p>
                    </div>
                </div>
                <span class="inline-flex px-3 py-1 rounded-full bg-warning text-warning-dark text-xs font-bold">Menunggu</span>
            </div>

            <!-- Card Body -->
            <div class="px-6 py-5 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-secondary">Bulan SPP</p>
                        <p class="font-medium text-foreground">{{ $p['bulan'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-secondary">Tanggal Bayar</p>
                        <p class="font-medium text-foreground">{{ $p['tanggal'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-secondary">Nominal</p>
                        <p class="font-bold text-lg text-primary">Rp {{ number_format($p['nominal'], 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-secondary">Metode</p>
                        <p class="font-medium text-foreground">{{ $p['metode'] }}</p>
                    </div>
                </div>

                <!-- Bukti Transfer -->
                <div class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center overflow-hidden">
                            <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-foreground">{{ $p['bukti'] }}</p>
                            <p class="text-xs text-secondary">Bukti transfer</p>
                            <button class="mt-1 text-xs text-primary font-semibold hover:underline" onclick="alert('Preview bukti pembayaran {{ $p['nama'] }}')">Lihat Bukti →</button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <form action="{{ route('keuangan.pembayaran.verifikasi.update', $p['id']) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Terverifikasi">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-success text-white rounded-xl font-semibold hover:bg-green-600 transition-all shadow-sm cursor-pointer">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Terima
                        </button>
                    </form>
                    <form action="{{ route('keuangan.pembayaran.verifikasi.update', $p['id']) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-error text-white rounded-xl font-semibold hover:bg-red-600 transition-all shadow-sm cursor-pointer">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            Tolak
                        </button>
                    </form>
                    <button class="size-10 flex items-center justify-center rounded-xl ring-1 ring-border hover:ring-primary transition-all cursor-pointer" title="Detail">
                        <i data-lucide="more-horizontal" class="w-4 h-4 text-secondary"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($pending) === 0)
    <!-- Empty State -->
    <div class="flex flex-col items-center justify-center py-20">
        <div class="w-20 h-20 bg-success-light rounded-full flex items-center justify-center mb-4">
            <i data-lucide="check-circle-2" class="w-10 h-10 text-success"></i>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">Semua Terverifikasi!</h3>
        <p class="text-secondary">Tidak ada pembayaran yang menunggu verifikasi saat ini.</p>
    </div>
    @endif

</div>
@endsection
