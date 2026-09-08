<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\AppFormRequest;

class DeleteProfileRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'current_password'],
        ];
    }
}
