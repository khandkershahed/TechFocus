<?php

namespace App\Models\HR;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    use HasFactory, HasSlug, Userstamps;

    protected $guarded = [];

    // Automatically generate slug from title
    protected $slugSourceColumn = 'title';

    // Cast JSON fields to array
    protected $casts = [
        'supervisors' => 'array',
        'notify_id'   => 'array',
    ];

    // Relationship: One EmployeeTask has many Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_task_id');
    }
}
