<?php

declare(strict_types=1);

namespace App\Exceptions;

class DatabaseNotFound extends AppException
{
    public function __construct()
    {
        parent::__construct('User database not found.', 1);
    }
}
