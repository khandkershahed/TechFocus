<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class AdminScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id', 'scope_type', 'scope_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeable()
    {
        return $this->morphTo();
    }

    // Helper methods to check scope
    public function isBrandScope()
    {
        return $this->scope_type === 'brand';
    }

    public function isCategoryScope()
    {
        return $this->scope_type === 'category';
    }

    public function isSolutionScope()
    {
        return $this->scope_type === 'solution';
    }

    public function isCountryScope()
    {
        return $this->scope_type === 'country';
    }
}