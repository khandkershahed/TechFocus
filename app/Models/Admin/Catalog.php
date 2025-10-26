<?php

namespace App\Models\Admin;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = [
        'category',
        'brand_id',
        'product_id', 
        'industry_id',
        'solution_id',
        'company_id',
        'name',
        'page_number',
        'description',
        'company_button_name',
        'company_button_link',
        'thumbnail',
        'document'
    ];

    protected $casts = [
        'brand_id' => 'array',
        'product_id' => 'array',
        'industry_id' => 'array',
        'solution_id' => 'array',
        'company_id' => 'array',
    ];



//  protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($catalog) {
//             if (empty($catalog->slug) && !empty($catalog->name)) {
//                 $catalog->slug = Str::slug($catalog->name);
//             }
//         });

//         static::updating(function ($catalog) {
//             if (empty($catalog->slug) && !empty($catalog->name)) {
//                 $catalog->slug = Str::slug($catalog->name);
//             }
//         });
//     }

    // Remove the many-to-many relationships and replace with accessors

    public function getBrandsAttribute()
    {
        if (!$this->brand_id || $this->brand_id === '[]') {
            return collect();
        }
        
        $brandIds = json_decode($this->brand_id, true);
        if (empty($brandIds)) {
            return collect();
        }
        
        return Brand::whereIn('id', $brandIds)->get();
    }

    public function getProductsAttribute()
    {
        if (!$this->product_id || $this->product_id === '[]') {
            return collect();
        }
        
        $productIds = json_decode($this->product_id, true);
        if (empty($productIds)) {
            return collect();
        }
        
        return Product::whereIn('id', $productIds)->get();
    }

    public function getIndustriesAttribute()
    {
        if (!$this->industry_id || $this->industry_id === '[]') {
            return collect();
        }
        
        $industryIds = json_decode($this->industry_id, true);
        if (empty($industryIds)) {
            return collect();
        }
        
        return Industry::whereIn('id', $industryIds)->get();
    }

    public function getCompaniesAttribute()
    {
        if (!$this->company_id || $this->company_id === '[]') {
            return collect();
        }
        
        $companyIds = json_decode($this->company_id, true);
        if (empty($companyIds)) {
            return collect();
        }
        
        return Company::whereIn('id', $companyIds)->get();
    }

    public function attachments()
    {
        return $this->hasMany(CatalogAttachment::class);
    }
}