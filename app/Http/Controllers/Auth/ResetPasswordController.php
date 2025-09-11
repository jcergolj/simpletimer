<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ResetPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'email' => $request->get('email'),
        ]);
    }

    public function store(ResetPasswordRequest $request): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            abort(Response::HTTP_UNAUTHORIZED, __('Invalid request.'));
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            InAppNotification::error(__('We could not find a user with that email address.'));

            return back()->withInput($request->only('email'));
        }

        $user->forceFill([
            'password' => $request->password,
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        Session::regenerateToken();

        InAppNotification::success(__('Your password has been reset! You can now log in.'));

        return to_route('login');
    }
}
