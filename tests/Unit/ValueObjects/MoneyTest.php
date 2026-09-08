<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\Enums\Currency;
use App\ValueObjects\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(Money::class)]
final class MoneyTest extends TestCase
{
    #[Test]
    public function it_uses_three_decimal_places_for_kwd(): void
    {
        $money = Money::fromDecimal(1.234, Currency::KWD);

        $this->assertSame(1234, $money->amount);

        $this->assertSame('د.ك1.234', $money->formattedForCsv());
    }

    #[Test]
    public function it_uses_no_decimal_places_for_jpy(): void
    {
        $money = Money::fromDecimal(123, Currency::JPY);

        $this->assertSame(123, $money->amount);

        $this->assertSame('¥123', $money->formattedForCsv());
    }

    #[Test]
    public function it_rejects_amounts_that_overflow_integer_storage(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Money::fromDecimal((float) PHP_INT_MAX, Currency::USD);
    }
}
