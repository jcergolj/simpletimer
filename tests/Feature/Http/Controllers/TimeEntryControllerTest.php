<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Enums\Currency;
use App\Http\Controllers\TimeEntryController;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(TimeEntryController::class)]
final class TimeEntryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function a_manual_entry_uses_the_project_clients_rate_when_client_is_omitted(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::USD),
        ]);
        $client = Client::factory()->withoutHourlyRate()->create();
        $client->update(['hourly_rate' => Money::fromDecimal(200, Currency::USD)]);
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);

        $response = $this->actingAs($user)->post(route('time-entries.store'), [
            'start_time' => '2026-09-04 09:00:00',
            'end_time' => '2026-09-04 10:00:00',
            'project_id' => $project->id,
            'notes' => null,
        ]);

        $response->assertValid();

        $entry = TimeEntry::first();

        $this->assertNotNull($entry);

        $this->assertSame(20000, $entry->hourlyRate?->amount);
    }

    #[Test]
    public function a_project_must_belong_to_the_selected_client(): void
    {
        $user = User::factory()->create();
        $firstClient = Client::factory()->withoutHourlyRate()->create();
        $secondClient = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $firstClient->id]);

        $response = $this->actingAs($user)->post(route('time-entries.store'), [
            'start_time' => '2026-09-04 09:00:00',
            'end_time' => '2026-09-04 10:00:00',
            'client_id' => $secondClient->id,
            'project_id' => $project->id,
            'notes' => null,
        ]);

        $response->assertSessionHasErrors('project_id');

        $this->assertSame(0, TimeEntry::count());
    }
}
