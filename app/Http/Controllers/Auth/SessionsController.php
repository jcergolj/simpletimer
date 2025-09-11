<?php

namespace App\Http\Controllers\Auth;

use App\Facades\TenantDatabaseServiceFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreSessionRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class SessionsController extends Controller
{
    public function create(Request $request): RedirectResponse|View
    {
        if (TenantDatabaseServiceFacade::isMainDomain($request) && ! Config::get('app.single_user_mode')) {
            InAppNotification::error(_('You can only login on your subdomain.'));

            return to_route('home');
        }

        return view('auth.login');
    }

    public function store(StoreSessionRequest $request): RedirectResponse
    {
        if (TenantDatabaseServiceFacade::isMainDomain($request) && ! Config::get('app.single_user_mode')) {
            InAppNotification::error(_('You can only login on your subdomain.'));

            return to_route('home');
        }

        $this->ensureIsNotRateLimited($request);

        if (! Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request), config('auth.throttle.login.decay_minutes') * 60);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));
        Session::regenerate();

        return redirect()->intended(default: route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        if ($request->wasFromHotwireNative()) {
            return redirect(route('login'));
        }

        return redirect('/');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        $maxAttempts = config('auth.throttle.login.max_attempts');

        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), $maxAttempts)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }
}
