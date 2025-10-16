<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Cast date/time fields properly
    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'start_time'  => 'datetime:H:i',
        'end_time'    => 'datetime:H:i',
        'buffer_time' => 'datetime:H:i',
    ];

    // Relationship: Each Task belongs to one EmployeeTask
    public function employeeTask()
    {
        return $this->belongsTo(EmployeeTask::class, 'employee_task_id');
    }

    // Relationship: Each Task belongs to one Employee
    public function employee()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'employee_id');
    }
}
