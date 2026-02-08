@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-2">Pengumuman</h1>
  <p class="text-gray-500 mb-6">Informasi dan pengumuman resmi sekolah</p>

  <div class="space-y-4">
    <div class="bg-white rounded-xl shadow p-5">
      <h3 class="font-semibold">Libur Nasional</h3>
      <p class="text-sm text-gray-500">10 Februari 2026</p>
      <p class="mt-2 text-gray-600">
        Sekolah libur dalam rangka hari nasional.
      </p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
      <h3 class="font-semibold">Pengumpulan Nilai</h3>
      <p class="text-sm text-gray-500">15 Februari 2026</p>
      <p class="mt-2 text-gray-600">
        Guru diminta mengumpulkan nilai sebelum batas waktu.
      </p>
    </div>
  </div>
</div>
@endsection
