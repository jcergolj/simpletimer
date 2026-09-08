<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

final readonly class EnsureTenantSessionMatchesHost
{
    public function __construct(
        private TenantDatabaseService $tenantDb
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (Config::get('app.single_user_mode')) {
            return $next($request);
        }

        $sessionTenant = $request->session()->get(TenantDatabaseService::SESSION_KEY);

        if ($this->tenantDb->isMainDomain($request)) {
            if ($sessionTenant !== null) {
                abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to the main domain.');
            }

            return $next($request);
        }

        $subdomain = $this->tenantDb->extractSubdomain($request);

        if ($subdomain === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $user = $request->user();

        if ($sessionTenant !== $subdomain && ($user || $sessionTenant !== null)) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to this subdomain.');
        }

        return $next($request);
    }
}
