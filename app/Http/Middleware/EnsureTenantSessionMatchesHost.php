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
        $sessionAccountUuid = $request->session()->get(TenantDatabaseService::ACCOUNT_SESSION_KEY);

        if ($sessionTenant !== null && $sessionTenant !== $subdomain) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to this subdomain.');
        }

        if ($user) {
            if (! is_string($user->account_uuid)
                || ($sessionAccountUuid !== null
                    && (! is_string($sessionAccountUuid) || ! hash_equals($user->account_uuid, $sessionAccountUuid)))) {
                abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to this tenant.');
            }

            $request->session()->put([
                TenantDatabaseService::SESSION_KEY => $subdomain,
                TenantDatabaseService::ACCOUNT_SESSION_KEY => $user->account_uuid,
            ]);
        }

        return $next($request);
    }
}
