<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simple') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />
    <style>
        :root {
            --color-bg: #FAFBFC;
            --color-surface: #FFFFFF;
            --color-text: #1A1F36;
            --color-text-secondary: #697386;
            --color-text-muted: #9AA5B1;
            --color-border: #E3E8EE;
            --color-border-light: #F3F4F6;
            --color-primary: #0066FF;
            --color-primary-hover: #0052CC;
            --color-primary-light: #E6F0FF;
            --color-accent: #0066FF;
            --color-accent-hover: #0052CC;
            --color-accent-light: #E6F0FF;
            --color-success: #10B981;
            --color-success-light: #D1FAE5;
            --font-display: 'Manrope', sans-serif;
            --font-body: 'Manrope', sans-serif;
            --ease-smooth: cubic-bezier(0.4, 0.0, 0.2, 1);
            --ease-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-bg);
            color: var(--color-text);
        }

        .font-display {
            font-family: var(--font-display);
            letter-spacing: -0.02em;
            font-weight: 700;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(24px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s var(--ease-smooth) forwards;
            opacity: 0;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s var(--ease-smooth) forwards;
            opacity: 0;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.8s var(--ease-smooth) forwards;
            opacity: 0;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s var(--ease-smooth) forwards;
            opacity: 0;
        }

        .animate-scale-in {
            animation: scaleIn 0.7s var(--ease-smooth) forwards;
            opacity: 0;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }
        .stagger-7 { animation-delay: 0.7s; }
        .stagger-8 { animation-delay: 0.8s; }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--color-accent), var(--color-accent-hover));
            color: white;
            transition: all 0.3s var(--ease-smooth);
            border: none;
            box-shadow: 0 2px 8px rgba(0, 102, 255, 0.25), 0 1px 2px rgba(0, 102, 255, 0.15);
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s var(--ease-smooth);
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 102, 255, 0.35), 0 4px 8px rgba(0, 102, 255, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0) scale(1);
        }

        .btn-secondary {
            border: 2px solid var(--color-border);
            color: var(--color-text);
            background: var(--color-surface);
            transition: all 0.3s var(--ease-smooth);
            font-weight: 600;
        }

        .btn-secondary:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.1);
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        /* Card Styles */
        .feature-card {
            transition: all 0.4s var(--ease-smooth);
            position: relative;
            background: var(--color-surface);
            border: 2px solid var(--color-border-light);
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--color-primary-light), transparent);
            opacity: 0;
            transition: opacity 0.4s var(--ease-smooth);
        }

        .feature-card:hover::before {
            opacity: 0.5;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.12), 0 4px 8px rgba(0, 0, 0, 0.05);
            border-color: var(--color-primary);
        }

        .screenshot-container {
            border: 2px solid var(--color-border);
            border-radius: 16px;
            overflow: hidden;
            background: var(--color-surface);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06), 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: all 0.5s var(--ease-smooth);
            position: relative;
        }

        .screenshot-container::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s var(--ease-smooth);
            pointer-events: none;
        }

        .screenshot-container:hover::after {
            opacity: 1;
        }

        .screenshot-container:hover {
            box-shadow: 0 20px 48px rgba(37, 99, 235, 0.15), 0 8px 16px rgba(0, 0, 0, 0.08);
            transform: translateY(-8px) scale(1.02);
            border-color: var(--color-primary);
        }

        .screenshot-container img {
            transition: transform 0.5s var(--ease-smooth);
        }

        .screenshot-container:hover img {
            transform: scale(1.03);
        }

        .badge {
            background: linear-gradient(135deg, var(--color-success-light), var(--color-primary-light));
            border: none;
            border-radius: 100px;
            padding: 8px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s var(--ease-smooth);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
        }

        .badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .accent-dot {
            width: 10px;
            height: 10px;
            background: var(--color-success);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2.5s ease-in-out infinite;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }

        /* Background Elements */
        .gradient-bg {
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: -10%;
            right: 5%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 65%);
            pointer-events: none;
            animation: float 8s ease-in-out infinite;
            border-radius: 50%;
        }

        .gradient-bg::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: 5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.06) 0%, transparent 65%);
            pointer-events: none;
            animation: float 10s ease-in-out infinite reverse;
            border-radius: 50%;
        }

        .geometric-accent {
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }

        .geometric-accent.circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary-light), var(--color-accent-light));
            opacity: 0.4;
            filter: blur(20px);
        }

        .geometric-accent.square {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--color-accent-light), var(--color-success-light));
            opacity: 0.3;
            transform: rotate(45deg);
            filter: blur(25px);
        }

        .section-spacing {
            padding: 120px 0;
        }

        @media (max-width: 768px) {
            .section-spacing {
                padding: 80px 0;
            }
        }

        /* Navigation Enhancement */
        nav {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid var(--color-border-light);
        }

        /* Link Styles */
        a.link-hover {
            position: relative;
            transition: color 0.3s var(--ease-smooth);
        }

        a.link-hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: currentColor;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s var(--ease-smooth);
        }

        a.link-hover:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="sticky top-0 z-50 animate-fade-in">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-16">
                        <h1 class="text-xl font-display text-gray-900">{{ config('app.name', 'Simple') }}</h1>
                        <div class="hidden md:flex items-center gap-8">
                            <a href="#features" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors link-hover">{{ __('Features') }}</a>
                            <a href="#pricing" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors link-hover">{{ __('Pricing') }}</a>
                            <a href="#faq" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors link-hover">{{ __('FAQ') }}</a>
                            <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors group">
                                <svg class="h-5 w-5 transform group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                                <span class="link-hover">GitHub</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Dashboard') }}</a>
                        @else
                            @if (!\App\Facades\TenantDatabaseServiceFacade::isMainDomain(request()) || Config::get('app.single_user_mode')) 
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors hidden sm:inline-block link-hover">{{ __('Log in') }}</a>
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
        <div class="geometric-accent circle animate-float" style="top: 20%; right: 15%;"></div>
        <div class="geometric-accent square animate-float" style="bottom: 30%; left: 10%; animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                <div class="lg:col-span-6 space-y-8">
                    <div class="badge animate-scale-in stagger-1">
                        <span class="accent-dot"></span>
                        <span class="text-gray-800">Open Source • <a href="https://osaasy.dev/" target="_blank" rel="noopener noreferrer" class="hover:underline">O'Saasy Licensed</a></span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-display mb-4 leading-[1.05] animate-fade-in-up stagger-2">
                        <span class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent">
                            {{ __('SimpleTimer') }}
                        </span>
                    </h1>

                    <p class="text-2xl sm:text-3xl font-display text-gray-600 leading-[1.25] animate-fade-in-up stagger-3">
                        {{ __('Don\'t waste') }}
                        <span class="text-blue-600">{{ __('time') }}</span>
                        <span class="text-orange-500">{{ __('tracking') }}</span>
                        <span class="text-blue-600">{{ __('time') }}</span>
                    </p>

                    <p class="text-base text-gray-600 leading-relaxed max-w-lg animate-fade-in-up stagger-4">
                        {{ __('The fastest way to track billable hours. One-click timer. Client tracking. Reports. CSV export. Zero bloat.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up stagger-5">
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

                    <a href="https://github.com/jcergolj/simpletime#readme" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors group animate-fade-in-up stagger-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="link-hover">{{ __('View Installation Guide') }}</span>
                    </a>
                </div>

                <div class="lg:col-span-6 animate-slide-in-right stagger-4">
                    <div class="screenshot-container relative">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-20 blur-3xl"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-20 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Dashboard preview" class="w-full h-auto relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Audience -->
    <section class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-display mb-4 text-gray-900">
                    {{ __('Built for Solo Freelancers & Developers') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('If you bill by the hour and value simplicity, this is for you:') }}
                </p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-lg text-gray-700">{{ __('Freelancers tracking multiple clients across projects') }}</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-lg text-gray-700">{{ __('Developers who want privacy and full data control') }}</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-lg text-gray-700">{{ __('Consultants billing in multiple currencies') }}</p>
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

    <section id="pricing" class="section-spacing bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-display mb-6 text-gray-900">
                    {{ __('Simple, Honest Pricing') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('No hidden fees. No complicated tiers. Just straightforward time tracking that respects your time and your budget.') }}
                </p>
            </div>

            <!-- Early Adopter Banner -->
            @if($remainingSlots > 0)
                <div class="max-w-3xl mx-auto mb-12 animate-fade-in-up">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 text-center">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-4 py-1.5 rounded-full text-sm font-semibold text-green-800 mb-3">
                            🎉 {{ __('Early Adopter Offer') }}
                        </div>
                        <p class="text-2xl font-display text-gray-900 mb-2">
                            {{ $remainingSlots }} {{ __('of 10 lifetime free spots remaining') }}
                        </p>
                        <p class="text-gray-600">
                            {{ __('Be one of the first 10 users and get free access forever. No credit card. No catch.') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Early Adopter Plan -->
                <div class="bg-white rounded-3xl p-8 border-2 @if($remainingSlots > 0) border-green-500 @else border-gray-200 @endif relative overflow-hidden transform transition-all hover:scale-105">
                    @if($remainingSlots > 0)
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-200 rounded-full opacity-50 blur-2xl"></div>
                    @endif

                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full text-xs font-semibold text-green-800 mb-6">
                            @if($remainingSlots > 0) {{ __('Limited Offer') }} @else {{ __('Sold Out') }} @endif
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-gray-900">{{ __('First 10 Users') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-gray-900">{{ __('Free') }}</span>
                            <span class="text-gray-600"> {{ __('forever') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">{{ __('Lifetime access, zero cost') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('All core features included') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Regular updates') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Data export anytime') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Community support') }}</span>
                            </li>
                        </ul>

                        <p class="text-xs text-gray-500 mb-6">{{ __('* No priority support') }}</p>

                        @if($remainingSlots > 0)
                            <a href="{{ route('register') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">
                                {{ __('Claim Your Spot') }}
                            </a>
                        @else
                            <div class="block text-center bg-gray-100 px-6 py-3 rounded-xl text-sm font-semibold text-gray-500">
                                {{ __('No Spots Available') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- d Plan -->
                <div class="bg-white rounded-3xl p-8 border-2 @if($remainingSlots == 0) border-blue-500 @else border-gray-200 @endif relative overflow-hidden transform transition-all hover:scale-105">
                    @if($remainingSlots == 0)
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-50 blur-2xl"></div>
                    @endif

                    <div class="relative z-10">
                        <h3 class="text-2xl font-display mb-2 text-gray-900">{{ __('Standard Plan') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-gray-900">{{ config('app.yearly_price') }}</span>
                            <span class="text-gray-600">/{{ __('year') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">{{ __('Try free for :days days', ['days' => config('app.trial_period_days')]) }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Everything in Early Adopter') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ config('app.trial_period_days') }} - {{ __('days free trial') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ config('app.refund_period_days') }} - {{ __('day money-back guarantee') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Cancel anytime') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('No credit card required') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Unlimited clients & projects') }}</span>
                            </li>
                        </ul>

                        <a href="{{ route('register') }}" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">
                            {{ __('Start Free Trial') }}
                        </a>
                    </div>
                </div>

                <!-- Self-Hosted -->
                <div class="bg-white rounded-3xl p-8 border-2 border-gray-200 relative overflow-hidden transform transition-all hover:scale-105">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-xs font-semibold text-gray-700 mb-6">
                            {{ __('Open Source') }}
                        </div>

                        <h3 class="text-2xl font-display mb-2 text-gray-900">{{ __('Self-Hosted') }}</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-display text-gray-900">{{ __('Free') }}</span>
                            <span class="text-gray-600"> {{ __('forever') }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">{{ __('Host it yourself') }}</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Full source code access') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('O\'Saasy licensed') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Deploy on your server') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Complete data control') }}</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Community support') }}</span>
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
    <section id="features" class="section-spacing bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 text-gray-900">
                    {{ __('Everything You Need to Track Time') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('Dead simple timer. Client management. Reports. That\'s it.') }}
                </p>
            </div>

            <div class="space-y-32">
                <!-- Feature 1: Track Time In Seconds -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-7 lg:pr-16 animate-slide-in-left space-y-6">
                        <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ __('Tracking') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Track Time') }}
                            <span class="text-blue-600">{{ __('In Seconds') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            {{ __('Hit Ctrl+Shift+S to start. Ctrl+Shift+T to stop. One click starts your timer. One click stops it. No bloat, no BS.') }}
                        </p>
                    </div>

                    <div class="lg:col-span-5 animate-slide-in-right">
                        <div class="screenshot-container relative">
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/running-timer.png') }}" alt="Active timer showing elapsed time and project details" class="w-full h-auto relative z-10">
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Organize Work Effortlessly -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1 animate-slide-in-left">
                        <div class="screenshot-container relative">
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/start-tracking-with-new-client.png') }}" alt="Creating a new client while starting timer" class="w-full h-auto relative z-10">
                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 lg:pl-16 animate-slide-in-right space-y-6">
                        <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>{{ __('Organization') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Organize Your Work') }}
                            <span class="text-orange-600">{{ __('Effortlessly') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            {{ __('Create clients on-the-fly while starting timers. Set rates once, track forever. Track London clients at £75/hr and NYC projects at $100/hr. 56 currencies built in.') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 3: Reports That Pay You -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-7 lg:pr-16 animate-slide-in-left space-y-6">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ __('Reporting') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Reports That') }}
                            <span class="text-green-600">{{ __('Get You Paid') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            {{ __('Filter by client. Export to CSV. Attach to invoice. Get paid. Export clean CSVs for invoicing. The entire workflow in 30 seconds.') }}
                        </p>
                    </div>

                    <div class="lg:col-span-5 animate-slide-in-right">
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
    <section id="faq" class="py-24 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-display mb-4 text-gray-900">
                    {{ __('Questions?') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ __('Here\'s what freelancers usually ask:') }}
                </p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Is it really free forever?') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Yes. O\'Saasy license means free self-hosting forever. We reserve rights to offer a managed SaaS version, but the open-source stays free.') }}
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('What happens after the trial?') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Your trial lasts :days full days. If you continue, pay :yearly_price/year. If not, let it expire—no charges, no questions.', ['days' => config('app.trial_period_days'), 'yearly_price' => config('app.yearly_price')]) }}
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('How hard is self-hosting?') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Works on DigitalOcean ($5/mo), Vultr, Linode. Install time: 15 minutes. Requirements: PHP 8.4 + Git. Managed option: Laravel Forge ($12/mo).') }}
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('What if I break it?') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Support via GitHub issues. Active community. Common fixes in README.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-white to-gray-50 border-t-2 border-blue-100 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <h3 class="font-display text-2xl mb-4 text-gray-900">{{ config('app.name', 'Simple Timer') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-6 max-w-md">
                        {{ __('A simple time tracking web app for developers and freelancers who value simplicity and privacy.') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-900 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-display text-sm font-bold text-gray-900 mb-5 uppercase tracking-wider">{{ __('Resources') }}</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="https://github.com/jcergolj/simpletime" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('GitHub Repository') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime#readme" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Documentation') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime/issues" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
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
                    <h4 class="font-display text-sm font-bold text-gray-900 mb-5 uppercase tracking-wider">{{ __('Project') }}</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><a href="https://osaasy.dev/" target="_blank" rel="noopener noreferrer" class="hover:underline hover:text-green-700">O'Saasy Licensed</a></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Built with Laravel 12') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Self-Hosted') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t-2 border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">
                        © {{ date('Y') }} <span class="font-semibold text-gray-700">{{ config('app.name', 'Simple') }}</span>. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
