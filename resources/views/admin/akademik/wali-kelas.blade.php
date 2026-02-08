@extends('layouts.admin')

@section('title', 'Data Wali Kelas')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold flex items-center gap-2 mb-1">
            <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            Data Wali Kelas
        </h1>
        <p class="text-gray-500 text-sm">Daftar wali kelas beserta kelas yang diampu.</p>
    </div>
    @php
        $waliKelas = [
            [
                'nama' => 'Budi Santoso, S.Pd',
                'kelas_diampu' => 'X RPL 1',
                'kontak' => '081234567890',
            ],
            [
                'nama' => 'Siti Aminah, S.Pd',
                'kelas_diampu' => 'XI TKJ 2',
                'kontak' => '081298765432',
            ],
            [
                'nama' => 'Dewi Lestari, S.Pd',
                'kelas_diampu' => 'XII AKL 1',
                'kontak' => '081212345678',
            ],
        ];
    @endphp
    <div class="bg-white border rounded-2xl shadow p-6 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-700">
                    <th class="py-2 px-3 text-left">#</th>
                    <th class="py-2 px-3 text-left">Nama Wali Kelas</th>
                    <th class="py-2 px-3 text-left">Kelas Diampu</th>
                    <th class="py-2 px-3 text-left">Kontak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($waliKelas as $i => $w)
                <tr class="border-b last:border-0 hover:bg-blue-50/30">
                    <td class="py-2 px-3">{{ $i+1 }}</td>
                    <td class="py-2 px-3 font-semibold">{{ $w['nama'] }}</td>
                    <td class="py-2 px-3">{{ $w['kelas_diampu'] }}</td>
                    <td class="py-2 px-3">{{ $w['kontak'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
