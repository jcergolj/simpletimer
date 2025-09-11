<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TenantDatabaseServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TenantDatabaseService';
    }
}
