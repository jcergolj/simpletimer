@props(['compact' => false])

<section class="bg-[var(--color-bg)] {{ $compact ? 'py-12 lg:py-16' : 'py-20 lg:py-24' }}">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-[var(--color-primary)]">{{ __('See it in action') }}</p>
            <h2 class="mt-3 text-3xl font-display text-[var(--color-text)] sm:text-4xl">{{ __('A clear view of your workday') }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-[var(--color-text-secondary)]">{{ __('Start a timer, review your entries, and export a report without digging through a complicated interface.') }}</p>
        </div>

        <div class="mt-12 grid gap-8 lg:grid-cols-2">
            <figure class="overflow-hidden rounded-3xl border-2 border-[var(--color-border)] bg-[var(--color-surface)] shadow-lg">
                <div class="bg-[var(--color-surface-raised)] p-3 sm:p-5">
                    <img src="{{ asset('screenshots/running-timer.png') }}" alt="SimpleTimer running timer" class="block h-auto w-full rounded-xl shadow-sm" loading="lazy" width="1216" height="1065">
                </div>
                <figcaption class="p-6">
                    <h3 class="text-xl font-display text-[var(--color-text)]">{{ __('Track time in one click') }}</h3>
                    <p class="mt-2 text-[var(--color-text-secondary)]">{{ __('Choose a client or project and start working.') }}</p>
                </figcaption>
            </figure>
            <figure class="overflow-hidden rounded-3xl border-2 border-[var(--color-border)] bg-[var(--color-surface)] shadow-lg">
                <div class="bg-[var(--color-surface-raised)] p-3 sm:p-5">
                    <img src="{{ asset('screenshots/dashboard.png') }}" alt="SimpleTimer dashboard" class="block h-auto w-full rounded-xl shadow-sm" loading="lazy" width="1216" height="1199">
                </div>
                <figcaption class="p-6">
                    <h3 class="text-xl font-display text-[var(--color-text)]">{{ __('Review the day at a glance') }}</h3>
                    <p class="mt-2 text-[var(--color-text-secondary)]">{{ __('See recent entries, clients, projects, and totals in one place.') }}</p>
                </figcaption>
            </figure>
        </div>

        <figure class="mt-8 grid items-center gap-8 overflow-hidden rounded-3xl border-2 border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-lg lg:grid-cols-2 lg:p-8">
            <div class="bg-[var(--color-surface-raised)] p-3 sm:p-5">
                <img src="{{ asset('screenshots/reports.png') }}" alt="SimpleTimer reports" class="block h-auto w-full rounded-xl shadow-sm" loading="lazy" width="1280" height="1158">
            </div>
            <figcaption>
                <p class="text-sm font-semibold uppercase tracking-wider text-[var(--color-primary)]">{{ __('Reports') }}</p>
                <h3 class="mt-3 text-3xl font-display text-[var(--color-text)]">{{ __('Turn tracked time into a clear client record') }}</h3>
                <p class="mt-4 leading-relaxed text-[var(--color-text-secondary)]">{{ __('Filter your work and export CSV or PDF reports for the next step in your existing workflow.') }}</p>
            </figcaption>
        </figure>
    </div>
</section>
