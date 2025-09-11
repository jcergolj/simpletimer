<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components;

use App\Models\User;
use App\View\Components\UserTime;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserTime::class)]
final class UserTimeTest extends TestCase
{
    #[Test]
    public function formats_time_in_12h_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['time_format' => '12']);
        $this->actingAs($user);

        $component = new UserTime($testDate);

        $this->assertSame('2:30 PM', $component->formattedTime);
    }

    #[Test]
    public function formats_time_in_24h_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['time_format' => '24']);
        $this->actingAs($user);

        $component = new UserTime($testDate);

        $this->assertSame('14:30', $component->formattedTime);
    }

    #[Test]
    public function handles_null_time(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = new UserTime(null);

        $this->assertSame('', $component->formattedTime);
    }

    #[Test]
    public function uses_fallback_format_without_authenticated_user(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);

        $component = new UserTime($testDate);

        $this->assertSame('2:30 PM', $component->formattedTime);
    }
}
