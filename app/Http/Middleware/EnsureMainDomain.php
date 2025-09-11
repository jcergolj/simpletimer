<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\SubdomainUrlBuilder;
use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

final readonly class EnsureMainDomain
{
    public function __construct(
        private TenantDatabaseService $tenantDb,
        private SubdomainUrlBuilder $urlBuilder
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        // Skip in single-user mode
        if (Config::get('app.single_user_mode')) {
            return $next($request);
        }

        if (! $this->tenantDb->isMainDomain($request)) {
            return redirect($this->urlBuilder->buildMainDomain($request->path()));
        }

        return $next($request);
    }
}
