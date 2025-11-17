<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShareToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'principal_link_id',
        'principal_id',
        'expires_at',
        'settings',
        'view_count'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'settings' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->token = Str::uuid();
        });
    }

    public function principalLink()
    {
        return $this->belongsTo(PrincipalLink::class);
    }

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}