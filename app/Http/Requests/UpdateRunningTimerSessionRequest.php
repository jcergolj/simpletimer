<?php

namespace App\Http\Requests;

class UpdateRunningTimerSessionRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'time_entry_id' => ['required', 'integer', 'exists:time_entries,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'start_time' => ['required', 'date', 'before_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'time_entry_id.required' => __('Timer session is required.'),
            'time_entry_id.exists' => __('The timer session is invalid.'),
            'client_id.exists' => __('The selected client is invalid.'),
            'project_id.exists' => __('The selected project is invalid.'),
            'start_time.required' => __('Start time is required.'),
            'start_time.date' => __('Start time must be a valid date.'),
            'start_time.before_or_equal' => __('Start time cannot be in the future.'),
        ];
    }
}
