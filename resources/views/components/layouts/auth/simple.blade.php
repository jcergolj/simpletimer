@props(['transitions' => true, 'scalable' => false, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', [
            'transitions' => $transitions,
            'scalable' => $scalable,
            'title' => $title,
        ])
    </head>
    <body @class(["min-h-screen antialiased", "hotwire-native" => Turbo::isHotwireNativeVisit()]) style="background: var(--color-bg);">
        <div class="flex min-h-screen flex-col items-center justify-center px-2 py-12">
            <x-in-app-notifications::notification />

            <div class="w-full max-w-lg px-4">
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center group">
                        <div class="auth-logo-icon">
                            <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="font-display text-xl" style="color: var(--color-text);">{{ config('app.name', 'SimpleTime') }}</span>
                    </a>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
