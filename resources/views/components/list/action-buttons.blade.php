@props([
    'editRoute',
    'deleteRoute',
    'confirmMessage',
    'showEdit' => true,
])

<div class="flex items-center gap-2">
    @if($showEdit)
        <a href="{{ $editRoute }}" class="btn-action-edit px-3 py-2 rounded-lg text-sm inline-flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-[var(--color-edit)] focus:ring-offset-2 hover:scale-105">
            <x-icons.edit class="w-4 h-4 flex-shrink-0" />
            <span>{{ __('Edit') }}</span>
        </a>
    @endif

    <a href="{{ $deleteRoute }}"
       class="btn-action-delete px-3 py-2 rounded-lg text-sm inline-flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-[var(--color-danger)] focus:ring-offset-2 hover:scale-105"
       data-turbo-method="delete"
       data-turbo-confirm="{{ $confirmMessage }}"
       data-turbo-frame="_top">
        <x-icons.delete class="w-4 h-4 flex-shrink-0" />
        <span>{{ __('Delete') }}</span>
    </a>
</div>
