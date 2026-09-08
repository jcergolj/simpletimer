<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Collection;

class CsvExportService
{
    public function generateTimeEntryCsv(
        Collection $timeEntries,
        Collection $earningsByCurrency,
        float $totalHours,
        Collection $projectTotals
    ): string {
        $stream = fopen('php://temp', 'r+');

        $this->writeRow($stream, [
            'Date',
            'Start Time',
            'End Time',
            'Duration (Hours)',
            'Client',
            'Project',
            'Notes',
            'Hourly Rate',
            'Earnings',
        ]);

        foreach ($timeEntries as $entry) {
            $earnings = $entry->calculateEarnings();

            $this->writeRow($stream, [
                $entry->start_time->format('Y-m-d'),
                $entry->start_time->format('H:i'),
                $entry->end_time?->format('H:i') ?? '',
                number_format((int) $entry->duration / 3600, 2, '.', ''),
                $entry->client instanceof Client ? $entry->client->name : '',
                $entry->project instanceof Project ? $entry->project->name : '',
                $entry->notes ?? '',
                $entry->getEffectiveHourlyRate()?->formattedForCsv() ?? '',
                $earnings?->formattedForCsv() ?? '',
            ]);
        }

        fwrite($stream, "\n");

        $this->writeRow($stream, [
            '',
            '',
            '',
            number_format($totalHours, 2, '.', ''),
            '',
            '',
            '',
            'TOTAL HOURS',
            '',
        ]);

        foreach ($earningsByCurrency as $currencyCode => $totalMoney) {
            $this->writeRow($stream, [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                "TOTAL ($currencyCode)",
                $totalMoney->formattedForCsv(),
            ]);
        }

        if ($projectTotals->isNotEmpty()) {
            fwrite($stream, "\n\n");
            $this->writeRow($stream, ['SUMMARY BY PROJECT']);
            $this->writeRow($stream, ['Project', 'Client', 'Entries', 'Hours', 'Earnings']);

            foreach ($projectTotals as $projectTotal) {
                $earningsDisplay = $projectTotal['earningsByCurrency']
                    ->map(fn ($money): string => $money->formattedForCsv())
                    ->implode(' + ');

                $this->writeRow($stream, [
                    $projectTotal['project'] instanceof Project ? $projectTotal['project']->name : 'No Project',
                    $projectTotal['project'] instanceof Project && $projectTotal['project']->client instanceof Client
                        ? $projectTotal['project']->client->name
                        : 'No Client',
                    $projectTotal['entry_count'],
                    number_format($projectTotal['hours'], 2, '.', ''),
                    $earningsDisplay ?: '0',
                ]);
            }
        }

        fwrite($stream, "\n");
        $this->writeRow($stream, ['Generated with SimpleTimer']);
        $this->writeRow($stream, [config('app.url')]);

        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);

        return (string) $csv;
    }

    /**
     * @param  resource  $stream
     * @param  array<int, mixed>  $values
     */
    private function writeRow($stream, array $values): void
    {
        $values = array_map(function (mixed $value): string {
            $value = (string) $value;

            if ($value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
                return "'{$value}";
            }

            return $value;
        }, $values);

        fputcsv($stream, $values);
    }
}
