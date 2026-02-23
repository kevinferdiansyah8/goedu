@props([
    'title',
    'icon',
    'active' => false
])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group {{ $active ? 'bg-blue-50 text-primary font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
        <div class="flex items-center gap-3">
            <i data-lucide="{{ $icon }}" class="w-5 h-5 transition-colors duration-200 {{ $active ? 'text-primary' : 'text-secondary group-hover:text-foreground' }}"></i>
            <span>{{ $title }}</span>
        </div>
        <i data-lucide="chevron-down" 
           class="w-4 h-4 transition-transform duration-300 {{ $active ? 'text-primary' : 'text-gray-400' }}"
           :class="open ? 'rotate-180' : ''"></i>
    </button>
    <div x-show="open" 
         x-collapse 
         x-cloak 
         class="pl-4 mt-1 space-y-1">
        {{ $slot }}
    </div>
</div>
