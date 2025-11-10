<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'contact_name',
        'job_title',
        'email',
        'phone_e164',
        'whatsapp_e164',
        'wechat_id',
        'preferred_channel',
        'is_primary',
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }
}
