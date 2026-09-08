<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Validation\Rule;

class TimeEntryIndexRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'integer', Rule::exists(Client::class, 'id')],
            'project_id' => ['nullable', 'integer', Rule::exists(Project::class, 'id')],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ];
    }
}
