@extends('layouts.sidebar-guru')

@section('title', 'Komentar & Feedback Tugas')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10">

    {{-- HEADER --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-200">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Komentar & Feedback</h1>
                <p class="text-sm text-gray-500">Semua feedback yang sudah Anda berikan ke tugas siswa — data realtime dari database.</p>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Feedback</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $feedbacks->count() }}</h3>
                </div>
                <div class="p-3 bg-violet-50 text-violet-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sudah Dinilai</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $recentlyGraded->count() }}</h3>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Nilai</p>
                    @php $avgNilai = $recentlyGraded->avg('nilai'); @endphp
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $avgNilai ? round($avgNilai, 1) : '-' }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- FEEDBACK WITH COMMENTS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-violet-500 to-purple-600">
            <h2 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                Feedback yang Telah Diberikan
            </h2>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($feedbacks as $fb)
            <div class="p-5 hover:bg-gray-50/50 transition-colors">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0">
                        {{ strtoupper(substr($fb->student->nama ?? '-', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <div>
                                <span class="font-semibold text-gray-900">{{ $fb->student->nama ?? '-' }}</span>
                                <span class="text-xs text-gray-400 ml-2">{{ $fb->assignment->subject->nama ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($fb->nilai !== null)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $fb->nilai >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    Nilai: {{ $fb->nilai }}
                                </span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $fb->updated_at ? $fb->updated_at->diffForHumans() : '-' }}</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Tugas: <span class="font-medium text-gray-700">{{ $fb->assignment->judul ?? '-' }}</span> • {{ $fb->assignment->schoolClass ? ($fb->assignment->schoolClass->tingkat . ' ' . $fb->assignment->schoolClass->nama_kelas) : '-' }}</p>
                        <div class="bg-violet-50 border border-violet-100 rounded-xl p-3">
                            <p class="text-sm text-gray-700">{{ $fb->feedback }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="mx-auto w-16 h-16 text-gray-300 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900">Belum ada feedback</h3>
                <p class="text-sm text-gray-500 mt-1">Berikan penilaian dan feedback di halaman <a href="{{ route('guru.tugas.penilaian') }}" class="text-blue-600 hover:underline">Penilaian Tugas</a>.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- RECENTLY GRADED (tanpa feedback text) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900 text-sm uppercase tracking-wider">Tugas Terbaru yang Sudah Dinilai</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Feedback</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentlyGraded as $rg)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">{{ substr($rg->student->nama ?? '-', 0, 2) }}</div>
                                <div class="text-sm font-medium text-gray-900">{{ $rg->student->nama ?? '-' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $rg->assignment->judul ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $rg->assignment->subject->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-bold {{ ($rg->nilai ?? 0) >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ $rg->nilai ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $rg->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-[200px] truncate">{{ $rg->feedback ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada tugas yang dinilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
