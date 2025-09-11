<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components;

use App\Models\User;
use App\View\Components\UserDatetime;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserDatetime::class)]
final class UserDatetimeTest extends TestCase
{
    #[Test]
    public function formats_datetime_in_us_12h_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'us', 'time_format' => '12']);
        $this->actingAs($user);

        $component = new UserDatetime($testDate);

        $this->assertSame('12/25/2025 2:30 PM', $component->formattedDatetime);
    }

    #[Test]
    public function formats_datetime_in_uk_24h_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'uk', 'time_format' => '24']);
        $this->actingAs($user);

        $component = new UserDatetime($testDate);

        $this->assertSame('25/12/2025 14:30', $component->formattedDatetime);
    }

    #[Test]
    public function formats_datetime_in_eu_12h_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'eu', 'time_format' => '12']);
        $this->actingAs($user);

        $component = new UserDatetime($testDate);

        $this->assertSame('25.12.2025 2:30 PM', $component->formattedDatetime);
    }

    #[Test]
    public function handles_null_datetime(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = new UserDatetime(null);

        $this->assertSame('', $component->formattedDatetime);
    }

    #[Test]
    public function uses_fallback_format_without_authenticated_user(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);

        $component = new UserDatetime($testDate);

        $this->assertSame('Dec 25, 2025 2:30 PM', $component->formattedDatetime);
    }
}
