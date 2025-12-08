<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\EmployeeDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class MovementRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'country_id',
        'date',
        'status',
        
        'start_time',
        'end_time',
        'duration',
        'meeting_type',
        'company',
        'contact_person',
        'contact_number',
        'purpose',
        'area',
        'transport',
        'cost',
        'value',
        'value_status',
        'comments',
        'edit_status',
        'edit_requested_by',
        'edit_requested_at',
        'edit_approved_by',
        'edit_approved_at',
    ];

    protected $casts = [
        'date' => 'date',
        'cost' => 'decimal:2',
        'value' => 'decimal:2',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'duration' => 'datetime:H:i:s',
         'edit_requested_at' => 'datetime',
        'edit_approved_at' => 'datetime',
    ];

    /**
     * Get the admin that owns the movement record.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the country through admin.
     */
    public function country()
    {
        return $this->hasOneThrough(
            Country::class,
            Admin::class,
            'id', // Foreign key on Admin table
            'id', // Foreign key on Country table
            'admin_id', // Local key on MovementRecord table
            'country_id' // Local key on Admin table
        );
    }

    /**
     * Get the employee department through admin.
     */
    public function employeeDepartment()
    {
        return $this->hasOneThrough(
            EmployeeDepartment::class,
            Admin::class,
            'id', // Foreign key on Admin table
            'id', // Foreign key on EmployeeDepartment table
            'admin_id', // Local key on MovementRecord table
            'employee_department_id' // Local key on Admin table
        );
    }


    // Helper method to check if user can edit
    public function getCanEditAttribute()
    {
        $currentAdminId = auth()->guard('admin')->id();
        
        // If user is the one who requested edit and it's approved, they can edit
        if ($this->edit_status === 'approved' && 
            $this->edit_requested_by == $currentAdminId) {
            return true;
        }
        
        // If no edit request exists and user is the creator, they can edit
        if (is_null($this->edit_status) && 
            $this->admin_id == $currentAdminId) {
            return true;
        }
        
        return false;
    }

    // Relationship with admin who created the record
    // public function admin(): BelongsTo
    // {
    //     return $this->belongsTo(Admin::class, 'admin_id');
    // }

    // Relationship with admin who requested edit
    public function editRequester(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'edit_requested_by');
    }

    // Relationship with admin who approved edit
    public function editApprover(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'edit_approved_by');
    }

    // // Relationship with country
    // public function country(): BelongsTo
    // {
    //     return $this->belongsTo(Country::class);
    // }
    
    /**
 * Get the employee department through admin.
 */

/**
 * Alias for employeeDepartment relationship.
 */
// App\Models\Admin.php
public function department()
{
    return $this->belongsTo(EmployeeDepartment::class, 'employee_department_id');
}

}