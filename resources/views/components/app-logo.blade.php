@props(['variant' => 'dark'])

<div class="flex items-center">
    <span @class([
        'text-xl font-display',
        'text-[var(--color-nav-text)]' => $variant === 'light',
        'text-[var(--color-text)]' => $variant === 'dark',
    ])>{{ config('app.name', 'SimpleTime') }}</span>
</div>
