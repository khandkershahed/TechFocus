<?php
// app/Http/Requests/StoreStaffMeetingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreStaffMeetingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

  public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'start_time' => 'required|date_format:H:i', // Changed from Y-m-d\TH:i
        'end_time' => 'required|date_format:H:i',   // Changed from Y-m-d\TH:i
        'admin_id' => 'nullable|exists:admins,id',
        'lead_by' => 'nullable|exists:admins,id',
        'participants' => 'nullable|array',
        'participants.*' => 'exists:admins,id',
        'type' => 'required|in:office,out_of_office',
        'category' => 'required|in:management,departmental,training,hr_policy_compliance,client_review,project_review,weekly_coordination,emergency_meeting',
        'department' => 'nullable|string|max:100',
        'platform' => 'required|in:office,online,client_office,training_center',
        'online_platform' => 'required_if:platform,online|in:zoom,google_meet,teams',
        'organizer_id' => 'required|exists:admins,id', // Changed from nullable to required
        'agenda' => 'nullable|string|max:1000',
        'notes' => 'nullable|string',
        'attachments' => 'nullable|array',
        'attachments.*' => 'file|max:10240',
        'status' => 'required|in:scheduled,rescheduled,cancelled,completed',
    ];
}

    public function messages()
    {
        return [
            'end_time.after' => 'End time must be after start time.',
            'online_platform.required_if' => 'Please specify the online platform when selecting online meeting.',
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
}