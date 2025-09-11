<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AppFormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }
}
