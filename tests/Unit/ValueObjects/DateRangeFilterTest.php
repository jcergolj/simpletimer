<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\DateRangeFilter;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DateRangeFilter::class)]
final class DateRangeFilterTest extends TestCase
{
    #[Test]
    public function a_start_date_can_be_used_without_an_end_date(): void
    {
        $filter = DateRangeFilter::fromRequest(null, '2026-09-01', null);

        $this->assertSame('2026-09-01', $filter->startDate?->toDateString());

        $this->assertNotInstanceOf(Carbon::class, $filter->endDate);
    }

    #[Test]
    public function an_end_date_can_be_used_without_a_start_date(): void
    {
        $filter = DateRangeFilter::fromRequest(null, null, '2026-09-01');

        $this->assertNotInstanceOf(Carbon::class, $filter->startDate);

        $this->assertSame('2026-09-01', $filter->endDate?->toDateString());
    }

    #[Test]
    public function last_month_returns_the_previous_calendar_month_at_month_end(): void
    {
        $this->travelTo('2026-03-31 12:00:00');

        $filter = DateRangeFilter::fromPeriod('last_month');

        $this->travelTo(null);

        $this->assertSame('2026-02-01', $filter->startDate?->toDateString());
        $this->assertSame('2026-02-28', $filter->endDate?->toDateString());
    }

    #[Test]
    public function last_month_includes_leap_day_when_the_previous_year_is_a_leap_year(): void
    {
        $this->travelTo('2024-03-31 12:00:00');

        $filter = DateRangeFilter::fromPeriod('last_month');

        $this->travelTo(null);

        $this->assertSame('2024-02-01', $filter->startDate?->toDateString());
        $this->assertSame('2024-02-29', $filter->endDate?->toDateString());
    }
}
