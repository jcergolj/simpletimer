@props([
    'route',
    'icon',
    'title',
    'description',
])

<a href="{{ route($route) }}" class="flex items-center px-6 py-4 transition-colors hover:bg-[var(--color-bg)]">
    <div class="flex-shrink-0">
        @php
            $iconComponent = 'heroicon-o-' . $icon;
        @endphp
        <x-dynamic-component :component="$iconComponent" class="h-6 w-6" style="color: var(--color-text-muted);" />
    </div>
    <div class="ml-4 flex-1">
        <h3 class="text-sm font-medium" style="color: var(--color-text);">{{ $title }}</h3>
        <p class="text-sm" style="color: var(--color-text-secondary);">{{ $description }}</p>
    </div>
    <div class="flex-shrink-0">
        <x-heroicon-o-chevron-right class="h-5 w-5" style="color: var(--color-text-muted);" />
    </div>
</a>
