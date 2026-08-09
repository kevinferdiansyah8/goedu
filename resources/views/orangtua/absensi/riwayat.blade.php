@extends('layouts.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi Anak</h1>
            <p class="text-gray-600">Catatan kehadiran harian siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span>. Anda dapat memberikan alasan / komentar orang tua jika anak tidak masuk sekolah.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 flex items-center gap-3 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar View Widget -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-1 h-fit">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-extrabold text-gray-800 text-base">Kalender Absensi</h3>
                <span class="text-xs font-bold text-primary px-3 py-1 bg-primary/10 rounded-full">{{ date('F Y') }}</span>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-xs font-bold text-gray-400 mb-2">
                <div class="py-2 text-rose-500">Min</div>
                <div class="py-2">Sen</div>
                <div class="py-2">Sel</div>
                <div class="py-2">Rab</div>
                <div class="py-2">Kam</div>
                <div class="py-2">Jum</div>
                <div class="py-2">Sab</div>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold">
                @php
                    $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                    $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                    $dayOfWeekOffset = $startOfMonth->dayOfWeek; // 0 for Sunday
                @endphp
                @for($i = 0; $i < $dayOfWeekOffset; $i++)
                    <div class="py-2.5"></div>
                @endfor
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = \Carbon\Carbon::now()->format('Y-m-') . sprintf('%02d', $day);
                        $att = $riwayat->firstWhere('tanggal', $dateStr);
                        $bgClass = 'bg-gray-50 text-gray-700';
                        if ($att) {
                            if ($att->status == 'Hadir') $bgClass = 'bg-green-100 text-green-800 font-bold';
                            elseif ($att->status == 'Sakit') $bgClass = 'bg-yellow-100 text-yellow-800 font-bold';
                            elseif ($att->status == 'Izin') $bgClass = 'bg-blue-100 text-blue-800 font-bold';
                            else $bgClass = 'bg-rose-100 text-rose-800 font-bold';
                        }
                    @endphp
                    <div class="py-2.5 rounded-xl transition-all {{ $bgClass }}" title="{{ $att ? $att->status : 'Belum ada data' }}">
                        {{ $day }}
                    </div>
                @endfor
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100 flex flex-wrap gap-3 text-xs font-semibold">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span> Hadir</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-yellow-500 rounded-full"></span> Sakit</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span> Izin</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-rose-500 rounded-full"></span> Alpha</span>
            </div>
        </div>

        <!-- History List with Parent Comment Action -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="font-extrabold text-gray-800 text-base flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-primary"></i> Detail & Catatan Kehadiran
                </h3>
                <span class="text-xs font-semibold text-gray-400">Total: {{ count($riwayat) }} Rekaman</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4">Keterangan Sekolah</th>
                            <th class="p-4">Komentar / Alasan Ortu</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($riwayat as $r)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="p-4 font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                                <div class="text-[11px] text-gray-400 font-mono font-normal">
                                    {{ $r->jam_masuk ? 'Masuk: ' . $r->jam_masuk : '-' }}
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                @if($r->status == 'Hadir')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Hadir</span>
                                @elseif($r->status == 'Sakit')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Sakit</span>
                                @elseif($r->status == 'Izin')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Izin</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-600 text-xs font-medium">
                                {{ $r->keterangan ?? '-' }}
                            </td>
                            <td class="p-4">
                                @if($r->catatan_orangtua)
                                    <div class="p-2.5 bg-amber-50 border border-amber-200/70 rounded-xl text-xs text-amber-900 font-medium flex items-start gap-2">
                                        <i data-lucide="message-square" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                                        <span>{{ $r->catatan_orangtua }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada komentar</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <button type="button" 
                                    onclick="openModalOrtu({{ $r->id }}, '{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}', '{{ addslashes($r->catatan_orangtua ?? '') }}')"
                                    class="px-3 py-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1 mx-auto cursor-pointer">
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> 
                                    {{ $r->catatan_orangtua ? 'Edit Alasan' : '+ Alasan Ortu' }}
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500 font-medium">Belum ada riwayat absensi tercatat di database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL BERI ALASAN / KOMENTAR ORANG TUA (VANILLA JS MODAL - HIDDEN BY DEFAULT) -->
    <div id="modalAlasanOrtu" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" onclick="if(event.target===this) closeModalOrtu()">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 border border-gray-100 relative">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                        <i data-lucide="message-square-plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Berikan Alasan / Komentar Orang Tua</h3>
                        <p class="text-xs text-gray-400 font-medium" id="labelTanggalOrtu">Tanggal: -</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalOrtu()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form action="{{ route('orangtua.absensi.comment.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="attendance_id" id="inputAttendanceId">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alasan / Catatan Keterangan Orang Tua</label>
                    <textarea name="catatan_orangtua" id="inputCatatanOrtu" rows="4" required class="w-full border-gray-300 rounded-2xl text-sm focus:ring-primary focus:border-primary p-3.5 border font-medium bg-gray-50/50" placeholder="Misal: Anak saya tidak masuk karena demam tinggi & sudah berobat ke klinik terdekat. Mohon izin 2 hari."></textarea>
                    <p class="text-xs text-gray-400 mt-1.5">Catatan ini dapat langsung dilihat oleh Guru Pengampu & Wali Kelas.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModalOrtu()" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl text-sm transition-all shadow-md shadow-blue-200 cursor-pointer">
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModalOrtu(id, tanggal, comment) {
    document.getElementById('inputAttendanceId').value = id;
    document.getElementById('labelTanggalOrtu').innerText = 'Tanggal: ' + tanggal;
    document.getElementById('inputCatatanOrtu').value = comment;
    document.getElementById('modalAlasanOrtu').classList.remove('hidden');
}

function closeModalOrtu() {
    document.getElementById('modalAlasanOrtu').classList.add('hidden');
}
</script>
@endsection
