<?php

use App\Http\Middleware\EnsureTenantSessionMatchesHost;
use Opcodes\LogViewer\Http\Middleware\AuthorizeLogViewer;
use Opcodes\LogViewer\Http\Middleware\EnsureFrontendRequestsAreStateful;

return [
    'api_middleware' => [
        EnsureFrontendRequestsAreStateful::class,
        EnsureTenantSessionMatchesHost::class,
        AuthorizeLogViewer::class,
    ],
];
