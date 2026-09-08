<?php

namespace App\Services;

use App\Models\TimeEntry;
use App\ValueObjects\WeeklyMetrics;
use Carbon\Carbon;

class DashboardMetricsService
{
    public function getWeeklyMetrics(): WeeklyMetrics
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();

        $weeklyEntries = TimeEntry::query()
            ->with(['client', 'project.client'])
            ->whereBetween('start_time', [$startOfWeek, $now])
            ->whereNotNull('end_time')
            ->get();

        return WeeklyEarningsCalculator::calculate($weeklyEntries);
    }

    public function getRecentEntries(int $limit = 5)
    {
        return TimeEntry::query()
            ->with(['client', 'project.client'])
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getRunningTimer(): ?TimeEntry
    {
        return TimeEntry::query()
            ->with(['client', 'project.client'])
            ->whereNull('end_time')
            ->first();
    }
}
