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
}
