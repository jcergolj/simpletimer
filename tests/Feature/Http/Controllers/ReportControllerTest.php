<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportExportController;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ReportController::class)]
#[CoversClass(ReportExportController::class)]
final class ReportControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function client_reports_include_entries_associated_through_a_project(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $unrelatedClient = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);

        $this->createEntry(['project_id' => $project->id, 'notes' => 'project-only target']);
        $this->createEntry(['client_id' => $client->id, 'notes' => 'direct target']);
        $this->createEntry(['client_id' => $unrelatedClient->id, 'notes' => 'unrelated entry']);

        $response = $this->actingAs($user)->get(route('reports.index', ['client_id' => $client->id]));

        $response->assertOk()
            ->assertSee('project-only target')
            ->assertSee('direct target')
            ->assertDontSee('unrelated entry');
    }

    #[Test]
    public function client_csv_exports_include_entries_associated_through_a_project(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $unrelatedClient = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);

        $this->createEntry(['project_id' => $project->id, 'notes' => 'project-only csv target']);
        $this->createEntry(['client_id' => $unrelatedClient->id, 'notes' => 'unrelated csv entry']);

        $response = $this->actingAs($user)->get(route('report-exports.show', ['client_id' => $client->id]));

        $response->assertOk()
            ->assertSee('project-only csv target')
            ->assertDontSee('unrelated csv entry');
    }

    /** @param array<string, mixed> $attributes */
    private function createEntry(array $attributes): TimeEntry
    {
        return TimeEntry::factory()->withoutHourlyRate()->create([
            'start_time' => Carbon::parse('2026-09-04 09:00:00'),
            'end_time' => Carbon::parse('2026-09-04 10:00:00'),
            'duration' => 3600,
            ...$attributes,
        ]);
    }
}
