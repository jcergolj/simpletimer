<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Opcodes\LogViewer\Facades\LogViewer;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        LogViewer::auth(function (Request $request): bool {
            $adminEmail = config('app.admin_email');

            return is_string($adminEmail)
                && $adminEmail !== ''
                && $request->user()?->email === $adminEmail;
        });
    }
}
