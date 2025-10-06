<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Catalog extends Model
{
    use HasFactory, HasSlug, Userstamps;

    protected $guarded = [];

    protected $slugSourceColumn = 'name';

    protected $casts = [
        'brand_id'    => 'array',
        'product_id'  => 'array',
        'industry_id' => 'array',
        'solution_id' => 'array',
        'company_id'  => 'array',
        // Remove categories_id from casts since we're using pivot table
    ];

    public function attachments()
    {
        return $this->hasMany(CatalogAttachment::class);
    }

    
}