<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DatabaseNotFound;
use App\Exceptions\InvalidSubdomainFormat;
use App\Exceptions\TemplateDatabaseNotFound;
use App\Exceptions\TenantDatabaseAlreadyExists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

final readonly class TenantDatabaseService
{
    public function extractSubdomain(Request $request): ?string
    {
        $host = $request->getHost();
        $parts = explode('.', $host);

        if (count($parts) >= 2) {
            return $parts[0];
        }

        return null;
    }

    public function getDatabasePath(string $subdomain): string
    {
        return database_path("db/{$subdomain}.sqlite");
    }

    public function databaseExists(string $subdomain): bool
    {
        return file_exists($this->getDatabasePath($subdomain));
    }

    public function validateSubdomain(string $subdomain): void
    {
        throw_unless(preg_match('/^[a-z0-9_-]+$/', $subdomain), InvalidSubdomainFormat::class, $subdomain);
    }

    public function connectToTenant(string $subdomain): void
    {
        $this->validateSubdomain($subdomain);

        if ($this->isTestingWithInMemoryDatabase()) {
            return;
        }

        $databasePath = $this->getDatabasePath($subdomain);

        throw_unless(file_exists($databasePath), DatabaseNotFound::class);

        Config::set('database.connections.tenant.database', $databasePath);
        Config::set('database.default', 'tenant');

        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    public function createTenantDatabase(string $subdomain): void
    {
        $this->validateSubdomain($subdomain);

        if ($this->isTestingWithInMemoryDatabase()) {
            return;
        }

        $databasePath = $this->getDatabasePath($subdomain);

        throw_if(file_exists($databasePath), TenantDatabaseAlreadyExists::class, $subdomain);

        $templatePath = database_path('template.sqlite');

        throw_unless(file_exists($templatePath), TemplateDatabaseNotFound::class);

        copy($templatePath, $databasePath);
    }

    private function isTestingWithInMemoryDatabase(): bool
    {
        return config('database.connections.'.config('database.default').'.database') === ':memory:';
    }

    public function isMainDomain(Request $request): bool
    {
        return $request->getHost() === Config::get('app.domain');
    }
}
