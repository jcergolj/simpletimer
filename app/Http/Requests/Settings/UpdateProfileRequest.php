<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\AppFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
        ];
    }
}
