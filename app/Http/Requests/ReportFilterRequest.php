<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Validation\Rule;

class ReportFilterRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'integer', Rule::exists(Client::class, 'id')],
            'project_id' => ['nullable', 'integer', Rule::exists(Project::class, 'id')],
            'date_range' => [
                'nullable',
                'string',
                Rule::in(['this_week', 'last_week', 'this_month', 'last_month', 'this_year', 'last_year']),
            ],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ];
    }
}
