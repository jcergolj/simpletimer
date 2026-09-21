@props(['title', 'description', 'canonical'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ asset('screenshots/dashboard.png') }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <link href="{{ tailwindcss('css/app.css') }}@tailwindcssVersion" rel="stylesheet" data-turbo-track="reload">
</head>
<body class="min-h-screen bg-[var(--color-bg)]">
    <nav class="app-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-10">
                    <a href="{{ route('home') }}" class="text-xl font-display text-[var(--color-nav-text)]" aria-label="SimpleTimer home">
                        {{ config('app.name', 'SimpleTimer') }}
                    </a>
                    <div class="hidden lg:flex items-center gap-5">
                        <a href="{{ route('marketing.simple-time-tracker') }}" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('Simple tracker') }}</a>
                        <a href="{{ route('marketing.time-tracker-for-freelancers') }}" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('For freelancers') }}</a>
                        <a href="{{ route('marketing.time-tracker-for-virtual-assistants') }}" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('For virtual assistants') }}</a>
                        <a href="{{ route('marketing.privacy-friendly-time-tracking') }}" class="nav-item text-sm font-medium px-3 py-2 rounded-lg">{{ __('Privacy') }}</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary px-4 py-2.5 rounded-xl text-xs sm:px-6 sm:text-sm">{{ __('Try SimpleTimer') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>{{ $slot }}</main>

    <footer class="bg-gradient-to-b from-[var(--color-surface)] to-[var(--color-bg)] border-t-2 border-[var(--color-border-light)] py-14">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <a href="{{ route('home') }}" class="font-display text-2xl text-[var(--color-text)]">{{ config('app.name', 'SimpleTimer') }}</a>
                <p class="mt-3 text-[var(--color-text-secondary)]">{{ __('An app that tracks time, not you.') }}</p>
            </div>
            <div>
                <h2 class="font-display text-sm uppercase tracking-wider mb-4">{{ __('Time tracking') }}</h2>
                <ul class="space-y-2 text-[var(--color-text-secondary)]">
                    <li><a class="hover:text-[var(--color-primary)]" href="{{ route('marketing.simple-time-tracker') }}">{{ __('Simple time tracker') }}</a></li>
                    <li><a class="hover:text-[var(--color-primary)]" href="{{ route('marketing.project-time-tracking') }}">{{ __('Project time tracking') }}</a></li>
                    <li><a class="hover:text-[var(--color-primary)]" href="{{ route('marketing.privacy-friendly-time-tracking') }}">{{ __('Privacy-friendly time tracking') }}</a></li>
                </ul>
            </div>
            <div>
                <h2 class="font-display text-sm uppercase tracking-wider mb-4">{{ __('Who it is for') }}</h2>
                <ul class="space-y-2 text-[var(--color-text-secondary)]">
                    <li><a class="hover:text-[var(--color-primary)]" href="{{ route('marketing.time-tracker-for-freelancers') }}">{{ __('Freelancers') }}</a></li>
                    <li><a class="hover:text-[var(--color-primary)]" href="{{ route('marketing.time-tracker-for-small-business') }}">{{ __('Small businesses') }}</a></li>
                    <li><a class="hover:text-[var(--color-primary)]" href="https://github.com/jcergolj/simpletimer">{{ __('Self-host on GitHub') }}</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
