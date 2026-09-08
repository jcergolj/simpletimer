<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Enums\Currency;
use App\Http\Controllers\ProjectController;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectController::class)]
final class ProjectControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function a_project_without_an_override_keeps_rate_inheritance(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::USD),
        ]);
        $client = Client::factory()->withoutHourlyRate()->create();
        $client->update(['hourly_rate' => Money::fromDecimal(200, Currency::USD)]);

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => 'Inherited project',
            'client_id' => $client->id,
        ]);

        $response->assertValid();

        $project = Project::first();

        $this->assertNotNull($project);

        $this->assertNull($project->hourlyRate);
    }

    #[Test]
    public function changing_a_projects_client_updates_existing_entry_associations(): void
    {
        $user = User::factory()->create();
        $oldClient = Client::factory()->withoutHourlyRate()->create();
        $newClient = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $oldClient->id]);
        $entry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $oldClient->id,
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $newClient->id,
        ]);

        $response->assertValid();

        $this->assertSame($newClient->id, $entry->fresh()->client_id);
    }
}
