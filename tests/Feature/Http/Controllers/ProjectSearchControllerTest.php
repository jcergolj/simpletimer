<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\Currency;
use App\Http\Controllers\ProjectSearchController;
use App\Models\Client;
use App\Models\User;
use App\ValueObjects\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectSearchController::class)]
class ProjectSearchControllerTest extends TestCase
{
    #[Test]
    public function a_new_project_uses_the_clients_rate_before_the_users_default(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::USD),
        ]);

        $client = Client::factory()->withoutHourlyRate()->create([
            'hourly_rate' => Money::fromDecimal(125.50, Currency::EUR),
        ]);

        $response = $this->actingAs($user)->get(route('projects-search.index', [
            'q' => 'New project',
            'client_id' => $client->id,
        ]));

        $response->assertOk();
        $response->assertSee('value="125.50"', false);
        $response->assertSee('value="EUR" selected', false);
    }

    #[Test]
    public function a_new_project_uses_the_users_default_when_the_client_has_no_rate(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(85.75, Currency::GBP),
        ]);

        $client = Client::factory()->withoutHourlyRate()->create();

        $response = $this->actingAs($user)->get(route('projects-search.index', [
            'q' => 'New project',
            'client_id' => $client->id,
        ]));

        $response->assertOk();
        $response->assertSee('value="85.75"', false);
        $response->assertSee('value="GBP" selected', false);
    }

    #[Test]
    public function a_zero_client_rate_is_not_replaced_by_the_users_default(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::USD),
        ]);

        $client = Client::factory()->withoutHourlyRate()->create([
            'hourly_rate' => Money::fromDecimal(0, Currency::EUR),
        ]);

        $response = $this->actingAs($user)->get(route('projects-search.index', [
            'q' => 'New project',
            'client_id' => $client->id,
        ]));

        $response->assertOk();
        $response->assertSee('value="0.00"', false);
        $response->assertSee('value="EUR" selected', false);
    }
}
