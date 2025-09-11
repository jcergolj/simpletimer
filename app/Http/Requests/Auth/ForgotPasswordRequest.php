<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AppFormRequest;

class ForgotPasswordRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }
}
