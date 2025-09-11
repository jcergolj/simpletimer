<x-layouts.app :title="__('Preferences')">
    <div class="max-w-2xl mx-auto">
        <!-- Back Link -->
        <x-settings.back-link route="settings" text="Back to Settings" />

        <!-- Page Header -->
        <x-settings.page-header
            :title="__('Preferences')"
            :description="__('Customize your application settings and display preferences')"
        />

        <!-- Form -->
        <div class="card p-6">
            <form action="{{ route('settings.preferences.update') }}" method="post" class="space-y-6" data-controller="bridge--form" data-action="turbo:submit-start->bridge--form#submitStart turbo:submit-end->bridge--form#submitEnd">
                @csrf
                @method('put')

                <!-- Date Format -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Date Format') }}</label>
                    <div class="space-y-2">
                        @foreach($dateFormatOptions as $value => $label)
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="date_format"
                                    value="{{ $value }}"
                                    class="h-4 w-4 focus:ring-[var(--color-primary)]"
                                    style="accent-color: var(--color-primary);"
                                    @checked(old('date_format', $dateFormat->value) === $value)
                                    required
                                >
                                <span class="ml-2 text-sm" style="color: var(--color-text);">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-1">
                        <p class="text-sm" style="color: var(--color-text-secondary);">{{ __('Choose how dates are displayed throughout the application.') }}</p>
                    </div>
                    <x-form.error for="date_format" />
                </div>

                <!-- Time Format -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Time Format') }}</label>
                    <div class="space-y-2">
                        @foreach($timeFormatOptions as $value => $label)
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="time_format"
                                    value="{{ $value }}"
                                    class="h-4 w-4 focus:ring-[var(--color-primary)]"
                                    style="accent-color: var(--color-primary);"
                                    @checked(old('time_format', $timeFormat->value) === $value)
                                    required
                                >
                                <span class="ml-2 text-sm" style="color: var(--color-text);">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-1">
                        <p class="text-sm" style="color: var(--color-text-secondary);">{{ __('Choose between 12-hour (with AM/PM) or 24-hour time format.') }}</p>
                    </div>
                    <x-form.error for="time_format" />
                </div>

                <!-- Hourly Rate -->
                <div>
                    <label for="hourly_rate_amount" class="block text-sm font-medium mb-2" style="color: var(--color-text);">{{ __('Default Hourly Rate') }}</label>
                    <x-form.hourly-rate />
                    <div class="mt-1">
                        <p class="text-sm" style="color: var(--color-text-secondary);">{{ __('This will be used as the default rate for new clients and projects.') }}</p>
                    </div>
                    <x-form.error for="hourly_rate.amount" />
                    <x-form.error for="hourly_rate.currency" />
                </div>

                <div class="flex justify-end">
                    <x-form.button.primary type="submit" data-bridge--form-target="submit" data-bridge-title="{{ __('Save') }}">
                        {{ __('Save Changes') }}
                    </x-form.button.primary>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
