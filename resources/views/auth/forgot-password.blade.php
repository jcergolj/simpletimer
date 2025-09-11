<x-layouts.auth :title="__('Forgot Password')">
    <div>
        <div class="text-center mb-10">
            <h2 class="font-display text-[32px] text-[var(--color-text)] mb-2">{{ __('Forgot Password?') }}</h2>
            <p class="text-base text-[var(--color-text-secondary)]">{{ __('Enter your email address and we\'ll send you a password reset link') }}</p>
        </div>

        <form action="{{ route('password.email') }}" method="post" class="space-y-6" data-turbo-action="replace">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label class="label" for="email">
                    {{ __('Email address') }}
                </label>
                <x-form.text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    :data-error="$errors->has('email')"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />
                <x-form.error for="email" />
            </div>

            <div class="pt-4">
                <x-form.button.primary type="submit" class="w-full">
                    {{ __('Send Reset Link') }}
                </x-form.button.primary>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-[var(--accent)] hover:underline">
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</x-layouts.auth>
