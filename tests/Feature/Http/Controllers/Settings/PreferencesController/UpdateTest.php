<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\PreferencesController;

use App\Http\Controllers\Settings\PreferencesController;
use App\Http\Requests\Settings\UpdatePreferencesRequest;
use App\Models\User;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(PreferencesController::class)]
#[CoversMethod(PreferencesController::class, 'update')]
final class UpdateTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->put(route('settings.preferences.update'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.preferences.update'));

        $this->assertContainsFormRequest(UpdatePreferencesRequest::class);
    }

    #[Test]
    public function user_can_update_date_format(): void
    {
        $user = User::factory()->create(['date_format' => 'us']);

        $response = $this->actingAs($user)->put(route('settings.preferences.update'), [
            'date_format' => 'eu',
            'time_format' => '12',
        ]);

        $response->assertRedirect(route('settings.preferences.edit'));
        $this->assertSame('eu', $user->fresh()->date_format);
    }

    #[Test]
    public function user_can_update_time_format(): void
    {
        $user = User::factory()->create(['time_format' => '12']);

        $response = $this->actingAs($user)->put(route('settings.preferences.update'), [
            'date_format' => 'us',
            'time_format' => '24',
        ]);

        $response->assertRedirect(route('settings.preferences.edit'));
        $this->assertSame('24', $user->fresh()->time_format);
    }

    #[Test]
    public function user_can_update_hourly_rate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.preferences.update'), [
            'date_format' => 'us',
            'time_format' => '12',
            'hourly_rate' => [
                'amount' => '50.00',
                'currency' => 'USD',
            ],
        ]);

        $response->assertRedirect(route('settings.preferences.edit'));
        $this->assertSame(5000, $user->fresh()->hourlyRate->amount);
        $this->assertSame('USD', $user->fresh()->hourlyRate->currency->value);
    }

    #[Test]
    public function invalid_formats_are_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.preferences.update'), [
            'date_format' => 'invalid',
            'time_format' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['date_format', 'time_format']);
    }
}
