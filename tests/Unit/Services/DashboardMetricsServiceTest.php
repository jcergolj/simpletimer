<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DashboardMetricsService::class)]
final class DashboardMetricsServiceTest extends TestCase
{
    #[Test]
    public function weekly_metrics_exclude_future_entries(): void
    {
        TimeEntry::factory()->create([
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'duration' => 3600,
        ]);

        $metrics = app(DashboardMetricsService::class)->getWeeklyMetrics();

        $this->assertEqualsWithDelta(0.0, $metrics->totalHours, PHP_FLOAT_EPSILON);
    }
}
