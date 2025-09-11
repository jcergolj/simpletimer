<?php

namespace App\Exceptions;

class DatabaseNotFound extends AppException
{
    public function __construct()
    {
        parent::__construct('User database not found.', 1);
    }
}
