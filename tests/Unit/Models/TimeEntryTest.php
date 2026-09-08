<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(TimeEntry::class)]
final class TimeEntryTest extends TestCase
{
    #[Test]
    public function it_uses_the_project_clients_rate_when_no_client_is_set_on_the_entry(): void
    {
        $user = User::factory()->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::USD),
        ]);
        Auth::login($user);

        $client = Client::factory()->withoutHourlyRate()->create();
        $client->update(['hourly_rate' => Money::fromDecimal(200, Currency::USD)]);
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);
        $entry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => null,
            'project_id' => $project->id,
        ]);

        $entry->load('project.client');

        $rate = $entry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $rate);

        $this->assertSame(20000, $rate->amount);
    }
}
