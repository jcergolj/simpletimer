<?php

namespace App\Http\Requests\Auth;

use App\Enums\Currency;
use App\Http\Requests\AppFormRequest;
use App\Models\User;
use App\Rules\ValidSubdomain;
use App\Services\TenantDatabaseService;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRegistrationRequest extends AppFormRequest
{
    public function rules(): array
    {
        $usernameRules = [
            'required',
            'string',
            'min:3',
            'max:20',
            'regex:/^[a-z0-9_-]+$/',
            Rule::unique(User::class),
        ];

        if (! Config::get('app.single_user_mode')) {
            $usernameRules[] = new ValidSubdomain(app(TenantDatabaseService::class));
        }

        return [
            'username' => $usernameRules,
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
        ];
    }

    public function withValidator($validator): void
    {
        if (config('app.single_user_mode')) {
            $validator->after(function ($validator) {
                if (User::count() >= 1) {
                    $validator->errors()->add('username', 'Registration closed. Single-user mode allows one user only.');
                }
            });
        }
    }
}
