<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\DatabaseNotFound;
use App\Services\SubdomainUrlBuilder;
use App\Services\TenantDatabaseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

final readonly class ConnectToUserDatabase
{
    public function __construct(
        private TenantDatabaseService $tenantDb,
        private SubdomainUrlBuilder $urlBuilder
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (Config::get('app.single_user_mode')) {
            return $next($request);
        }

        $subdomain = $this->tenantDb->extractSubdomain($request);

        if (! $subdomain || $this->tenantDb->isMainDomain($request)) {
            return $next($request);
        }

        if ($this->isRegistrationRoute($request)) {
            return $next($request);
        }

        if (! $this->tenantDb->databaseExists($subdomain)) {
            return response()->view('errors.subdomain-not-found', [
                'subdomain' => $subdomain,
                'mainUrl' => $this->urlBuilder->buildMainDomain(),
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->tenantDb->connectToTenant($subdomain);
        } catch (DatabaseNotFound) {
            return response()->view('errors.subdomain-not-found', [
                'subdomain' => $subdomain,
                'mainUrl' => $this->urlBuilder->buildMainDomain(),
            ], Response::HTTP_NOT_FOUND);
        }

        $user = $request->user();

        if ($user && $subdomain !== $user->username) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to this subdomain.');
        }

        return $next($request);
    }

    private function isRegistrationRoute(Request $request): bool
    {
        return $request->routeIs('register', 'register.store');
    }
}
