<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simple') }}</title>
    <link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />
</head>
<body class="min-h-screen" style="background: var(--color-bg);">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="app-nav sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-16">
                        <h1 class="text-xl font-display text-[var(--color-nav-text)]">{{ config('app.name', 'Simple') }}</h1>
                        <div class="hidden md:flex items-center gap-8">
                            <a href="#features" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('Features') }}</a>
                            <a href="#pricing" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('Pricing') }}</a>
                            <a href="#faq" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('FAQ') }}</a>
                            <a href="https://github.com/jcergolj/simpletimer" target="_blank" rel="noopener noreferrer" class="nav-item flex items-center gap-2.5 text-sm font-medium px-3 py-2 rounded-lg group">
                                <svg class="h-5 w-5 transform group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                                <span>GitHub</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Dashboard') }}</a>
                        @else
                            @if (!\App\Facades\TenantDatabaseServiceFacade::isMainDomain(request()) || Config::get('app.single_user_mode'))
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-[var(--color-nav-text-muted)] hover:text-[var(--color-nav-text)] transition-colors hidden sm:inline-block">{{ __('Log in') }}</a>
                            @endif
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Get Started') }}</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    @endif

    <!-- Hero Section -->
    <section class="section-spacing gradient-bg overflow-hidden relative">
        <!-- Geometric Accents -->
        <div class="geometric-accent circle" style="top: 20%; right: 15%; animation: float 4s ease-in-out infinite;"></div>
        <div class="geometric-accent square" style="bottom: 30%; left: 10%; animation: float 4s ease-in-out infinite; animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                <div class="lg:col-span-6 space-y-8">
                    <div class="badge">
                        <span class="accent-dot"></span>
                        <span class="text-[var(--color-text)]">Open Source • <a href="https://osaasy.dev/" target="_blank" rel="noopener noreferrer" class="hover:underline">O'Saasy Licensed</a></span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-display mb-4 leading-[1.05]">
                        <span class="bg-gradient-to-br from-[var(--color-text)] via-[var(--color-text-secondary)] to-[var(--color-text)] bg-clip-text text-transparent">
                            {{ __('SimpleTimer') }}
                        </span>
                    </h1>

                    <p class="text-2xl sm:text-3xl font-display text-[var(--color-text-secondary)] leading-[1.25]">
                        <span class="text-orange-500">{{ __('One click away.') }}</span>
                    </p>

                    <div class="space-y-3">
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed">
                            {{ __('Track time in seconds, see exactly what to invoice, export CSVs — done.') }}
                        </p>
                        <p class="text-base text-[var(--color-text-muted)]">
                            {{ __('No onboarding. No bloat.') }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary px-8 py-4 rounded-2xl text-center inline-flex items-center justify-center gap-2">
                                <span>{{ __('Go to Dashboard') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="btn-primary px-10 py-5 rounded-2xl text-center inline-flex items-center justify-center gap-2 text-base font-semibold">
                                    <span>{{ __('Start tracking — 60-day free trial, no credit card') }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                                <a href="https://github.com/jcergolj/simpletimer#readme" target="_blank" rel="noopener noreferrer" class="btn-secondary px-10 py-5 rounded-2xl text-center inline-flex items-center justify-center gap-2 text-base font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>{{ __('Self-host for free — Full source code included') }}</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="screenshot-container relative">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-20 blur-3xl"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-20 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Dashboard preview" class="w-full h-[450px] object-contain object-center relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Audience Filter -->
    <section class="py-24 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-2xl bg-[var(--color-primary-light)]">
                    <svg class="w-8 h-8 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-4xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Not for teams. Not for dashboards full of features you\'ll never use.') }}
                </h2>
                <p class="text-xl text-[var(--color-text-secondary)] max-w-3xl mx-auto leading-relaxed">
                    {{ __('Built for solo freelancers, senior developers, and consultants who just want the number to invoice.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    @php
        $userCounter = app(\App\Services\UserCounterService::class);
        $totalUsers = $userCounter->getTotalUsers();
        $remainingSlots = $userCounter->getRemainingFreeSlots();
    @endphp

    <section id="pricing" class="section-spacing bg-gradient-to-br from-[var(--color-bg)] to-[var(--color-surface)]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Simple, Honest Pricing') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] max-w-2xl mx-auto leading-relaxed">
                    {{ __('No hidden fees. No complicated tiers. Just straightforward time tracking that respects your time and your budget.') }}
                </p>
            </div>

            <!-- Early Adopter Banner -->
            @if($remainingSlots > 0)
                <div class="max-w-3xl mx-auto mb-12">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-4 py-1.5 rounded-full text-sm font-semibold text-green-800 mb-3">
                            🎉 {{ __('Early Adopter Offer') }}
                        </div>
                        <p class="text-2xl font-display text-[var(--color-text)] mb-2">
                            {{ $remainingSlots }} {{ __('of 10 lifetime free spots remaining') }}
                        </p>
                        <p class="text-[var(--color-text-secondary)] mb-4">
                            {{ __('Be one of the first 10 users. Get free access forever + help shape the product.') }}
                        </p>
                        <ul class="space-y-1 mb-3">
                            <li class="flex items-center justify-center gap-2 text-sm text-[var(--color-text)]">
                                <x-icons.check class="w-4 h-4 text-green-600 flex-shrink-0" />
                                <span>{{ __('Free access forever + influence future features') }}</span>
                            </li>
                        </ul>
                        <p class="text-sm text-[var(--color-text-secondary)]">
                            {{ __('Grandfathered into all future features included.') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-16">
                <!-- Self-Hosted (Free Forever) -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 border-[var(--color-primary)] relative overflow-hidden transform transition-all hover:scale-105">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[var(--color-primary-light)] to-[var(--color-accent-light)] rounded-full opacity-50 blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-[var(--color-primary-light)] text-[var(--color-primary)] px-3 py-1 rounded-full text-xs font-semibold mb-6">
                            {{ __('Open Source') }}
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('Self-Hosted') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ __('Free') }}</span>
                            <span class="text-[var(--color-text-secondary)]"> {{ __('forever') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Host on your server, keep your data') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Full source code access') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('All core features included') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Complete data control') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Community support') }}</span>
                            </li>
                        </ul>

                        <a href="https://github.com/jcergolj/simpletimer" target="_blank" rel="noopener noreferrer" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold group">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Self-host now — Free forever') }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Managed SaaS -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 border-[var(--color-border)] relative overflow-hidden transform transition-all hover:scale-105">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full text-xs font-semibold text-green-800 mb-6">
                            {{ __('Risk-Free') }}
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('Managed SaaS') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ config('app.yearly_price') }}</span>
                            <span class="text-[var(--color-text-secondary)]">/{{ __('year') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Try all features free for 60 days. Cancel anytime — risk-free.') }}</p>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6 font-medium">{{ __('60 days is enough to see exactly how much time you save and how easily you can invoice your clients.') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Unlimited clients & projects') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('All features included, risk-free') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Cancel anytime, no contracts') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ config('app.refund_period_days') }}-{{ __('day money-back guarantee') }}</span>
                            </li>
                        </ul>

                        <a href="{{ route('register') }}" class="block text-center btn-secondary px-6 py-3 rounded-xl text-sm font-semibold">
                            {{ __('Start tracking — 60-day free trial, no credit card') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-spacing bg-[var(--color-surface)]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 text-[var(--color-text)]">
                    {{ __('Everything You Need to Track Time') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] max-w-2xl mx-auto">
                    {{ __('Dead simple timer. Client management. Reports. That\'s it.') }}
                </p>
            </div>

            <!-- Features Grid: 2x2 on desktop, stack on mobile -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20">
                <!-- Feature 1: Track Time Instantly -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/running-timer.png') }}" alt="Running timer with keyboard shortcuts" class="w-full h-[450px] object-contain object-center relative z-10">
                    </div>
                    <div class="inline-flex items-center gap-2 bg-[var(--color-primary-light)] text-[var(--color-primary)] px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ __('Tracking') }}</span>
                    </div>
                    <h3 class="text-3xl font-display leading-tight text-[var(--color-text)]">
                        {{ __('Track Time Instantly') }}
                    </h3>
                    <ul class="space-y-2 text-[var(--color-text-secondary)]">
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('One click starts/stops timer') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('Ctrl+Shift+S / Ctrl+Shift+T shortcuts') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('No tutorials, no setup') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Feature 2: Reports That Get You Paid -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/reports.png') }}" alt="CSV reports showing per-client totals" class="w-full h-[450px] object-contain object-center relative z-10">
                    </div>
                    <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('Reporting') }}</span>
                    </div>
                    <h3 class="text-3xl font-display leading-tight text-[var(--color-text)]">
                        {{ __('Reports That Get You Paid') }}
                    </h3>
                    <ul class="space-y-2 text-[var(--color-text-secondary)]">
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('Filter by client/project') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('Export CSVs to your invoice tool') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('See weekly, monthly, or custom totals') }}</span>
                        </li>
                    </ul>
                    <p class="text-sm font-semibold text-[var(--color-text)]">
                        {{ __('SimpleTimer produces reports, not invoices.') }}
                    </p>
                </div>

                <!-- Feature 3: Privacy & Control -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/start-tracking-with-new-client.png') }}" alt="Self-hosting privacy control" class="w-full h-[450px] object-contain object-center relative z-10">
                    </div>
                    <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>{{ __('Privacy') }}</span>
                    </div>
                    <h3 class="text-3xl font-display leading-tight text-[var(--color-text)]">
                        {{ __('Privacy & Control') }}
                    </h3>
                    <ul class="space-y-2 text-[var(--color-text-secondary)]">
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('Self-host on your server or use managed SaaS') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('No vendor lock-in') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" />
                            <span>{{ __('Your data, your rules') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Feature 4: Multi-Currency & Hourly Rates -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Multi-currency client tracking" class="w-full h-[450px] object-contain object-center relative z-10">
                    </div>
                    <div class="inline-flex items-center gap-2 bg-[var(--color-primary-light)] text-[var(--color-primary)] px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ __('Multi-Currency') }}</span>
                    </div>
                    <h3 class="text-3xl font-display leading-tight text-[var(--color-text)]">
                        {{ __('Multi-Currency & Hourly Rates') }}
                    </h3>
                    <ul class="space-y-2 text-[var(--color-text-secondary)]">
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('Set rates per client/project') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('Track international earnings') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                            <span>{{ __('Weekly, monthly, or custom period totals') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="section-spacing bg-[var(--color-bg)]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl sm:text-4xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Why SimpleTimer') }}
                </h2>
                <p class="text-2xl font-display text-[var(--color-text-secondary)] leading-relaxed mb-6">
                    {{ __('"No onboarding. No tutorials. Just track time, see what to invoice, move on."') }}
                </p>
                <p class="text-lg text-[var(--color-text-muted)] leading-relaxed">
                    {{ __('SimpleTimer is built for freelancers who already know what they\'re doing.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- O'Saasy Explainer Section -->
    <section class="section-spacing bg-[var(--color-surface)]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl sm:text-4xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Open Source + SaaS License = You Win') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed mb-8">
                    {{ __('SimpleTimer is O\'Saasy licensed. That means you can self-host it on your server for free forever. Or use our managed version. Either way, your data is yours. You\'re never locked in.') }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center gap-8 text-[var(--color-text)]">
                    <span class="flex items-center gap-3">
                        <x-icons.check class="w-5 h-5 text-green-600 flex-shrink-0" />
                        <span>{{ __('Full source code access') }}</span>
                    </span>
                    <span class="flex items-center gap-3">
                        <x-icons.check class="w-5 h-5 text-green-600 flex-shrink-0" />
                        <span>{{ __('Export data anytime') }}</span>
                    </span>
                    <span class="flex items-center gap-3">
                        <x-icons.check class="w-5 h-5 text-green-600 flex-shrink-0" />
                        <span>{{ __('No vendor lock-in') }}</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-gradient-to-b from-[var(--color-bg)] to-[var(--color-surface)]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-display mb-4 text-[var(--color-text)]">
                    {{ __('Questions?') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)]">
                    {{ __('Here\'s what freelancers usually ask:') }}
                </p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 - Moved to first (biggest misconception) -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Do I need invoicing features?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('No. SimpleTimer produces clean reports you can plug into any invoicing tool.') }}
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Is it really free forever?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Yes. Self-hosted stays free forever. Managed SaaS is optional.') }}
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('How hard is self-hosting?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('DigitalOcean, Vultr, or Linode install in 15 minutes. Need help? Laravel Forge handles it.') }}
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('What if I break it?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Community support via GitHub; fixes mostly in the README.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-[var(--color-surface)] to-[var(--color-bg)] border-t-2 border-[var(--color-border-light)] py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <h3 class="font-display text-2xl mb-4 text-[var(--color-text)]">{{ config('app.name', 'Simple Timer') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed mb-6 max-w-md">
                        {{ __('A simple time tracking web app for developers and freelancers who value simplicity and privacy.') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="https://github.com/jcergolj/simpletimer" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-[var(--color-nav-bg)] hover:bg-[var(--color-primary)] rounded-xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-display text-sm font-bold text-[var(--color-text)] mb-5 uppercase tracking-wider">{{ __('Resources') }}</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="https://github.com/jcergolj/simpletimer" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('GitHub Repository') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletimer#readme" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Documentation') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletimer/issues" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Report Issues') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="font-display text-sm font-bold text-[var(--color-text)] mb-5 uppercase tracking-wider">{{ __('Project') }}</h4>
                    <ul class="space-y-3 text-[var(--color-text-secondary)]">
                        <li class="flex items-center gap-2">
                            <x-icons.check class="w-4 h-4 text-green-600" />
                            <span><a href="https://osaasy.dev/" target="_blank" rel="noopener noreferrer" class="hover:underline hover:text-green-700">O'Saasy Licensed</a></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icons.check class="w-4 h-4 text-[var(--color-primary)]" />
                            <span>{{ __('Built with Laravel 12') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icons.check class="w-4 h-4 text-orange-600" />
                            <span>{{ __('Self-Hosted') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t-2 border-[var(--color-border)]">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[var(--color-text-muted)] text-sm">
                        © {{ date('Y') }} <span class="font-semibold text-[var(--color-text)]">{{ config('app.name', 'Simple') }}</span>. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
