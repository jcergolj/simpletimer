<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\URL;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            InAppNotification::success(__('If an account exists with that email, you will receive a password reset link.'));

            return back();
        }

        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addHour(),
            ['email' => $user->email]
        );

        $user->notify(new ResetPasswordNotification($resetUrl));

        InAppNotification::success(__('If an account exists with that email, you will receive a password reset link.'));

        return back();
    }
}
