@props([
    'href',
    'active' => false
])

<a href="{{ $href }}" 
   class="block px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $active ? 'text-primary font-medium bg-blue-50/50' : 'text-secondary hover:text-foreground hover:bg-gray-50' }}">
    {{ $slot }}
</a>
