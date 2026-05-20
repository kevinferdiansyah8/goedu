@extends('layouts.sidebar-guru')

@section('title', 'Absensi Siswa - EDUGO')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-20" x-data="absensiPage()">
    
    {{-- PAGE HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Sistem Absensi Siswa</h1>
            <p class="text-sm text-gray-500 mt-1">Catat kehadiran siswa berdasarkan jadwal mengajar Anda.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <div class="font-medium">{{ session('success') }}</div>
    </div>
    @endif
    
    @if($errors->any())
    <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100">
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- FILTER SECTION --}}
    <form id="filterForm" method="GET" action="{{ route('guru.absensi.pertemuan') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/2">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Jadwal / Kelas</label>
                <select name="schedule_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                    <option value="">-- Pilih Jadwal Mengajar --</option>
                    @foreach($jadwalMengajar as $j)
                        <option value="{{ $j->id }}" {{ $selectedScheduleId == $j->id ? 'selected' : '' }}>
                            {{ $j->subject->nama_pelajaran ?? '-' }} - Kelas {{ $j->schoolClass->tingkat ?? '' }} {{ $j->schoolClass->nama_kelas ?? '' }} ({{ $j->hari }}, {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Pertemuan</label>
                <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
            </div>
        </div>
    </form>

    @if($selectedScheduleId)
        @if($students->count() > 0)
            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                <div class="bg-white p-3 rounded-xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Total</p>
                        <p class="text-lg font-bold text-gray-900" x-text="students.length"></p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center"><i data-lucide="users" class="w-4 h-4"></i></div>
                </div>
                <div class="bg-white p-3 rounded-xl border border-green-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-green-500 uppercase">Hadir</p>
                        <p class="text-lg font-bold text-green-700" x-text="countStatus('Hadir')"></p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center"><i data-lucide="user-check" class="w-4 h-4"></i></div>
                </div>
                <div class="bg-white p-3 rounded-xl border border-blue-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-blue-500 uppercase">Izin</p>
                        <p class="text-lg font-bold text-blue-700" x-text="countStatus('Izin')"></p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center"><i data-lucide="info" class="w-4 h-4"></i></div>
                </div>
                <div class="bg-white p-3 rounded-xl border border-orange-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-orange-500 uppercase">Sakit</p>
                        <p class="text-lg font-bold text-orange-700" x-text="countStatus('Sakit')"></p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center"><i data-lucide="thermometer" class="w-4 h-4"></i></div>
                </div>
                <div class="bg-white p-3 rounded-xl border border-red-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-red-500 uppercase">Alpa</p>
                        <p class="text-lg font-bold text-red-700" x-text="countStatus('Alpha')"></p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center"><i data-lucide="user-x" class="w-4 h-4"></i></div>
                </div>
            </div>

            {{-- QUICK ACTION: SET ALL TO HADIR --}}
            <div class="flex justify-end mb-4">
                <button type="button" @click="setAll('Hadir')" class="text-sm font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="check-square" class="w-4 h-4"></i> Set Semua Hadir
                </button>
            </div>

            {{-- MAIN FORM --}}
            <form method="POST" action="{{ route('guru.absensi.pertemuan.store') }}">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $selectedScheduleId }}">
                <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-24">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left w-16 uppercase text-[10px] font-bold">No</th>
                                    <th class="px-6 py-4 text-left uppercase text-[10px] font-bold">Nama Siswa</th>
                                    <th class="px-6 py-4 text-left uppercase text-[10px] font-bold w-32">NIS</th>
                                    <th class="px-6 py-4 text-center uppercase text-[10px] font-bold min-w-[300px]">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($students as $index => $student)
                                    @php
                                        $existingAbsen = $attendances->get($student->id);
                                        $currentStatus = $existingAbsen ? $existingAbsen->status : 'Hadir'; // Default to Hadir if not set
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">{{ $student->nama }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 font-mono">{{ $student->nis }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2 bg-gray-50 p-1 rounded-xl w-max mx-auto border border-gray-200">
                                                {{-- Hadir --}}
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="Hadir" class="peer sr-only" x-model="getStudent({{ $student->id }}).status">
                                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-gray-500 transition-all peer-checked:bg-green-500 peer-checked:text-white peer-checked:shadow-sm hover:bg-gray-100">Hadir</div>
                                                </label>
                                                {{-- Izin --}}
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="Izin" class="peer sr-only" x-model="getStudent({{ $student->id }}).status">
                                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-gray-500 transition-all peer-checked:bg-blue-500 peer-checked:text-white peer-checked:shadow-sm hover:bg-gray-100">Izin</div>
                                                </label>
                                                {{-- Sakit --}}
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="Sakit" class="peer sr-only" x-model="getStudent({{ $student->id }}).status">
                                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-gray-500 transition-all peer-checked:bg-orange-500 peer-checked:text-white peer-checked:shadow-sm hover:bg-gray-100">Sakit</div>
                                                </label>
                                                {{-- Alpa --}}
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="Alpha" class="peer sr-only" x-model="getStudent({{ $student->id }}).status">
                                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-gray-500 transition-all peer-checked:bg-red-500 peer-checked:text-white peer-checked:shadow-sm hover:bg-gray-100">Alpa</div>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- FLOATING ACTION BUTTON --}}
                <div class="fixed bottom-6 right-6 z-40">
                    <button type="submit" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white font-bold rounded-full shadow-2xl hover:bg-indigo-700 hover:scale-105 transition-all shadow-indigo-200">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span>Simpan Absensi</span>
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-gray-200 shadow-sm">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada siswa di kelas ini!</h3>
                <p class="text-gray-500 text-sm">Pastikan kelas ini sudah memiliki siswa terdaftar.</p>
            </div>
        @endif
    @else
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
            <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="clipboard-list" class="w-10 h-10"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pilih Jadwal Terlebih Dahulu</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Silakan pilih jadwal mengajar (kelas & mapel) pada filter di atas untuk memulai pendataan absensi siswa.</p>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('absensiPage', () => ({
            students: [],
            
            init() {
                // Initialize students data from blade
                @if($selectedScheduleId && $students->count() > 0)
                    @foreach($students as $student)
                        @php
                            $existingAbsen = $attendances->get($student->id);
                            $currentStatus = $existingAbsen ? $existingAbsen->status : 'Hadir';
                        @endphp
                        this.students.push({
                            id: {{ $student->id }},
                            status: '{{ $currentStatus }}'
                        });
                    @endforeach
                @endif
            },

            getStudent(id) {
                let s = this.students.find(s => s.id === id);
                if (!s) {
                    s = { id: id, status: 'Hadir' };
                    this.students.push(s);
                }
                return s;
            },

            countStatus(statusType) {
                return this.students.filter(s => s.status === statusType).length;
            },

            setAll(statusType) {
                this.students.forEach(s => {
                    s.status = statusType;
                });
            }
        }));
    });
</script>
@endpush
@endsection