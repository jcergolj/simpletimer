<x-layouts.app :title="__('Clients')">
    <div class="space-y-8" data-controller="inline-edit">
        <!-- Page Header -->
        <x-page-header title="Clients" subtitle="Manage your clients and their hourly rates" />

        <!-- Search Filter -->
        <div class="card card-padded mx-4 sm:mx-0">
            <h3 class="section-heading">{{ __('Search Clients') }}</h3>
            <form method="GET" action="{{ route('clients.index') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="label">{{ __('Search by name') }}</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Enter client name...') }}"
                               class="input-field">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <x-icon-button>
                            <x-slot:icon>
                                <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </x-slot:icon>
                            {{ __('Search') }}
                        </x-icon-button>
                        @if(request('search'))
                            <a href="{{ route('clients.index') }}" class="btn-link">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Client Section -->
        <div class="card card-padded mx-4 sm:mx-0">
            <turbo-frame id="client-create-form">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <h2 class="card-heading">{{ __('Add New Client') }}</h2>
                        <p class="card-description">{{ __('Create a new client profile with billing information') }}</p>
                    </div>
                    <x-icon-link :href="route('clients.create')">
                        {{ __('Add Client') }}
                    </x-icon-link>
                </div>
            </turbo-frame>
        </div>

        <!-- Clients List -->
        <turbo-frame id="clients-lists">
            @include('turbo::clients.list', ['clients' => $clients])
        </turbo-frame>
    </div>
</x-layouts.app>
