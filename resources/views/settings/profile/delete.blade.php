<x-layouts.app :title="__('Delete profile')">
    <div class="max-w-2xl mx-auto">
        <!-- Back Link -->
        <x-settings.back-link route="settings" text="Back to Settings" />

        <!-- Page Header -->
        <div class="text-center py-4 mb-8">
            <h1 class="text-3xl font-bold mb-2" style="color: var(--color-danger);">{{ __('Delete Account') }}</h1>
            <p style="color: var(--color-text-secondary);">{{ __('Delete your account and all of its resources') }}</p>
        </div>

        <!-- Warning Card -->
        <div class="rounded-lg p-6 mb-6" style="background: var(--color-danger-light); border: 1px solid var(--color-danger);">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6" style="color: var(--color-danger);" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium" style="color: var(--color-danger);">
                        {{ __('This action cannot be undone') }}
                    </h3>
                    <p class="mt-2 text-sm" style="color: var(--color-danger); opacity: 0.9;">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card p-6">
            <form action="{{ route('settings.profile.destroy') }}" method="post" class="space-y-6" data-controller="bridge--form" data-action="turbo:submit-start->bridge--form#submitStart turbo:submit-end->bridge--form#submitEnd">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="password" class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Current password') }}</label>
                    <x-form.password-input
                        id="password"
                        type="password"
                        name="password"
                        :data-error="$errors->has('password')"
                        required
                        autofocus
                        autocomplete="current-password"
                        :placeholder="__('Enter your current password')"
                    />
                    <x-form.error for="password" />
                </div>

                <div class="flex justify-end">
                    <x-form.button.danger type="submit" data-bridge--form-target="submit" data-bridge-title="{{ __('Delete') }}" data-bridge-destructive="true">
                        {{ __('Delete Account Permanently') }}
                    </x-form.button.danger>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
