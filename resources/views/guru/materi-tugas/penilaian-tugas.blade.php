@extends('layouts.admin')

@section('title', 'Penilaian Tugas')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Penilaian Tugas</h1>
        <p class="text-gray-600">Berikan nilai dan umpan balik pada tugas yang dikumpulkan siswa</p>
    </div>
    <a href="{{ route('guru.tugas.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors shadow-sm cursor-pointer flex items-center gap-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Tugas
    </a>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-success text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-in slide-in-from-bottom-8 z-50">
    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-lg mt-8">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <th class="py-4 px-6 text-left">
                        <span class="font-semibold text-gray-700">Siswa</span>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <span class="font-semibold text-gray-700">Tugas / Mata Pelajaran</span>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <span class="font-semibold text-gray-700">Status</span>
                    </th>
                    <th class="py-4 px-6 text-left">
                        <span class="font-semibold text-gray-700">Waktu Kumpul</span>
                    </th>
                    <th class="py-4 px-6 text-center w-64">
                        <span class="font-semibold text-gray-700">Nilai & Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengumpulan as $p)
                <tr class="hover:bg-blue-50 transition-colors duration-200">
                    <td class="py-5 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold">
                                {{ collect(explode(' ', $p->student->nama))->map(fn($n) => $n[0])->join('') }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $p->student->nama }}</p>
                                <p class="text-xs text-secondary">{{ $p->student->nis }} • {{ $p->student->kelas }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <p class="font-medium text-gray-900 line-clamp-1">{{ $p->assignment->judul }}</p>
                        <p class="text-xs text-secondary mt-1">{{ $p->assignment->subject->nama }}</p>
                    </td>
                    <td class="py-5 px-6">
                        @if($p->status === 'Belum Selesai')
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Belum Selesai</span>
                        @elseif($p->status === 'Dikumpulkan')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Perlu Dinilai</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Selesai Dinilai</span>
                        @endif
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-900 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_kumpul)->format('d M y H:i') }}</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <form action="{{ route('guru.tugas.penilaian.update', $p->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="number" name="nilai" value="{{ $p->nilai }}" min="0" max="100" class="w-20 px-3 py-2 border rounded-lg text-sm text-center outline-none focus:border-primary" placeholder="0-100" required {{ $p->status === 'Belum Selesai' ? 'disabled' : '' }}>
                            
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors {{ $p->status === 'Belum Selesai' ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}" {{ $p->status === 'Belum Selesai' ? 'disabled' : '' }}>
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center border-t border-dashed">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada yang mengumpulkan</h3>
                            <p class="text-gray-500 mt-1">Siswa belum mengunggah jawaban untuk tugas yang Anda berikan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
