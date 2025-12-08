<?php

namespace App\Models;

use App\Models\Admin\Role;
use App\Traits\HasAdminAccess;
use App\Models\Admin\Permission;
use Laravel\Sanctum\HasApiTokens;
use Wildside\Userstamps\Userstamps;
use App\Models\Admin\EmployeeCategory;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\Admin\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Admin\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements MustVerifyEmail
{

     use HasRoles, HasAdminAccess;

    protected $fillable = [
        'name', 'email', 'password',
    ];


    // Specify guard for spatie permission
    protected $guard_name = 'admin'; // or 'web' depending on your setup
    use HasApiTokens, HasFactory, Notifiable, Userstamps, HasRoles;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Auto hash password when creating/updating
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::needsRehash($value) ? \Hash::make($value) : $value;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Optional: Get category name for the admin
     *
     * @return string|null
     */
    public function getCategoryName()
    {
        return EmployeeCategory::where('id', $this->category_id)->value('name');
    }

    /**
     * Optional: Direct relationships if you need custom tables
     * (Spatie handles roles/permissions automatically with HasRoles)
     */
    public function rolesCustom()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissionsCustom()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }
        public function noteReplies(): HasMany
    {
        return $this->hasMany(NoteReply::class, 'user_id')
            ->where('user_type', self::class);
    }
 public function department()
{
    return $this->belongsTo(\App\Models\Admin\EmployeeDepartment::class, 'employee_department_id');
}



    
}
