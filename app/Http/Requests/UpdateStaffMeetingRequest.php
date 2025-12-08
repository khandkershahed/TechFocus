<?php
// app/Http/Requests/UpdateStaffMeetingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class UpdateStaffMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'admin_id' => 'nullable|exists:admins,id',
            'lead_by' => 'nullable|exists:admins,id',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:admins,id',
            'type' => 'required|in:office,out_of_office',
            'category' => 'required|in:management,departmental,training,hr_policy_compliance,client_review,project_review,weekly_coordination,emergency_meeting',
            'department' => 'nullable|string|max:100',
            'platform' => 'required|in:office,online,client_office,training_center',
            'online_platform' => 'required_if:platform,online|in:zoom,google_meet,teams',
            'organizer_id' => 'nullable|exists:admins,id',
            'agenda' => 'nullable|string|max:1000',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // Max 10MB per file
            'status' => 'required|in:scheduled,rescheduled,cancelled,completed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'end_time.after' => 'End time must be after start time.',
            'online_platform.required_if' => 'Please specify the online platform when selecting online meeting.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'Meeting Title',
            'date' => 'Meeting Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'category' => 'Meeting Category',
            'platform' => 'Meeting Platform',
        ];
    }
    
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->date && $this->start_time && $this->end_time) {
                $startDateTime = Carbon::parse($this->date . ' ' . $this->start_time);
                $endDateTime = Carbon::parse($this->date . ' ' . $this->end_time);
                
                if ($endDateTime <= $startDateTime) {
                    $validator->errors()->add('end_time', 'End time must be after start time.');
                }
            }
        });
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $this->recordErrorMessages($validator);
        parent::failedValidation($validator);
    }

    /**
     * Record the error messages displayed to the user.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function recordErrorMessages(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        foreach ($errorMessages as $errorMessage) {
            session()->flash('error', $errorMessage);
        }
    }
}