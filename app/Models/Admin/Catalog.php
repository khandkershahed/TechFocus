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

    // Improved accessors with better error handling
    public function getBrandsAttribute()
    {
        try {
            if (!$this->brand_id || $this->brand_id === '[]' || $this->brand_id === 'null') {
                return collect();
            }
            
            $brandIds = json_decode($this->brand_id, true);
            
            if (empty($brandIds) || !is_array($brandIds)) {
                return collect();
            }
            
            // Filter out any null or empty values
            $brandIds = array_filter($brandIds);
            
            if (empty($brandIds)) {
                return collect();
            }
            
            return Brand::whereIn('id', $brandIds)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function getProductsAttribute()
    {
        try {
            if (!$this->product_id || $this->product_id === '[]' || $this->product_id === 'null') {
                return collect();
            }
            
            $productIds = json_decode($this->product_id, true);
            
            if (empty($productIds) || !is_array($productIds)) {
                return collect();
            }
            
            $productIds = array_filter($productIds);
            
            if (empty($productIds)) {
                return collect();
            }
            
            return Product::whereIn('id', $productIds)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function getIndustriesAttribute()
    {
        try {
            if (!$this->industry_id || $this->industry_id === '[]' || $this->industry_id === 'null') {
                return collect();
            }
            
            $industryIds = json_decode($this->industry_id, true);
            
            if (empty($industryIds) || !is_array($industryIds)) {
                return collect();
            }
            
            $industryIds = array_filter($industryIds);
            
            if (empty($industryIds)) {
                return collect();
            }
            
            return Industry::whereIn('id', $industryIds)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function getCompaniesAttribute()
    {
        try {
            if (!$this->company_id || $this->company_id === '[]' || $this->company_id === 'null') {
                return collect();
            }
            
            $companyIds = json_decode($this->company_id, true);
            
            if (empty($companyIds) || !is_array($companyIds)) {
                return collect();
            }
            
            $companyIds = array_filter($companyIds);
            
            if (empty($companyIds)) {
                return collect();
            }
            
            return Company::whereIn('id', $companyIds)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function attachments()
    {
        return $this->hasMany(CatalogAttachment::class);
    }
}