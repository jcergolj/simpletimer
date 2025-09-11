<?php

declare(strict_types=1);

namespace App\Rules;

use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final readonly class ValidSubdomain implements ValidationRule
{
    private const array RESERVED_SUBDOMAINS = [
        'www',
        'api',
        'admin',
        'app',
        'mail',
        'ftp',
        'localhost',
    ];

    public function __construct(
        private TenantDatabaseService $tenantDb
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }

        if (in_array($value, self::RESERVED_SUBDOMAINS, true)) {
            $fail('This username is reserved.');

            return;
        }

        $isInMemoryDb = config('database.connections.'.config('database.default').'.database') === ':memory:';
        if (! $isInMemoryDb && $this->tenantDb->databaseExists($value)) {
            $fail('This username is already taken.');
        }
    }
}
