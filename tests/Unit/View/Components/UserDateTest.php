<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components;

use App\Models\User;
use App\View\Components\UserDate;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UserDate::class)]
final class UserDateTest extends TestCase
{
    #[Test]
    public function formats_date_in_us_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'us']);
        $this->actingAs($user);

        $component = new UserDate($testDate);

        $this->assertSame('12/25/2025', $component->formattedDate);
    }

    #[Test]
    public function formats_date_in_uk_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'uk']);
        $this->actingAs($user);

        $component = new UserDate($testDate);

        $this->assertSame('25/12/2025', $component->formattedDate);
    }

    #[Test]
    public function formats_date_in_eu_format(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);
        $user = User::factory()->create(['date_format' => 'eu']);
        $this->actingAs($user);

        $component = new UserDate($testDate);

        $this->assertSame('25.12.2025', $component->formattedDate);
    }

    #[Test]
    public function handles_null_date(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = new UserDate(null);

        $this->assertSame('', $component->formattedDate);
    }

    #[Test]
    public function uses_fallback_format_without_authenticated_user(): void
    {
        $testDate = Carbon::create(2025, 12, 25, 14, 30, 0);

        $component = new UserDate($testDate);

        $this->assertSame('Dec 25, 2025', $component->formattedDate);
    }
}
