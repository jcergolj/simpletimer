<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Duration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(Duration::class)]
final class DurationTest extends TestCase
{
    #[Test]
    public function it_formats_durations_over_one_day_without_wrapping(): void
    {
        $this->assertSame('25:00:00', Duration::formatSeconds(90_000));
    }
}
