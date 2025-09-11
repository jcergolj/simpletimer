@props(['size' => 'md'])

@php
$sizeClasses = match($size) {
    'sm' => 'px-2 py-1 text-xs',
    'md' => 'px-3 py-1.5 text-sm',
    default => 'px-3 py-1.5 text-sm',
};
$dotSize = match($size) {
    'sm' => 'w-1.5 h-1.5 mr-1',
    'md' => 'w-2 h-2 mr-1.5',
    default => 'w-2 h-2 mr-1.5',
};
@endphp

<span class="inline-flex items-center {{ $sizeClasses }} rounded-lg font-medium bg-red-100 text-red-800 border border-red-200">
    <span class="{{ $dotSize }} bg-red-500 rounded-full animate-pulse"></span>
    <span class="animate-pulse">{{ __('Running') }}</span>
</span>
