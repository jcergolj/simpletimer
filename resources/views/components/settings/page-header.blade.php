@props([
    'title',
    'description',
])

<div class="text-center py-4 mb-8">
    <h1 class="text-3xl font-bold mb-2" style="color: var(--color-text);">{{ $title }}</h1>
    <p style="color: var(--color-text-secondary);">{{ $description }}</p>
</div>
