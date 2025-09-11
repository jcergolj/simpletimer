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
                            <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="nav-item flex items-center gap-2.5 text-sm font-medium px-3 py-2 rounded-lg group">
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
                        {{ __('Don\'t waste') }}
                        <span class="text-[var(--color-primary)]">{{ __('time') }}</span>
                        <span class="text-orange-500">{{ __('tracking') }}</span>
                        <span class="text-[var(--color-primary)]">{{ __('time') }}</span>
                    </p>

                    <p class="text-base text-[var(--color-text-secondary)] leading-relaxed max-w-lg">
                        {{ __('The fastest way to track billable hours. One-click timer. Client tracking. Reports. CSV export. Zero bloat.') }}
                    </p>

                    <div class="inline-flex items-center gap-3 bg-gradient-to-r from-[var(--color-primary-light)] to-orange-100 px-5 py-3 rounded-xl border border-[var(--color-primary)]/20">
                        <span class="text-2xl">⚡</span>
                        <p class="text-base font-semibold text-[var(--color-text)]">
                            {{ __('New client? New project? One dashboard, one click — track it in under 30 seconds.') }}
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
                                    <span>{{ __('Start Tracking Free') }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            @endif
                            @if (!\App\Facades\TenantDatabaseServiceFacade::isMainDomain(request()) || Config::get('app.single_user_mode'))
                            <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 rounded-2xl text-center">
                                {{ __('Sign In') }}
                            </a>
                            @endif
                        @endauth
                    </div>

                    <a href="https://github.com/jcergolj/simpletime#readme" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 text-sm font-medium text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="link-hover">{{ __('View Installation Guide') }}</span>
                    </a>
                </div>

                <div class="lg:col-span-6">
                    <div class="screenshot-container relative">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-20 blur-3xl"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-20 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Dashboard preview" class="w-full h-auto relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Audience -->
    <section class="py-24 bg-[var(--color-surface)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-display mb-4 text-[var(--color-text)]">
                    {{ __('Built for Solo Freelancers & Developers') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] max-w-2xl mx-auto">
                    {{ __('If you bill by the hour and value simplicity, this is for you:') }}
                </p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="flex items-start gap-3">
                    <x-icons.check class="w-6 h-6 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                    <p class="text-lg text-[var(--color-text)]">{{ __('Freelancers tracking multiple clients across projects') }}</p>
                </div>
                <div class="flex items-start gap-3">
                    <x-icons.check class="w-6 h-6 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                    <p class="text-lg text-[var(--color-text)]">{{ __('Developers who want privacy and full data control') }}</p>
                </div>
                <div class="flex items-start gap-3">
                    <x-icons.check class="w-6 h-6 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                    <p class="text-lg text-[var(--color-text)]">{{ __('Consultants billing in multiple currencies') }}</p>
                </div>
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
                        <p class="text-[var(--color-text-secondary)]">
                            {{ __('Be one of the first 10 users and get free access forever. No credit card. No catch.') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Early Adopter Plan -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 @if($remainingSlots > 0) border-green-500 @else border-[var(--color-border)] @endif relative overflow-hidden transform transition-all hover:scale-105">
                    @if($remainingSlots > 0)
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-200 rounded-full opacity-50 blur-2xl"></div>
                    @endif

                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full text-xs font-semibold text-green-800 mb-6">
                            @if($remainingSlots > 0) {{ __('Limited Offer') }} @else {{ __('Sold Out') }} @endif
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('First 10 Users') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ __('Free') }}</span>
                            <span class="text-[var(--color-text-secondary)]"> {{ __('forever') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Lifetime access, zero cost') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('All core features included') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Regular updates') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Data export anytime') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Community support') }}</span>
                            </li>
                        </ul>

                        <p class="text-xs text-[var(--color-text-muted)] mb-6">{{ __('* No priority support') }}</p>

                        @if($remainingSlots > 0)
                            <a href="{{ route('register') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">
                                {{ __('Claim Your Spot') }}
                            </a>
                        @else
                            <div class="block text-center bg-[var(--color-bg)] px-6 py-3 rounded-xl text-sm font-semibold text-[var(--color-text-muted)]">
                                {{ __('No Spots Available') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Standard Plan -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 @if($remainingSlots == 0) border-[var(--color-primary)] @else border-[var(--color-border)] @endif relative overflow-hidden transform transition-all hover:scale-105">
                    @if($remainingSlots == 0)
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[var(--color-primary-light)] to-[var(--color-accent-light)] rounded-full opacity-50 blur-2xl"></div>
                    @endif

                    <div class="relative z-10">
                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('Standard Plan') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ config('app.yearly_price') }}</span>
                            <span class="text-[var(--color-text-secondary)]">/{{ __('year') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Try free for :days days', ['days' => config('app.trial_period_days')]) }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Everything in Early Adopter') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ config('app.trial_period_days') }} - {{ __('days free trial') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ config('app.refund_period_days') }} - {{ __('day money-back guarantee') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Cancel anytime') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('No credit card required') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Unlimited clients & projects') }}</span>
                            </li>
                        </ul>

                        <a href="{{ route('register') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">
                            {{ __('Start Free Trial') }}
                        </a>
                    </div>
                </div>

                <!-- Self-Hosted -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 border-[var(--color-border)] relative overflow-hidden transform transition-all hover:scale-105">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-[var(--color-bg)] px-3 py-1 rounded-full text-xs font-semibold text-[var(--color-text)] mb-6">
                            {{ __('Open Source') }}
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('Self-Hosted') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ __('Free') }}</span>
                            <span class="text-[var(--color-text-secondary)]"> {{ __('forever') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Host it yourself') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-text-secondary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Full source code access') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-text-secondary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('O\'Saasy licensed') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-text-secondary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Deploy on your server') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-text-secondary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Complete data control') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-[var(--color-text-secondary)] mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Community support') }}</span>
                            </li>
                        </ul>

                        <a href="https://github.com/jcergolj/simpletimer" target="_blank" rel="noopener noreferrer" class="block text-center btn-secondary px-6 py-3 rounded-xl text-sm font-semibold group">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                                {{ __('View on GitHub') }}
                            </span>
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

            <div class="space-y-32">
                <!-- Feature 1: Track Time In Seconds -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-7 lg:pr-16 space-y-6">
                        <div class="inline-flex items-center gap-2 bg-[var(--color-primary-light)] text-[var(--color-primary)] px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ __('Tracking') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-[var(--color-text)]">
                            {{ __('Track Time') }}
                            <span class="text-[var(--color-primary)]">{{ __('In Seconds') }}</span>
                        </h2>
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed mb-6">
                            {{ __('Hit Ctrl+Shift+S to start. Ctrl+Shift+T to stop. One click starts your timer. One click stops it. No bloat, no BS.') }}
                        </p>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="screenshot-container relative">
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/running-timer.png') }}" alt="Active timer showing elapsed time and project details" class="w-full h-auto relative z-10">
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Organize Work Effortlessly -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1">
                        <div class="screenshot-container relative">
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/start-tracking-with-new-client.png') }}" alt="Creating a new client while starting timer" class="w-full h-auto relative z-10">
                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 lg:pl-16 space-y-6">
                        <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>{{ __('Organization') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-[var(--color-text)]">
                            {{ __('Organize Your Work') }}
                            <span class="text-orange-600">{{ __('Effortlessly') }}</span>
                        </h2>
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed mb-6">
                            {{ __('Create clients on-the-fly while starting timers. Set rates once, track forever. Track London clients at £75/hr and NYC projects at $100/hr. 56 currencies built in.') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 3: Reports That Pay You -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-7 lg:pr-16 space-y-6">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ __('Reporting') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-[var(--color-text)]">
                            {{ __('Reports That') }}
                            <span class="text-green-600">{{ __('Get You Paid') }}</span>
                        </h2>
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed mb-6">
                            {{ __('Filter by client. Export to CSV. Attach to invoice. Get paid. Export clean CSVs for invoicing. The entire workflow in 30 seconds.') }}
                        </p>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="screenshot-container relative">
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/reports.png') }}" alt="Generate reports" class="w-full h-auto relative z-10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-gradient-to-b from-[var(--color-surface)] to-[var(--color-bg)]">
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
                <!-- FAQ 1 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Is it really free forever?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Yes. O\'Saasy license means free self-hosting forever. We reserve rights to offer a managed SaaS version, but the open-source stays free.') }}
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('What happens after the trial?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Your trial lasts :days full days. If you continue, pay :yearly_price/year. If not, let it expire—no charges, no questions.', ['days' => config('app.trial_period_days'), 'yearly_price' => config('app.yearly_price')]) }}
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('How hard is self-hosting?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Works on DigitalOcean ($5/mo), Vultr, Linode. Install time: 15 minutes. Requirements: PHP 8.4 + Git. Managed option: Laravel Forge ($12/mo).') }}
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('What if I break it?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Support via GitHub issues. Active community. Common fixes in README.') }}
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
                        <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-[var(--color-nav-bg)] hover:bg-[var(--color-primary)] rounded-xl flex items-center justify-center transition-all duration-300 group">
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
                            <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('GitHub Repository') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime#readme" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Documentation') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime/issues" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] transition-colors inline-flex items-center gap-2 group">
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
