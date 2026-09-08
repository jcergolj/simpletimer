<?php

declare(strict_types=1);

namespace Tests\Unit\Database\Migrations;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NormalizeMoneyPrecisionTest extends TestCase
{
    #[Test]
    public function money_precision_can_be_rolled_back_and_reapplied_without_rescaling_data(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);
        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create(['project_id' => $project->id]);

        $legacyValues = [
            ['table' => 'users', 'id' => $user->id, 'amount' => 5000, 'currency' => 'USD'],
            ['table' => 'clients', 'id' => $client->id, 'amount' => 500, 'currency' => 'KWD'],
            ['table' => 'projects', 'id' => $project->id, 'amount' => 500, 'currency' => 'KWD'],
            ['table' => 'time_entries', 'id' => $timeEntry->id, 'amount' => 5000, 'currency' => 'USD'],
        ];

        foreach ($legacyValues as $value) {
            DB::table($value['table'])->where('id', $value['id'])->update([
                'hourly_rate' => json_encode([
                    'amount' => $value['amount'],
                    'currency' => $value['currency'],
                ]),
            ]);
        }

        $migration = require database_path('migrations/2026_09_07_001358_normalize_money_precision.php');
        $migration->up();

        $this->assertMoneyAmount('users', $user->id, 5000);
        $this->assertMoneyAmount('clients', $client->id, 5000);

        $migration->down();

        $this->assertMoneyAmount('users', $user->id, 5000);
        $this->assertMoneyAmount('clients', $client->id, 500);

        $migration->up();

        $this->assertMoneyAmount('users', $user->id, 5000);
        $this->assertMoneyAmount('clients', $client->id, 5000);
    }

    private function assertMoneyAmount(string $table, int $id, int $expectedAmount): void
    {
        $hourlyRate = json_decode((string) DB::table($table)->where('id', $id)->value('hourly_rate'), true);

        $this->assertSame($expectedAmount, $hourlyRate['amount']);
    }
}
