<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        LogViewer::auth(fn ($request) => $request->user()->email === Config('app.admin_email'));
    }
}
