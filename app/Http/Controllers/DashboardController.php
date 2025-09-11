<?php

namespace App\Http\Controllers;

use App\Services\DashboardMetricsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(DashboardMetricsService $dashboardMetrics): View
    {
        $recentEntries = $dashboardMetrics->getRecentEntries();
        $lastEntry = $recentEntries->first();
        $runningTimer = $dashboardMetrics->getRunningTimer();

        return view('dashboard', [
            'recentEntries' => $recentEntries,
            'lastEntry' => $lastEntry,
            'runningTimer' => $runningTimer,
        ]);
    }
}
