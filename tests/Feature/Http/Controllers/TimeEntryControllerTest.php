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
use Carbon\Carbon;
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

    #[Test]
    public function pagination_preserves_time_entry_filters(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);

        foreach (range(0, 20) as $index) {
            TimeEntry::factory()->withoutHourlyRate()->create([
                'start_time' => Carbon::parse('2026-09-08')->subDays($index),
                'client_id' => $client->id,
                'project_id' => $project->id,
                'notes' => $index === 20 ? 'target page two entry' : 'target entry',
            ]);
        }

        $response = $this->actingAs($user)->get(route('time-entries.index', [
            'client_id' => $client->id,
            'project_id' => $project->id,
            'date_from' => '2026-01-01',
            'date_to' => '2026-12-31',
        ]));

        $response->assertOk()
            ->assertSee('client_id='.$client->id, false)
            ->assertSee('project_id='.$project->id, false)
            ->assertSee('date_from=2026-01-01', false)
            ->assertSee('date_to=2026-12-31', false);

        $pageTwoResponse = $this->actingAs($user)->get(route('time-entries.index', [
            'client_id' => $client->id,
            'project_id' => $project->id,
            'date_from' => '2026-01-01',
            'date_to' => '2026-12-31',
            'page' => 2,
        ]));

        $pageTwoResponse->assertOk()->assertSee('target page two entry');
    }
}
