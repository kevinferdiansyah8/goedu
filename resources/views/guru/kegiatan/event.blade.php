@extends('layouts.admin')

@section('title', 'Event')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-2">Event Sekolah</h1>
  <p class="text-gray-500 mb-6">Event dan kegiatan sekolah yang diikuti guru</p>

  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow p-5">
      <h3 class="font-semibold text-lg">Peringatan Hari Guru</h3>
      <p class="text-sm text-gray-500">25 November 2026</p>
      <p class="mt-2 text-gray-600">Upacara dan kegiatan sekolah</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
      <h3 class="font-semibold text-lg">Workshop Kurikulum</h3>
      <p class="text-sm text-gray-500">5 Maret 2026</p>
      <p class="mt-2 text-gray-600">Pelatihan guru</p>
    </div>
  </div>
</div>
@endsection
