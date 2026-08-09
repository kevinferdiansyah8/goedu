@extends('layouts.admin')

@section('title', 'Data Anak')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Anak</h1>
        <p class="text-gray-600">Informasi siswa (putra/putri).</p>
    </div>

    @forelse($students as $student)
        @php
            $className = $student->schoolClass ? ($student->schoolClass->nama_lengkap ?? $student->schoolClass->nama_display) : ('Kelas ' . ($student->kelas ?? '-'));
            $waliKelas = ($student->schoolClass && $student->schoolClass->teacher) ? $student->schoolClass->teacher->nama : '-';
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
                 <div class="flex items-center gap-4">
                     <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                     </div>
                     <div>
                         <h3 class="font-bold text-gray-800 text-lg">{{ $student->nama }}</h3>
                         <p class="text-xs text-gray-500">NISN: {{ $student->nisn ?? '-' }} | NIS: {{ $student->nis ?? '-' }}</p>
                     </div>
                 </div>
                 <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Kelas Saat Ini</span>
                        <span class="font-semibold text-blue-600">{{ $className }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Tempat, Tanggal Lahir</span>
                        <span class="font-medium text-gray-800">{{ $student->tempat_lahir ?? '-' }}, {{ $student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                     <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Jenis Kelamin</span>
                        <span class="font-medium text-gray-800">{{ $student->jenis_kelamin ?? '-' }}</span>
                    </div>
                     <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Wali Kelas</span>
                        <span class="font-medium text-gray-800">{{ $waliKelas }}</span>
                    </div>
                     <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Tahun Masuk</span>
                        <span class="font-medium text-gray-800">{{ $student->created_at ? $student->created_at->format('Y') : date('Y') }}</span>
                    </div>
                     <div class="flex justify-between border-b border-gray-50 py-2">
                        <span class="text-gray-500">Alamat Email Sekolah</span>
                        <span class="font-medium text-gray-800">{{ $student->email ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
            Belum ada data anak terhubung dengan akun ini.
        </div>
    @endforelse
</div>
@endsection
