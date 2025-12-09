<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_id' => 'required|exists:staff_meetings,id',
            'staff_id' => 'required|exists:admins,id',
            'status' => 'required|in:present,late,absent,on_leave,work_from_field',
            'join_time' => 'nullable|date',
            'leave_time' => 'nullable|date|after_or_equal:join_time',
            'notes' => 'nullable|string|max:500',
            'device_ip' => 'nullable|ip',
        ];
    }
}