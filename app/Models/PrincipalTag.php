<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalTag extends Model
{
    use HasFactory;

    protected $fillable = ['principal_id', 'tag_id'];
}
