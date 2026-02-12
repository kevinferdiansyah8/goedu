@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengumuman Sekolah</h1>
        <p class="text-gray-600">Informasi penting dari pihak sekolah.</p>
    </div>

    <div class="space-y-4">
        <!-- Announcement Item -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-bold uppercase tracking-wider">Penting</span>
                        <span class="text-xs text-gray-500">10 Februari 2024</span>
                    </div>
                    <a href="#" class="block text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors mb-2">
                        Pemberitahuan Libur Pemilu 2024
                    </a>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        Diberitahukan kepada seluruh siswa dan orang tua murid bahwa kegiatan belajar mengajar diliburkan pada tanggal 14 Februari 2024 dikarenakan adanya Pemilihan Umum. KBM akan normal kembali pada tanggal 15 Februari 2024.
                    </p>
                </div>
                <div class="flex items-center">
                    <a href="#" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>

        <!-- Announcement Item -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <div>
                     <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-bold uppercase tracking-wider">Info Akademik</span>
                        <span class="text-xs text-gray-500">01 Februari 2024</span>
                    </div>
                    <a href="#" class="block text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors mb-2">
                        Jadwal Ujian Tengah Semester (UTS) Genap
                    </a>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        Berikut kami lampirkan jadwal lengkap Ujian Tengah Semester (UTS) Genap Tahun Ajaran 2023/2024. Mohon dipersiapkan dengan baik.
                    </p>
                </div>
                <div class="flex items-center">
                    <a href="#" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200">
                        Download Jadwal
                    </a>
                </div>
            </div>
        </div>

         <!-- Announcement Item -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <div>
                     <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-bold uppercase tracking-wider">Kegiatan</span>
                        <span class="text-xs text-gray-500">25 Januari 2024</span>
                    </div>
                    <a href="#" class="block text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors mb-2">
                        Open Recruitment Ekstrakurikuler Paskibra
                    </a>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        Bagi siswa-siswi yang berminat untuk bergabung dengan Paskibra sekolah, pendaftaran telah dibuka mulai hari ini.
                    </p>
                </div>
                <div class="flex items-center">
                    <a href="#" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
