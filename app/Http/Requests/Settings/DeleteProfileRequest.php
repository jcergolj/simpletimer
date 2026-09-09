<?php

declare(strict_types=1);

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
