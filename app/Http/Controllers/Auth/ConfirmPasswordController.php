<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreConfirmPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.confirm-password');
    }

    public function store(StoreConfirmPasswordRequest $request): RedirectResponse
    {
        throw_unless(Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->input('password'),
        ]), ValidationException::withMessages([
            'password' => __('auth.password'),
        ]));

        session(['auth.password_confirmed_at' => Carbon::now()->getTimestamp()]);

        return redirect()->intended(default: route('dashboard', absolute: false));
    }
}
