<?php

declare(strict_types=1);

use App\Enums\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['users', 'clients', 'projects', 'time_entries'] as $table) {
            $rows = DB::table($table)
                ->whereNotNull('hourly_rate')
                ->get(['id', 'hourly_rate']);

            foreach ($rows as $row) {
                $data = json_decode((string) $row->hourly_rate, true);
                $currency = is_array($data) ? Currency::tryFrom((string) ($data['currency'] ?? '')) : null;

                if (! $currency instanceof Currency || ! is_numeric($data['amount'] ?? null)) {
                    continue;
                }

                $data['amount'] = (int) round(((float) $data['amount'] / 100) * (10 ** $currency->minorUnit()));

                DB::table($table)
                    ->where('id', $row->id)
                    ->update(['hourly_rate' => json_encode($data)]);
            }
        }
    }
};
