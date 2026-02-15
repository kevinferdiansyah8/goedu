@extends('layouts.admin')

@section('title', 'Agenda Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Agenda Kegiatan</h1>
        <p class="text-gray-600">Jadwal kegiatan rutin dan agenda sekolah.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                @foreach($agenda as $item)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-blue-500 text-slate-500 group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <!-- Card -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-4 rounded border border-slate-200 shadow">
                        <div class="flex items-center justify-between space-x-2 mb-1">
                            <div class="font-bold text-slate-900">{{ $item['kegiatan'] }}</div>
                            <time class="font-caveat font-medium text-blue-500">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}</time>
                        </div>
                        <div class="text-slate-500 text-sm flex items-center gap-2 mb-2">
                            <i data-lucide="clock" class="w-3 h-3"></i> {{ $item['waktu'] }}
                        </div>
                        <div class="text-slate-600 text-sm">
                            Bertempat di <span class="font-semibold">{{ $item['tempat'] }}</span>. Harap hadir tepat waktu menggunakan seragam lengkap.
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
