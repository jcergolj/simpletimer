<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Services\CsvExportService;
use App\ValueObjects\Money;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(CsvExportService::class)]
final class CsvExportServiceTest extends TestCase
{
    #[Test]
    public function free_text_is_quoted_and_formula_values_are_neutralized(): void
    {
        $entry = new TimeEntry([
            'start_time' => Carbon::parse('2026-09-04 09:00:00'),
            'end_time' => Carbon::parse('2026-09-04 10:00:00'),
            'duration' => 3600,
            'notes' => "note,with\nline",
        ]);
        $entry->setRelation('client', new Client(['name' => '=SUM(A1:A2)']));
        $entry->setRelation('project', new Project(['name' => 'Project, Name']));
        $entry->hourlyRate = Money::fromDecimal(50);

        $csv = app(CsvExportService::class)->generateTimeEntryCsv(
            new Collection([$entry]),
            new Collection,
            1.0,
            new Collection,
        );

        $this->assertStringContainsString("'=SUM(A1:A2)", $csv);

        $this->assertStringContainsString('"Project, Name"', $csv);

        $this->assertStringContainsString('"note,with', $csv);
    }
}
