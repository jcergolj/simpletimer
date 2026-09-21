@props(['heading' => 'Track your time without the clutter.'])

<section class="py-20 bg-[var(--color-nav-bg)] text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl sm:text-4xl font-display text-[var(--color-nav-text)]">{{ $heading }}</h2>
        <p class="mt-5 text-lg text-[var(--color-nav-text-muted)]">{{ __('Use the managed app or self-host the source. Either way, your work stays organised and exportable.') }}</p>
        <a href="{{ route('register') }}" class="mt-8 inline-block btn-primary px-9 py-4 rounded-2xl">{{ __('Start your free trial') }}</a>
    </div>
</section>
