<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\TenantDatabaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateTenantDatabases extends Command
{
    protected $signature = 'app:migrate-tenant-databases';

    protected $description = 'Run pending migrations for every tenant database';

    public function handle(TenantDatabaseService $tenantDb): int
    {
        $databasePaths = File::glob(database_path('db/*.sqlite')) ?: [];

        foreach ($databasePaths as $databasePath) {
            $subdomain = pathinfo((string) $databasePath, PATHINFO_FILENAME);
            $tenantDb->validateSubdomain($subdomain);
            $tenantDb->connectToTenant($subdomain);

            $this->call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations',
                '--force' => true,
                '--no-interaction' => true,
            ]);
        }

        $this->components->info(sprintf('Migrated %d tenant database(s).', count($databasePaths)));

        return self::SUCCESS;
    }
}
