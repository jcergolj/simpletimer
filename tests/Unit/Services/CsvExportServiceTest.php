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
            'notes' => "note,with\nline\\",
        ]);
        $entry->setRelation('client', new Client(['name' => '=SUM(A1:A2)']));
        $entry->setRelation('project', new Project(['name' => 'Project\\", Name']));
        $entry->hourlyRate = Money::fromDecimal(50);

        $csv = app(CsvExportService::class)->generateTimeEntryCsv(
            new Collection([$entry]),
            new Collection,
            1.0,
            new Collection,
        );

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $csv);
        rewind($stream);
        $rows = [];

        while (($row = fgetcsv($stream, escape: '')) !== false) {
            $rows[] = $row;
        }

        fclose($stream);

        $detailRow = collect($rows)->first(fn (array $row): bool => $row[0] === '2026-09-04');

        $this->assertIsArray($detailRow);
        $this->assertCount(9, $detailRow);
        $this->assertSame("'=SUM(A1:A2)", $detailRow[4]);
        $this->assertSame('Project\\", Name', $detailRow[5]);
        $this->assertSame("note,with\nline\\", $detailRow[6]);
    }
}
