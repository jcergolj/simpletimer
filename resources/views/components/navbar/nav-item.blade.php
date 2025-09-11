@props(['icon' => null, 'current' => false, 'as' => 'a'])

@if ($as === 'a')
<a {{ $attributes->merge(['class' => 'nav-item flex items-center px-3 py-2 text-sm font-medium rounded-md ' . ($current ? 'active' : '')]) }}>
    @if ($icon)
        <x-dynamic-component :component="'heroicon-o-'.$icon" class="w-4 h-4 mr-2" />
    @endif
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge(['type' => 'button', 'class' => 'nav-item flex items-center px-3 py-2 text-sm font-medium rounded-md ' . ($current ? 'active' : '')]) }}>
    @if ($icon)
        <x-dynamic-component :component="'heroicon-o-'.$icon" class="w-4 h-4 mr-2" />
    @endif
    {{ $slot }}
</button>
@endif