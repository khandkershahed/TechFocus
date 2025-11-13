<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'file_url',
        'filename',
        'tag',
        'uploaded_by',
        'version'
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }
}

