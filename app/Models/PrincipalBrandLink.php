<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Models\Admin\Brand;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrincipalBrandLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'brand_id',
        'authorization_type',
        'auth_doc_url',
        'valid_from',
        'valid_to'
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}

