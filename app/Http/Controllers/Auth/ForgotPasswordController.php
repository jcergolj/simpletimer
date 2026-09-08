<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Services\SubdomainUrlBuilder;
use App\Services\TenantDatabaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ForgotPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(
        ForgotPasswordRequest $request,
        SubdomainUrlBuilder $urlBuilder,
        TenantDatabaseService $tenantDb
    ): RedirectResponse {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            InAppNotification::success(__('If an account exists with that email, you will receive a password reset link.'));

            return back();
        }

        $token = Str::random(64);

        $user->forceFill([
            'password_reset_token' => hash('sha256', $token),
        ])->save();

        $subdomain = $tenantDb->extractSubdomain($request);
        $origin = $subdomain === null
            ? $urlBuilder->buildMainDomain()
            : $urlBuilder->build($subdomain);

        URL::useOrigin($origin);

        try {
            $resetUrl = URL::temporarySignedRoute(
                'password.reset',
                now()->addHour(),
                ['email' => $user->email, 'token' => $token]
            );
        } finally {
            URL::useOrigin(null);
        }

        $user->notify(new ResetPasswordNotification($resetUrl));

        InAppNotification::success(__('If an account exists with that email, you will receive a password reset link.'));

        return back();
    }
}
