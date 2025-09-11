@props(['href', 'turboFrame' => null])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'btn-timer-cancel px-4 py-2 rounded-lg inline-flex items-center']) }}
    @if($turboFrame) data-turbo-frame="{{ $turboFrame }}" @endif
>
    {{ $slot }}
</a>
