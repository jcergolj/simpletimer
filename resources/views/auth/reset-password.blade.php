<x-layouts.auth :title="__('Reset Password')">
    <div>
        <div class="text-center mb-10">
            <h2 class="font-display text-[32px] text-[var(--color-text)] mb-2">{{ __('Reset Password') }}</h2>
            <p class="text-base text-[var(--color-text-secondary)]">{{ __('Enter your new password') }}</p>
        </div>

        <form action="{{ Request::fullUrl() }}" method="post" class="space-y-6" data-turbo-action="replace">
            @csrf

            <!-- Email (read-only, from signed URL) -->
            <div class="space-y-2">
                <label class="label" for="email">
                    {{ __('Email address') }}
                </label>
                <x-form.text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email', $email)"
                    :data-error="$errors->has('email')"
                    required
                    readonly
                    autocomplete="email"
                    placeholder="email@example.com"
                />
                <x-form.error for="email" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label class="label" for="password">
                    {{ __('Password') }}
                </label>
                <x-form.password-input
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                />
                <x-form.error for="password" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label class="label" for="password_confirmation">
                    {{ __('Confirm Password') }}
                </label>
                <x-form.password-input
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm Password')"
                />
                <x-form.error for="password_confirmation" />
            </div>

            <div class="pt-4">
                <x-form.button.primary type="submit" class="w-full">
                    {{ __('Reset Password') }}
                </x-form.button.primary>
            </div>
        </form>
    </div>
</x-layouts.auth>
