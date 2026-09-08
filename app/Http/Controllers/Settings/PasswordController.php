<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Services\CredentialRotationService;
use App\Services\TenantDatabaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class PasswordController extends Controller
{
    public function edit(): View
    {
        return view('settings.password.edit');
    }

    public function update(UpdatePasswordRequest $request, CredentialRotationService $credentials): RedirectResponse
    {
        $validated = $request->validated();

        $user = $credentials->rotate($request->user(), $validated['password']);
        Auth::login($user);

        if (Session::has(TenantDatabaseService::SESSION_KEY)) {
            Session::put(TenantDatabaseService::ACCOUNT_SESSION_KEY, $user->account_uuid);
        }

        InAppNotification::success(__('Password updated.'));

        return to_route('settings.password.edit');
    }
}
