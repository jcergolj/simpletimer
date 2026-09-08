@props(['metrics'])

<div id="weekly-earnings" class="card p-5">
    <div class="stat-label">{{ __('Weekly Earnings') }}</div>

    @if(count($metrics->weeklyEarnings) > 0)
        <div class="flex flex-wrap gap-2 sm:gap-3">
            @foreach($metrics->weeklyEarnings as $earning)
                <div class="stat-value stat-value-accent">
                    {{ $earning->formatted() }} ({{ $earning->currency->value }})
                </div>
            @endforeach
        </div>

    @else
        <div class="stat-value stat-value-accent">{{ __('No earnings') }}</div>
    @endif
</div>
