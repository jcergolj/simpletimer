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
use Illuminate\Support\Facades\File;
use RuntimeException;

final readonly class TenantDatabaseService
{
    public const string SESSION_KEY = 'tenant';

    public function extractSubdomain(Request $request): ?string
    {
        $host = strtolower($request->getHost());
        $domain = strtolower(trim((string) Config::get('app.domain'), '.'));
        $suffix = '.'.$domain;

        if ($host === $domain || ! str_ends_with($host, $suffix)) {
            return null;
        }

        $subdomain = substr($host, 0, -strlen($suffix));

        return $subdomain !== '' && ! str_contains($subdomain, '.') ? $subdomain : null;
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

        File::ensureDirectoryExists(dirname($databasePath));

        throw_if(file_exists($databasePath), TenantDatabaseAlreadyExists::class, $subdomain);

        throw_unless(copy($templatePath, $databasePath), RuntimeException::class, 'Unable to create the tenant database.');
    }

    public function deleteTenantDatabase(string $subdomain): void
    {
        $this->validateSubdomain($subdomain);

        $databasePath = $this->getDatabasePath($subdomain);

        DB::disconnect('tenant');
        DB::purge('tenant');

        throw_if(File::exists($databasePath) && ! File::delete($databasePath), RuntimeException::class, 'Unable to delete the tenant database.');
    }

    public function getActiveDatabasePath(): ?string
    {
        $connection = Config::get('database.connections.'.Config::get('database.default'));

        if (! is_array($connection) || ($connection['driver'] ?? null) !== 'sqlite') {
            return null;
        }

        $database = $connection['database'] ?? null;

        if (! is_string($database) || $database === '' || $database === ':memory:') {
            return null;
        }

        return str_starts_with($database, DIRECTORY_SEPARATOR)
            ? $database
            : base_path($database);
    }

    private function isTestingWithInMemoryDatabase(): bool
    {
        return config('database.connections.'.config('database.default').'.database') === ':memory:';
    }

    public function isMainDomain(Request $request): bool
    {
        return strtolower($request->getHost()) === strtolower((string) Config::get('app.domain'));
    }
}
