@props([
    'activeStep' => 1,
    'subjectId' => null,
    'classId' => null
])

@php
    $steps = [
        ['name' => 'Mapel', 'icon' => 'book-open', 'route' => 'guru.akademik.mata-pelajaran'],
        ['name' => 'Jadwal', 'icon' => 'calendar', 'route' => 'guru.akademik.jadwal-mengajar'],
        ['name' => 'Siswa', 'icon' => 'users', 'route' => 'guru.akademik.kelas'],
        ['name' => 'Nilai Tugas', 'icon' => 'edit-3', 'route' => 'guru.akademik.nilai.tugas'],
        ['name' => 'Nilai Rapor', 'icon' => 'file-text', 'route' => 'guru.akademik.nilai.rapor'],
        ['name' => 'Rekap', 'icon' => 'pie-chart', 'route' => 'guru.akademik.rekap'],
    ];

    $params = [];
    if ($subjectId) $params['subject_id'] = $subjectId;
    if ($classId) $params['class_id'] = $classId;
@endphp

<div class="mb-10 w-full overflow-x-auto pb-4 scrollbar-hide">
    <div class="flex items-center justify-between min-w-[800px] px-2">
        @foreach($steps as $index => $step)
            @php 
                $stepNum = $index + 1;
                $isActive = $activeStep == $stepNum;
                $isCompleted = $activeStep > $stepNum;
            @endphp

            <div class="flex flex-col items-center flex-1 relative">
                {{-- Connector Line --}}
                @if($index < count($steps) - 1)
                    <div class="absolute top-6 left-[60%] right-[-40%] h-[2px] z-0">
                        <div class="h-full {{ $activeStep > $stepNum ? 'bg-indigo-600' : 'bg-gray-200' }} transition-all duration-500"></div>
                    </div>
                @endif

                {{-- Step Circle --}}
                <a 
                    @if($isCompleted || $isActive) 
                        href="{{ route($step['route'], $params) }}" 
                    @else 
                        href="javascript:void(0)" 
                    @endif
                    class="relative z-10 w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-300 transform 
                    {{ $isActive ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 scale-110' : 
                       ($isCompleted ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'bg-gray-100 text-gray-400') }}
                    {{ ($isCompleted || $isActive) ? 'hover:scale-105 active:scale-95 cursor-pointer' : 'cursor-default' }}"
                >
                    @if($isCompleted)
                        <i data-lucide="check" class="w-6 h-6"></i>
                    @else
                        <i data-lucide="{{ $step['icon'] }}" class="w-6 h-6"></i>
                    @endif
                </a>

                {{-- Step Label --}}
                <div class="mt-3 flex flex-col items-center">
                    <span class="text-[10px] uppercase font-bold tracking-widest leading-none {{ $isActive ? 'text-indigo-600' : ($isCompleted ? 'text-emerald-600' : 'text-gray-400') }}">Langkah {{ $stepNum }}</span>
                    <span class="text-xs font-black mt-1 whitespace-nowrap {{ $isActive ? 'text-gray-900' : 'text-gray-500' }}">{{ $step['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>
@endpush
