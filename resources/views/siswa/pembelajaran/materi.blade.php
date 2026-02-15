@extends('layouts.admin')

@section('title', 'Download Materi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Materi Pembelajaran</h1>
        <p class="text-gray-600">Download materi pelajaran yang telah diupload oleh guru.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Judul Materi</th>
                        <th class="px-6 py-4">Guru</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($materi as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item['mapel'] }}</td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                            {{ $item['judul'] }}
                        </td>
                        <td class="px-6 py-4">{{ $item['guru'] }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-md text-xs font-semibold hover:bg-blue-100 transition-colors">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                Download
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
