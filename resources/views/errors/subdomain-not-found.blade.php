<x-layouts.auth :title="__('Subdomain Not Found')">
    <div class="text-center">
        <div class="mb-8">
            <svg class="mx-auto h-16 w-16 text-[var(--color-text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="font-display text-[32px] text-[var(--color-text)] mb-3">Subdomain Not Found</h2>

        <p class="text-base text-[var(--color-text-secondary)] mb-2">
            The subdomain <strong class="text-[var(--color-text)]">{{ $subdomain }}</strong> doesn't have an account yet.
        </p>

        <p class="text-sm text-[var(--color-text-secondary)] mb-8">
            This subdomain is either unclaimed or the account doesn't exist.
        </p>

        <div class="space-y-4">
            <a href="{{ $mainUrl }}/register" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-[var(--accent)] rounded-[10px] hover:bg-[var(--accent-hover)] transition-colors">
                {{ __('Create Account') }}
            </a>

            <a href="{{ $mainUrl }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-[var(--color-text)] bg-transparent border-[1.5px] border-[var(--border)] rounded-[10px] hover:bg-[var(--bg-secondary)] transition-colors">
                {{ __('Go to Main Page') }}
            </a>
        </div>
    </div>
</x-layouts.auth>
