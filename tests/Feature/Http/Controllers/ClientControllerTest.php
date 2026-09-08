<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Enums\Currency;
use App\Http\Controllers\ClientController;
use App\Models\Client;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ClientController::class)]
final class ClientControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function the_edit_form_displays_the_clients_existing_rate(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $client->update(['hourly_rate' => Money::fromDecimal(125.5, Currency::EUR)]);

        $response = $this->actingAs($user)->get(route('clients.edit', $client));

        $response->assertOk()
            ->assertSee('value="125.50"', false)
            ->assertSee('<option value="EUR" selected>', false);
    }

    #[Test]
    public function editing_a_client_without_a_rate_change_preserves_its_rate(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $client->update(['hourly_rate' => Money::fromDecimal(125.5, Currency::EUR)]);

        $response = $this->actingAs($user)->put(route('clients.update', $client), [
            'name' => 'Renamed client',
            'hourly_rate' => [
                'amount' => $client->hourlyRate->toDecimal(),
                'currency' => $client->hourlyRate->currency->value,
            ],
        ]);

        $response->assertValid();
        $this->assertEquals(Money::fromDecimal(125.5, Currency::EUR), $client->fresh()->hourlyRate);
    }
}
