<x-layouts.app :title="__('Profile')">
    <div class="max-w-2xl mx-auto">
        <!-- Back Link -->
        <x-settings.back-link route="settings" text="Back to Settings" />

        <!-- Page Header -->
        <x-settings.page-header
            :title="__('Edit Profile')"
            :description="__('Update your personal information')"
        />

        <!-- Form -->
        <div class="card p-6">
            <form action="{{ route('settings.profile.update') }}" method="post" class="space-y-6" data-controller="bridge--form" data-action="turbo:submit-start->bridge--form#submitStart turbo:submit-end->bridge--form#submitEnd">
                @csrf
                @method('put')

                <!-- Username (Read-only) -->
                <div>
                    <label for="username" class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Username') }}</label>
                    <x-form.text-input
                        id="username"
                        name="username"
                        :value="$username"
                        disabled
                        class="bg-[var(--color-bg)]"
                    />
                    <p class="mt-1 text-sm" style="color: var(--color-text-muted);">{{ __('Username cannot be changed') }}</p>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Email address') }}</label>
                    <x-form.text-input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email', $email)"
                        :data-error="$errors->has('email')"
                        required
                        autocomplete="email"
                        :placeholder="__('email@example.com')"
                    />
                    <x-form.error for="email" />
                </div>

                <div class="flex justify-end">
                    <x-form.button.primary type="submit" data-bridge--form-target="submit" data-bridge-title="{{ __('Save') }}">
                        {{ __('Save Changes') }}
                    </x-form.button.primary>
                </div>
            </form>
        </div>

        <form action="{{ route('verification.resend') }}" method="post" id="resend-email-verification">
            @csrf
        </form>
    </div>
</x-layouts.app>
