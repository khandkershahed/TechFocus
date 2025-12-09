<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes|required|in:present,late,absent,on_leave,work_from_field',
            'join_time' => 'nullable|date',
            'leave_time' => 'nullable|date|after_or_equal:join_time',
            'notes' => 'nullable|string|max:500',
            'requires_approval' => 'boolean',
            'is_approved' => 'boolean',
        ];
    }
}