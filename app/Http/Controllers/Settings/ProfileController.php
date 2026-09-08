<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\DeleteProfileRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Services\SubdomainUrlBuilder;
use App\Services\TenantDatabaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.profile.edit', [
            'username' => $request->user()->username,
            'email' => $request->user()->email,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->update(['email' => $validated['email']]);

        InAppNotification::success(__('Profile updated.'));

        return to_route('settings.profile.edit');
    }

    public function delete(): View
    {
        return view('settings.profile.delete');
    }

    public function destroy(DeleteProfileRequest $request, TenantDatabaseService $tenantDb, SubdomainUrlBuilder $urlBuilder): RedirectResponse
    {
        $user = $request->user();
        $subdomain = Config::get('app.single_user_mode')
            ? null
            : $tenantDb->extractSubdomain($request);

        Auth::guard('web')->logout();

        DB::transaction(function () use ($user): void {
            TimeEntry::query()->delete();
            Project::query()->delete();
            Client::query()->delete();
            $user->delete();
        });

        Session::invalidate();
        Session::regenerateToken();

        if ($subdomain !== null) {
            $tenantDb->deleteTenantDatabase($subdomain);

            return redirect($urlBuilder->buildMainDomain());
        }

        return redirect('/');
    }
}
