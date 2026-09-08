<?php

namespace App\View\Components\Dashboard;

use App\ValueObjects\WeeklyMetrics;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeeklyHours extends Component
{
    public function __construct(
        public WeeklyMetrics $metrics
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.dashboard.weekly-hours', ['metrics' => $this->metrics]);
    }
}
