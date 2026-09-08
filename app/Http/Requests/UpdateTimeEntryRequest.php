<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Models\Project;
use Illuminate\Validation\Rule;

class UpdateTimeEntryRequest extends AppFormRequest
{
    public function rules(): array
    {
        $projectRule = Rule::exists(Project::class, 'id');

        if ($this->filled('client_id')) {
            $projectRule->where('client_id', (int) $this->input('client_id'));
        }

        return [
            'start_time' => ['required', 'date', 'before_or_equal:now'],
            'end_time' => ['required', 'date', 'after:start_time', 'before_or_equal:now'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'project_id' => ['nullable', $projectRule],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0', 'max:100000000'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'start_time.required' => 'Start time is required.',
            'start_time.date' => 'Start time must be a valid date.',
            'end_time.date' => 'End time must be a valid date.',
            'end_time.after' => 'End time must be after start time.',
            'duration.integer' => 'Duration must be a valid number.',
            'duration.min' => 'Duration must be at least 0.',
            'client_id.exists' => 'Selected client does not exist.',
            'project_id.exists' => 'Selected project does not exist.',
            'hourly_rate[amount].numeric' => 'Hourly rate must be a valid number.',
            'hourly_rate[amount].min' => 'Hourly rate must be at least 0.',
            'hourly_rate[currency].required_with' => 'Currency is required when hourly rate is specified.',
        ];
    }
}
