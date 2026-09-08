<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Currency;
use App\Models\TimeEntry;
use App\Services\WeeklyEarningsCalculator;
use App\ValueObjects\Money;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(WeeklyEarningsCalculator::class)]
final class WeeklyEarningsCalculatorTest extends TestCase
{
    #[Test]
    public function it_keeps_earnings_separate_for_each_currency(): void
    {
        $usdEntry = new TimeEntry(['duration' => 3600]);
        $usdEntry->setAttribute('hourly_rate', Money::fromDecimal(100, Currency::USD));

        $eurEntry = new TimeEntry(['duration' => 3600]);
        $eurEntry->setAttribute('hourly_rate', Money::fromDecimal(100, Currency::EUR));

        $metrics = WeeklyEarningsCalculator::calculate(new Collection([$usdEntry, $eurEntry]));

        $this->assertCount(2, $metrics->weeklyEarnings);

    }
}
