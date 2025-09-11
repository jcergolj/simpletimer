<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegistrationRequest;
use App\Models\User;
use App\Services\SubdomainUrlBuilder;
use App\Services\TenantDatabaseService;
use App\ValueObjects\Money;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

final class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(StoreRegistrationRequest $request, TenantDatabaseService $tenantDb, SubdomainUrlBuilder $urlBuilder): RedirectResponse
    {
        $validated = $request->validated();

        if (Config::get('app.single_user_mode')) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'hourly_rate' => Money::fromValidated($validated),
            ]);

            event(new Registered($user));
            Auth::login($user);

            return to_route('dashboard');
        }

        $subdomain = $validated['username'];

        $tenantDb->createTenantDatabase($subdomain);
        $tenantDb->connectToTenant($subdomain);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'hourly_rate' => Money::fromValidated($validated),
        ]);

        event(new Registered($user));

        return redirect($urlBuilder->build($subdomain, '/dashboard'));
    }
}
