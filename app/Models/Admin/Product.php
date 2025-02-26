<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasSlug, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
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
        return Category::whereIn('id', $this->category_id)->get();
    }
    // Define the many-to-many relationship with solutions
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

}
