<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time Tracking for Freelance Developers &amp; Consultants | SimpleTimer</title>
    <meta name="description" content="Simple time tracking for freelance developers and consultants who bill hourly. Track client work, see billable totals, and export reports. €59/year after a 60-day free trial.">
    <link rel="canonical" href="{{ url('/') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="Time Tracking for Freelance Developers &amp; Consultants | SimpleTimer">
    <meta property="og:description" content="Know exactly what to invoice. Track client work, review billable totals, and export reports without a complicated app.">
    <meta property="og:image" content="{{ asset('screenshots/dashboard.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Time Tracking for Freelance Developers &amp; Consultants | SimpleTimer">
    <meta name="twitter:description" content="Know exactly what to invoice. Track client work, review billable totals, and export reports without a complicated app.">
    <meta name="twitter:image" content="{{ asset('screenshots/dashboard.png') }}">

    {{-- Structured Data --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SoftwareApplication",
        "name": "{{ config('app.name', 'SimpleTimer') }}",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web",
        "url": "{{ url('/') }}",
        "offers": [
            {
                "@@type": "Offer",
                "price": "0",
                "priceCurrency": "EUR",
                "description": "Self-hosted — free forever"
            },
            {
                "@@type": "Offer",
                "price": "59",
                "priceCurrency": "EUR",
                "description": "Managed SaaS — yearly"
            }
        ],
         "description": "Simple time tracking for freelance developers and consultants who bill hourly, with clients, projects, hourly rates, and exportable reports."
    }
    </script>

    <link href="{{ tailwindcss('css/app.css') }}@tailwindcssVersion" rel="stylesheet" data-turbo-track="reload" />
</head>
<body class="min-h-screen" style="background: var(--color-bg);">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="app-nav sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-16">
                        <a href="{{ route('home') }}" class="text-xl font-display text-[var(--color-nav-text)]" aria-label="SimpleTimer home">{{ config('app.name', 'Simple') }}</a>
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
                                <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Start free trial') }}</a>
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
                        <span class="text-[var(--color-text)]">{{ __('For independent developers & consultants') }}</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-display mb-4 leading-[1.05]">
                        <span class="bg-gradient-to-br from-[var(--color-text)] via-[var(--color-text-secondary)] to-[var(--color-text)] bg-clip-text text-transparent">
                            {{ __('Know exactly what to invoice.') }}
                        </span>
                    </h1>

                    <p class="text-2xl sm:text-3xl font-display text-[var(--color-text-secondary)] leading-[1.25]">
                        <span class="text-orange-500">{{ __('Without another complicated app.') }}</span>
                    </p>

                    <div class="space-y-3">
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed">
                            {{ __('Simple time tracking for freelance developers and consultants who bill by the hour.') }}
                        </p>
                        <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed">
                            {{ __('Track client work, review your hours and billable totals, then export a report for your invoicing tool.') }}
                        </p>
                        <p class="text-base text-[var(--color-text-muted)]">
                            {{ __('An app that tracks time, not you. No screenshots, activity scores, or mouse tracking.') }}
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
                                    <span>{{ __('Start free trial') }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                                <a href="#demo" class="btn-secondary px-10 py-5 rounded-2xl text-center inline-flex items-center justify-center gap-2 text-base font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>{{ __('See how it works') }}</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                    <p class="text-sm text-[var(--color-text-muted)]">
                        {{ __(':days-day free trial, then :price/year.', ['days' => config('app.trial_period_days'), 'price' => config('app.yearly_price')]) }}
                    </p>
                </div>

                <div class="lg:col-span-6">
                    <div class="screenshot-container relative">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-20 blur-3xl"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-20 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="SimpleTimer dashboard with client work, tracked hours, and billable totals" class="marketing-screenshot relative z-10" width="1216" height="1199">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Video Section -->
    <section id="demo" class="py-24 bg-[var(--color-surface)]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-display mb-4 text-[var(--color-text)]">
                    {{ __('See It in Action') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)]">
                    {{ __('See how to track client work and find the totals for your next invoice.') }}
                </p>
            </div>
            <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl" style="padding-bottom: 56.25%;">
                <iframe
                    class="absolute inset-0 w-full h-full"
                    src="https://www.youtube.com/embed/iAdK0C3ZuuM"
                    title="SimpleTimer Demo"
                    loading="lazy"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>

    <!-- Target Audience Filter -->
    <section class="py-24 bg-[var(--color-bg)]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-2xl bg-[var(--color-primary-light)]">
                    <svg class="w-8 h-8 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-4xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Bill by the hour? Keep your time tracking simple.') }}
                </h2>
                <p class="text-xl text-[var(--color-text-secondary)] max-w-3xl mx-auto leading-relaxed">
                    {{ __('Built for solo developers and consultants who manage their own clients and already have an invoicing tool. No team management, employee monitoring, or accounting suite to learn.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-spacing bg-gradient-to-br from-[var(--color-bg)] to-[var(--color-surface)]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('One plan. Everything included.') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] max-w-2xl mx-auto leading-relaxed">
                    {{ __('Use SimpleTimer in your browser. We handle the hosting, so you can focus on client work.') }}
                </p>
            </div>

            <div class="max-w-xl mx-auto">
                <!-- Managed SaaS -->
                <div class="bg-[var(--color-surface)] rounded-3xl p-8 border-2 border-[var(--color-primary)] relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full text-xs font-semibold text-green-800 mb-6">
                            {{ __(':days-day free trial', ['days' => config('app.trial_period_days')]) }}
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-[var(--color-text)]">{{ __('Hosted for you') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-[var(--color-text)]">{{ config('app.yearly_price') }}</span>
                            <span class="text-[var(--color-text-secondary)]">/{{ __('year') }}</span>
                        </div>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __(':days-day free trial, then :price/year.', ['days' => config('app.trial_period_days'), 'price' => config('app.yearly_price')]) }}</p>
                        <p class="text-sm text-[var(--color-text-secondary)] mb-6">{{ __('Try it on real client work before deciding whether to subscribe.') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Unlimited clients & projects') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Timer, manual entries, hourly rates & reports') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('CSV exports for your invoicing workflow') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <x-icons.check class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" />
                                <span class="text-[var(--color-text)]">{{ __('Hosting included. No server to maintain.') }}</span>
                            </li>
                        </ul>

                        @auth
                            <a href="{{ route('dashboard') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">{{ __('Go to Dashboard') }}</a>
                        @else
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">{{ __('Start free trial') }}</a>
                            @endif
                        @endauth
                    </div>
                </div>
                <p class="text-center text-sm text-[var(--color-text-secondary)] mt-6">
                    {{ __('Prefer to self-host?') }}
                    <a href="https://github.com/jcergolj/simpletimer#readme" target="_blank" rel="noopener noreferrer" class="underline hover:text-[var(--color-primary)]">{{ __('Get the source code and self-host for free.') }}</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-spacing bg-[var(--color-surface)]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 text-[var(--color-text)]">
                    {{ __('From client work to invoice-ready totals') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] max-w-2xl mx-auto">
                    {{ __('Track your hours, keep client work organised, and use the totals in your existing invoicing tool.') }}
                </p>
            </div>

            <!-- Features Grid: 2x2 on desktop, stack on mobile -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20">
                <!-- Feature 1: Track Time Instantly -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/running-timer.png') }}" alt="Running timer with keyboard shortcuts" class="marketing-screenshot relative z-10" loading="lazy" width="1216" height="1065">
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
                            <span>{{ __('Add time manually when you forget the timer') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Feature 2: Reports That Get You Paid -->
                <div class="space-y-6">
                    <div class="screenshot-container relative mb-6">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-15 blur-3xl"></div>
                        <img src="{{ asset('screenshots/reports.png') }}" alt="CSV reports showing per-client totals" class="marketing-screenshot relative z-10" loading="lazy" width="1280" height="1158">
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
                        <img src="{{ asset('screenshots/start-tracking-with-new-client.png') }}" alt="Self-hosting privacy control" class="marketing-screenshot relative z-10" loading="lazy" width="1280" height="1046">
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
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Multi-currency client tracking" class="marketing-screenshot relative z-10" loading="lazy" width="1216" height="1199">
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
                    {{ __('Track your work. Check your totals. Get on with your day.') }}
                </p>
                <p class="text-lg text-[var(--color-text-muted)] leading-relaxed">
                    {{ __('SimpleTimer keeps time tracking separate from accounting, so you can keep the invoicing workflow you already use.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- MIT License Explainer Section -->
    <section class="section-spacing bg-[var(--color-surface)]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl sm:text-4xl font-display mb-6 text-[var(--color-text)]">
                    {{ __('Your time records stay yours') }}
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)] leading-relaxed mb-8">
                    {{ __('SimpleTimer is MIT licensed. You can use, modify, and distribute it, including commercially or as a hosted service. Self-host for free or use our managed version. Either way, your data is yours. You\'re never locked in.') }}
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
                    {{ __('A few things to know before you start.') }}
                </p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 - Moved to first (biggest misconception) -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Does SimpleTimer create invoices?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('No. It tracks your hours and billable totals, with CSV reports you can export. Use those totals to create invoices in your existing invoicing tool.') }}
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('How much does the hosted version cost?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __(':price per year, with all features and hosting included. Start with a :days-day free trial to see whether it fits your client work.', ['price' => config('app.yearly_price'), 'days' => config('app.trial_period_days')]) }}
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Do I need to set up a server?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('No. The hosted version runs in your browser, with no server setup. Self-hosting is an optional, free alternative if you prefer to manage your own installation.') }}
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-[var(--color-surface)] rounded-2xl p-8 border-2 border-[var(--color-border-light)] hover:border-[var(--color-primary)] transition-colors">
                    <h3 class="font-display text-xl mb-3 text-[var(--color-text)]">{{ __('Can I take my time records with me?') }}</h3>
                    <p class="text-[var(--color-text-secondary)] leading-relaxed">
                        {{ __('Yes. You can export your time reports as CSV files. The source code is also available if you want to self-host.') }}
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
                        {{ __('Simple time tracking for freelance developers and consultants. Track client work, see billable totals, and keep your existing invoicing tool.') }}
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
                            <span><a href="https://github.com/jcergolj/simpletimer/blob/master/LICENSE" target="_blank" rel="noopener noreferrer" class="hover:underline hover:text-green-700">MIT Licensed</a></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icons.check class="w-4 h-4 text-[var(--color-primary)]" />
                            <span>{{ __('Built with Laravel') }}</span>
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
