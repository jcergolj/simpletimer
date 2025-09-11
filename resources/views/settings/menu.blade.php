<x-layouts.app :title="__('Profile & Settings')">
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <x-settings.page-header
            :title="__('Profile & Settings')"
            :description="__('Manage your account settings and preferences')"
        />

        <!-- Settings Menu -->
        <div class="card divide-y" style="border-color: var(--color-border);">
            <x-settings.menu-item
                route="settings.profile.edit"
                icon="user"
                :title="__('Edit Profile')"
                :description="__('Update your name and email address')"
            />

            <x-settings.menu-item
                route="settings.preferences.edit"
                icon="cog-6-tooth"
                :title="__('Preferences')"
                :description="__('Customize defaults and display settings')"
            />

            <x-settings.menu-item
                route="settings.password.edit"
                icon="key"
                :title="__('Change Password')"
                :description="__('Update your account password')"
            />

            <a href="{{ route('settings.database-backup.download') }}" class="flex items-center px-6 py-4 transition-colors hover:bg-[var(--color-bg)]">
                <div class="flex-shrink-0">
                    <x-heroicon-o-arrow-down-tray class="h-6 w-6" style="color: var(--color-primary);" />
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium" style="color: var(--color-text);">{{ __('Download Database Backup') }}</h3>
                    <p class="text-sm" style="color: var(--color-text-secondary);">{{ __('Download a copy of your database (.sqlite file)') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <x-heroicon-o-chevron-right class="h-5 w-5" style="color: var(--color-text-muted);" />
                </div>
            </a>

            <a href="{{ route('settings.profile.delete') }}" class="flex items-center px-6 py-4 transition-colors hover:bg-[var(--color-danger-light)]">
                <div class="flex-shrink-0">
                    <x-heroicon-o-trash class="h-6 w-6" style="color: var(--color-danger);" />
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium" style="color: var(--color-danger);">{{ __('Delete Account') }}</h3>
                    <p class="text-sm" style="color: var(--color-danger); opacity: 0.7;">{{ __('Permanently delete your account and data') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <x-heroicon-o-chevron-right class="h-5 w-5" style="color: var(--color-text-muted);" />
                </div>
            </a>
        </div>

        <!-- Logout Button -->
        <div class="mt-8">
            <form action="{{ route('logout') }}" method="post" id="settings-logout" data-turbo-action="replace">
                @csrf
                <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 py-3 px-6 rounded-lg">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 flex-shrink-0" />
                    <span>{{ __('Logout') }}</span>
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
