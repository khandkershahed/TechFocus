<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasSlug, Userstamps;

    protected $guarded = [];
    protected $slugSourceColumn = 'name';
    protected $casts = [
        'category_id' => 'array',
        'color_id'    => 'array',
        'parent_id'   => 'array',
        'child_id'    => 'array',
    ];

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'industry_products', 'product_id', 'industry_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        // Safely decode category_id
        $ids = [];
        if (is_array($this->category_id)) {
            $ids = $this->category_id;
        } elseif (is_string($this->category_id)) {
            $ids = json_decode($this->category_id, true) ?: [];
        }

        return \App\Models\Admin\Category::whereIn('id', $ids)->get();
    }

    public function solutions()
    {
        return $this->belongsToMany(SolutionDetail::class, 'solution_products', 'product_id', 'solution_id');
    }

    public function multiImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productIndustries()
    {
        return $this->hasMany(IndustryProduct::class);
    }

    public function productSolutions()
    {
        return $this->hasMany(SolutionProduct::class);
    }

    public function productSas()
    {
        return $this->hasOne(ProductSas::class);
    }

    // Optional helper methods for safe access
    public function getColorIds(): array
    {
        return is_array($this->color_id) ? $this->color_id : (json_decode($this->color_id, true) ?? []);
    }

    public function getParentIds(): array
    {
        return is_array($this->parent_id) ? $this->parent_id : (json_decode($this->parent_id, true) ?? []);
    }

    public function getChildIds(): array
    {
        return is_array($this->child_id) ? $this->child_id : (json_decode($this->child_id, true) ?? []);
    }
}
