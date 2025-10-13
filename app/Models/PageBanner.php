<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'slug',
        'image',
        'badge',
        'title',
        'button_name',
        'button_link',
        'banner_link',
        'status',
        'created_by',
        'updated_by',
    ];
}
