<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class TemplateDatabaseNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Template database not found. Please run migrations first.');
    }
}
