<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class InvalidSubdomainFormat extends Exception
{
    public function __construct(string $subdomain)
    {
        parent::__construct("Invalid subdomain format: '{$subdomain}'.");
    }
}
