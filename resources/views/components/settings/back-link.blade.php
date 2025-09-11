@props([
    'route' => 'settings.menu',
    'text' => 'Back to Settings',
])

<div class="mb-6">
    <a href="{{ route($route) }}" class="inline-flex items-center text-sm font-medium transition-colors hover:opacity-80" style="color: var(--color-text-secondary);">
        <x-heroicon-o-arrow-left class="h-4 w-4 mr-1" />
        {{ __($text) }}
    </a>
</div>
