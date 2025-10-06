<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTrend extends Model
{
    use HasFactory;

    protected $table = 'news_trends';

    protected $casts = [
        'brand_id' => 'array', // ensures brand_id is treated as JSON array
        'category_id' => 'array',
        'industry_id' => 'array',
        'solution_id' => 'array',
        'product_id' => 'array',
    ];

    // Scope to filter trends by a given brand ID (JSON column)
    public function scopeForBrand($query, $brandId)
    {
        return $query->whereJsonContains('brand_id', $brandId);
    }

    // Scope for featured trends
    public function scopeFeatured($query)
    {
        return $query->where('featured', '1'); // must be string '1'
    }

    // Optional: trending scope (example: last 30 days)
    public function scopeTrending($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    // Relationships (if needed)
    public function brands()
    {
        // If you have Brand model and a method to get multiple brands
        return Brand::whereIn('id', $this->brand_id ?? [])->get();
    }

    public function firstBrand()
    {
        $ids = $this->brand_id ?? [];
        return Brand::find($ids[0] ?? null);
    }
}
