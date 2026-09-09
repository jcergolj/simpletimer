<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AppFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
