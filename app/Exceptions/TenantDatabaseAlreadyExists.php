<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class TenantDatabaseAlreadyExists extends Exception
{
    public function __construct(string $subdomain)
    {
        parent::__construct("Tenant database for subdomain '{$subdomain}' already exists.");
    }
}
