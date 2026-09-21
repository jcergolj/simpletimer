<x-layouts.marketing
    title="Time Tracking for Virtual Assistants | SimpleTimer"
    description="Simple time tracking for independent virtual assistants managing direct clients. Switch clients, track short tasks, apply rates, and export client-ready reports."
    :canonical="route('marketing.time-tracker-for-virtual-assistants')"
>
    @php
        $trialUrl = route('register', ['utm_source' => 'va_landing', 'utm_campaign' => 'va_landing']);
    @endphp

    <section class="overflow-hidden bg-[var(--color-bg)] py-20 lg:py-28">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-16 px-6 lg:grid-cols-12 lg:px-8">
            <div class="lg:col-span-7">
                <p class="mb-6 inline-flex rounded-full bg-[var(--color-primary-light)] px-4 py-2 text-sm font-semibold text-[var(--color-primary)]">
                    {{ __('For independent virtual assistants') }}
                </p>
                <h1 class="max-w-4xl text-5xl leading-[1.05] font-display text-[var(--color-text)] sm:text-6xl">
                    {{ __('Time tracking for virtual assistants with multiple direct clients') }}
                </h1>
                <p class="mt-8 max-w-2xl text-xl leading-relaxed text-[var(--color-text-secondary)]">
                    {{ __('Keep short client tasks accounted for without turning your workday into admin. Start, switch, and stop timers with enough detail to make your next report easy.') }}
                </p>
                <div class="mt-8 rounded-2xl border-2 border-[var(--color-primary)] bg-[var(--color-surface)] p-5">
                    <p class="font-semibold text-[var(--color-text)]">{{ __('Best for solo VAs who choose their own tools and bill hourly or track prepaid client hours.') }}</p>
                </div>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    @auth
                        <a href="{{ route('dashboard') }}" data-landing-event="va-dashboard" class="btn-primary inline-flex items-center justify-center rounded-xl px-7 py-4 font-semibold">{{ __('Go to your dashboard') }}</a>
                    @else
                        <a href="{{ $trialUrl }}" data-landing-event="va-trial-start" class="btn-primary inline-flex items-center justify-center rounded-xl px-7 py-4 font-semibold">{{ __('Try it on your next client workday') }}</a>
                    @endauth
                    <a href="#fit" data-landing-event="va-fit-check" class="btn-secondary inline-flex items-center justify-center rounded-xl px-7 py-4 font-semibold">{{ __('See if it fits your workflow') }}</a>
                </div>
                <p class="mt-4 text-sm text-[var(--color-text-muted)]">{{ __('60-day trial. Then €59/year for the managed version.') }}</p>
            </div>
            <div class="lg:col-span-5">
                <div class="rounded-3xl border-2 border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-xl">
                    <div class="mb-4 flex items-center justify-between border-b border-[var(--color-border-light)] pb-4">
                        <span class="font-display text-lg text-[var(--color-text)]">{{ __('Today') }}</span>
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">{{ __('Tracking') }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ([['Northstar VA support', 'Inbox and calendar', '01:18:42'], ['Mira Studio', 'Content scheduling', '00:42:16'], ['Oak & Pine', 'Weekly admin', '00:27:09']] as $entry)
                            <div class="rounded-2xl bg-[var(--color-bg)] p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-[var(--color-text)]">{{ $entry[0] }}</p>
                                        <p class="mt-1 text-sm text-[var(--color-text-secondary)]">{{ $entry[1] }}</p>
                                    </div>
                                    <span class="font-mono text-sm text-[var(--color-primary)]">{{ $entry[2] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-5 text-center text-sm text-[var(--color-text-muted)]">{{ __('Switch clients without losing the thread.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="bg-[var(--color-surface)] py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-wider text-[var(--color-primary)]">{{ __('A smaller tool for a specific job') }}</p>
                <h2 class="mt-3 text-4xl font-display text-[var(--color-text)]">{{ __('The details that matter when client work comes in small pieces') }}</h2>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @foreach ([
                    ['01', 'Switch recent clients quickly', 'Keep active clients and projects close at hand, so a quick change of task does not become a memory test.'],
                    ['02', 'Track short tasks accurately', 'Start and stop focused work, or add time manually when a small task is already finished.'],
                    ['03', 'Use the right rate for each client', 'Set client- or project-specific hourly rates so your totals reflect the agreement you actually made.'],
                    ['04', 'Send a useful report', 'Filter your work and export client-ready CSV or PDF reports for the next review or billing step.'],
                ] as $feature)
                    <article class="rounded-2xl border-2 border-[var(--color-border-light)] bg-[var(--color-bg)] p-7">
                        <span class="font-mono text-sm text-[var(--color-primary)]">{{ $feature[0] }}</span>
                        <h3 class="mt-5 text-2xl font-display text-[var(--color-text)]">{{ __($feature[1]) }}</h3>
                        <p class="mt-3 leading-relaxed text-[var(--color-text-secondary)]">{{ __($feature[2]) }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[var(--color-bg)] py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <h2 class="text-4xl font-display text-[var(--color-text)]">{{ __('Your timer is a work log, not a monitoring system') }}</h2>
                <p class="mt-5 text-lg leading-relaxed text-[var(--color-text-secondary)]">{{ __('SimpleTimer records the time and project details you choose to track. It does not require screenshots, activity scores, or surveillance to make a client report.') }}</p>
            </div>
            <div class="rounded-3xl bg-[var(--color-surface)] p-8">
                <ul class="space-y-4 text-[var(--color-text)]">
                    @foreach (['No screenshots', 'No mouse or keyboard monitoring', 'No activity score', 'You decide what to record and export'] as $point)
                        <li class="flex items-center gap-3"><x-icons.check class="h-5 w-5 flex-shrink-0 text-green-600" /> <span>{{ __($point) }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section id="pricing" class="bg-[var(--color-surface)] py-20 lg:py-24">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div class="rounded-3xl border-2 border-[var(--color-primary)] bg-[var(--color-bg)] p-8 text-center sm:p-12">
                <p class="text-sm font-semibold uppercase tracking-wider text-[var(--color-primary)]">{{ __('One plan for the managed app') }}</p>
                <h2 class="mt-3 text-4xl font-display text-[var(--color-text)]">€59<span class="text-xl text-[var(--color-text-secondary)]">/{{ __('year') }}</span></h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-[var(--color-text-secondary)]">{{ __('Try the full managed version for 60 days. Use it during real client work before deciding whether it earns its place in your toolkit.') }}</p>
                <a href="{{ $trialUrl }}" data-landing-event="va-pricing-trial-start" class="btn-primary mt-8 inline-flex rounded-xl px-8 py-4 font-semibold">{{ __('Try it on your next client workday') }}</a>
            </div>
        </div>
    </section>

    <section id="fit" class="bg-[var(--color-bg)] py-20 lg:py-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <h2 class="text-4xl font-display text-[var(--color-text)]">{{ __('A clear fit, and a clear boundary') }}</h2>
            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl bg-green-50 p-7">
                    <h3 class="text-xl font-display text-green-900">{{ __('A good fit if you...') }}</h3>
                    <ul class="mt-4 space-y-3 text-green-900">
                        <li>• {{ __('Work solo and choose your own tools') }}</li>
                        <li>• {{ __('Bill hourly or track prepaid client hours') }}</li>
                        <li>• {{ __('Need client/project totals and exportable reports') }}</li>
                    </ul>
                </div>
                <div class="rounded-2xl bg-orange-50 p-7">
                    <h3 class="text-xl font-display text-orange-900">{{ __('Not trying to be...') }}</h3>
                    <p class="mt-4 leading-relaxed text-orange-900">{{ __('SimpleTimer is for tracking and reporting time. It does not replace your invoicing, CRM, or retainer-management workflow.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[var(--color-primary)] py-20">
        <div class="mx-auto max-w-3xl px-6 text-center lg:px-8">
            <h2 class="text-4xl font-display text-white">{{ __('Make your next client workday easier to account for') }}</h2>
            <p class="mt-4 text-lg text-white/80">{{ __('Start with one client, one project, and one real workday. The useful test is whether you come back to it.') }}</p>
            <a href="{{ $trialUrl }}" data-landing-event="va-final-trial-start" class="mt-8 inline-flex rounded-xl bg-white px-8 py-4 font-semibold text-[var(--color-primary)]">{{ __('Try it on your next client workday') }}</a>
        </div>
    </section>
</x-layouts.marketing>
