@props(['entry', 'runningTimer' => null])

<turbo-frame id="time-entry-{{ $entry->id }}">
    <div class="px-4 sm:px-8 py-4 sm:py-6 hover:bg-gray-50 transition-colors group">
        <!-- Mobile Layout (sm and below) -->
        <div class="sm:hidden">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-base text-gray-900 truncate">
                        {{ $entry->client->name ?? __('No Client') }}
                    </h4>
                    @if($entry->project)
                        <p class="text-sm text-gray-500 truncate">{{ $entry->project->name }}</p>
                    @endif
                </div>
                @if($entry->duration)
                    <div class="text-right ml-3">
                        <div class="text-lg font-mono font-bold text-gray-900">
                            {{ $entry->formattedDuration }}
                        </div>
                        @if($entry->calculateEarnings())
                            <div class="text-xs text-gray-600">
                                {{ $entry->calculateEarnings()->formatted() }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Time info row -->
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mb-3 text-xs text-gray-600">
                <div class="flex items-center">
                    <x-icons.clock class="h-3 w-3 mr-1" />
                    <span>
                        <x-user-datetime :datetime="$entry->start_time" />
                        @if($entry->end_time)
                            - <x-user-time :time="$entry->end_time" />
                        @endif
                    </span>
                </div>
                
                @if($entry->getEffectiveHourlyRate())
                    <div class="flex items-center text-blue-600">
                        <span class="font-medium">{{ $entry->getEffectiveHourlyRate()->formatted() }}/hr</span>
                    </div>
                @endif
            </div>
            
            @if($entry->notes)
                <div class="mb-3">
                    <p class="text-sm text-gray-500 line-clamp-2">{{ $entry->notes }}</p>
                </div>
            @endif
            
            <!-- Action buttons -->
            <div class="flex flex-wrap gap-2">
                @if(!$entry->end_time)
                    <x-running-status-badge size="sm" />
                @elseif($runningTimer)
                    <button type="button"
                            disabled
                            class="bg-gray-100 text-gray-400 px-2 py-1 h-7 rounded text-xs font-medium cursor-not-allowed inline-flex items-center space-x-1"
                            title="{{ __('Another timer is running') }}">
                        <x-icons.play-circle class="h-3 w-3" />
                        <span>{{ __('Start') }}</span>
                    </button>
                @else
                    <form action="{{ route('running-timer-session.store') }}" method="POST" data-turbo-frame="_top" class="inline">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $entry->client_id }}">
                        <input type="hidden" name="project_id" value="{{ $entry->project_id }}">
                        <button type="submit"
                                class="btn-action-start px-2 py-1 h-7 rounded-lg text-xs inline-flex items-center space-x-1">
                            <x-icons.play-circle class="h-3 w-3" />
                            <span>{{ __('Start') }}</span>
                        </button>
                    </form>
                @endif

                @if($entry->end_time)
                    <a href="{{ route('time-entries.edit', ['timeEntry' => $entry, 'is_recent' => true]) }}"
                       class="btn-action-edit px-2 py-1 h-7 rounded text-xs inline-flex items-center space-x-1"
                       data-turbo-frame="time-entry-{{ $entry->id }}">
                        <x-icons.edit class="h-3 w-3" />
                        <span>{{ __('Edit') }}</span>
                    </a>
                @endif

                <a href="{{ route('time-entries.destroy', ['timeEntry' => $entry, 'is_recent' => true]) }}"
                   data-turbo-method="delete"
                   data-turbo-confirm="{{ __('Are you sure you want to delete this time entry?') }}"
                   class="btn-action-delete px-2 py-1 h-7 rounded text-xs inline-flex items-center space-x-1"
                   data-turbo-frame="_top">
                    <x-icons.delete class="h-3 w-3" />
                    <span>{{ __('Delete') }}</span>
                </a>
            </div>
        </div>

        <!-- Desktop Layout (sm and above) -->
        <div class="hidden sm:block">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-3">
                        <!-- Project/Client Info -->
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg text-gray-900 truncate">
                                {{ $entry->client->name ?? __('No Client') }}
                                @if($entry->project)
                                    <span class="text-gray-500 font-normal">→ {{ $entry->project->name }}</span>
                                @endif
                            </h4>
                        </div>
                    </div>
                    
                    <!-- Time and Notes -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center text-gray-600">
                            <x-icons.clock class="h-4 w-4 mr-2" />
                            <span class="text-sm">
                                <x-user-datetime :datetime="$entry->start_time" />
                                @if($entry->end_time)
                                    - <x-user-time :time="$entry->end_time" />
                                @endif
                            </span>
                        </div>
                        
                        @if($entry->getEffectiveHourlyRate())
                            <div class="flex items-center text-blue-600">
                                <span class="text-sm font-medium">{{ $entry->getEffectiveHourlyRate()->formatted() }}/hr</span>
                            </div>
                        @endif
                        
                        @if($entry->notes)
                            <div class="flex items-center text-gray-500">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <span class="text-sm truncate max-w-xs">{{ $entry->notes }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Duration and Actions -->
                <div class="flex items-center space-x-6">
                    <!-- Duration & Earnings with Hourly Rate -->
                    <div class="text-right">
                        @if($entry->duration)
                            <div class="text-xl font-mono font-bold text-gray-900">
                                {{ $entry->formattedDuration }}
                            </div>
                        @endif
                        <div class="space-y-1 mt-1">
                            @if($entry->calculateEarnings())
                                <div class="text-sm text-gray-600">
                                    {{ $entry->calculateEarnings()->formatted() }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-2">
                        @if(!$entry->end_time)
                            <x-running-status-badge size="md" />
                        @elseif($runningTimer)
                            <button type="button"
                                    disabled
                                    class="bg-gray-100 text-gray-400 px-3 py-2 rounded-lg text-sm font-medium cursor-not-allowed inline-flex items-center space-x-1"
                                    title="{{ __('Another timer is running') }}">
                                <x-icons.play-circle class="h-4 w-4" />
                                <span>{{ __('Start') }}</span>
                            </button>
                        @else
                            <form action="{{ route('running-timer-session.store') }}" method="POST" data-turbo-frame="_top">
                                @csrf
                                <input type="hidden" name="client_id" value="{{ $entry->client_id }}">
                                <input type="hidden" name="project_id" value="{{ $entry->project_id }}">
                                <button type="submit"
                                        class="btn-action-start px-3 py-2 rounded-lg text-sm inline-flex items-center space-x-1">
                                    <x-icons.play-circle class="h-4 w-4" />
                                    <span>{{ __('Start') }}</span>
                                </button>
                            </form>
                        @endif

                        @if($entry->end_time)
                            <a href="{{ route('time-entries.edit', ['timeEntry' => $entry, 'is_recent' => true]) }}"
                               class="btn-action-edit px-3 py-2 rounded-lg text-sm inline-flex items-center space-x-1"
                               data-turbo-frame="time-entry-{{ $entry->id }}">
                                <x-icons.edit class="h-4 w-4" />
                                <span>{{ __('Edit') }}</span>
                            </a>
                        @endif

                        <a href="{{ route('time-entries.destroy', ['timeEntry' => $entry, 'is_recent' => true]) }}"
                           data-turbo-method="delete"
                           data-turbo-confirm="{{ __('Are you sure you want to delete this time entry?') }}"
                           class="btn-action-delete px-3 py-2 rounded-lg text-sm inline-flex items-center space-x-1"
                           data-turbo-frame="_top">
                            <x-icons.delete class="h-4 w-4" />
                            <span>{{ __('Delete') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</turbo-frame>
