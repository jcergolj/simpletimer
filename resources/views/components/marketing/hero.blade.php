@props(['eyebrow', 'heading', 'intro'])

<section class="section-spacing gradient-bg overflow-hidden relative">
    <div class="geometric-accent circle" style="top: 18%; right: 12%;"></div>
    <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10 text-center">
        <div class="badge mb-7">
            <span class="accent-dot"></span>
            <span>{{ $eyebrow }}</span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display leading-tight text-[var(--color-text)]">{{ $heading }}</h1>
        <p class="mt-7 text-xl text-[var(--color-text-secondary)] leading-relaxed max-w-3xl mx-auto">{{ $intro }}</p>
        <div class="mt-9 flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-2xl">{{ __('Try SimpleTimer') }}</a>
            <a href="{{ route('home') }}#features" class="btn-secondary px-8 py-4 rounded-2xl">{{ __('See all features') }}</a>
        </div>
    </div>
</section>
