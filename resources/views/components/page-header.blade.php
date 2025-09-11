@props(['title', 'subtitle' => null])

<div class="px-4 sm:px-0">
    <h1 class="font-display page-heading">{{ __($title) }}</h1>
    @if($subtitle)
        <p class="page-subheading">{{ __($subtitle) }}</p>
    @endif
</div>
