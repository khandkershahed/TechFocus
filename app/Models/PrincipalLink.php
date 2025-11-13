<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalLink extends Model
{
    use HasFactory;

    protected $fillable = ['principal_id', 'label', 'url'];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }
}
