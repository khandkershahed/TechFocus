<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalLink extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'url', 'type'];

    // Cast 'type' as array for JSON storage
    protected $casts = [
        'type' => 'array',
         'url' => 'array',
    'label' => 'array',
    ];
}
