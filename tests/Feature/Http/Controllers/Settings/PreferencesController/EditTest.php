<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\PreferencesController;

use App\Http\Controllers\Settings\PreferencesController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(PreferencesController::class)]
#[CoversMethod(PreferencesController::class, 'edit')]
final class EditTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->get(route('settings.preferences.edit'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_preferences_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.preferences.edit'));

        $response->assertOk();
    }

    #[Test]
    public function page_shows_date_time_format_options(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.preferences.edit'));

        $response->assertSee('Date Format');
        $response->assertSee('Time Format');
    }
}
