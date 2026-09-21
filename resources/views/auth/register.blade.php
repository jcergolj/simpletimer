<x-layouts.auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Start tracking in under 30 seconds')" :description="__('Create your account and start tracking client work quickly.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form action="{{ route('register.store') }}" method="post" class="flex flex-col gap-6" data-turbo="false">
            @csrf

            <!-- Username / domain -->
            <div data-controller="subdomain-preview">
                <x-form.label for="username">{{ __('Choose your username') }}</x-form.label>

                <x-form.text-input id="username" name="username" :value="old('username')" :data-error="$errors->has('username')" required autofocus
                    autocomplete="username" :placeholder="__('username')" class="mt-2"
                    data-subdomain-preview-target="input"
                    data-action="input->subdomain-preview#updatePreview" />

                <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
                    {{ __('Your workspace URL will be:') }} <strong data-subdomain-preview-target="preview">username</strong>.{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                </p>

                <x-form.error for="username" />
            </div>

            <!-- Email -->
            <div>
                <x-form.label for="email">{{ __('Email address') }}</x-form.label>

                <x-form.text-input id="email" name="email" type="email" :value="old('email')" :data-error="$errors->has('email')"
                    required autocomplete="email" :placeholder="__('email@example.com')" class="mt-2" />

                <x-form.error for="email" />
            </div>

            <!-- Password -->
            <div>
                <x-form.label for="password">{{ __('Password') }}</x-form.label>

                <x-form.password-input id="password" name="password" :data-error="$errors->has('password')" required
                    autocomplete="new-password" :placeholder="__('Password')" class="mt-2" />

                <x-form.error for="password" />
            </div>

            <!-- Confirm password -->
            <div>
                <x-form.label for="password_confirmation">{{ __('Confirm password') }}</x-form.label>

                <x-form.password-input id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password" :placeholder="__('Confirm password')" class="mt-2" />

                <x-form.error for="password_confirmation" />
            </div>

            <div class="flex items-center justify-end">
                <x-form.button.primary type="submit" class="w-full">{{ __('Create account and start tracking') }}</x-form.button.primary>
            </div>
        </form>
    </div>
</x-layouts.auth>
