<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Brand; // ✅ Ensure Brand model is imported

class NewsTrend extends Model
{
    use HasFactory;

    protected $table = 'news_trends';

    protected $fillable = [
        'title',
        'author',
        'badge',
        'featured',
        'type',
        'brand_id',
        'category_id',
        'industry_id',
        'solution_id',
        'product_id',
        'thumbnail_image',
        'banner_image',
        'source_image',
        'short_des',
        'long_des',
        'tags',
        'address',
        'header',
        'footer',
        'additional_button_name',
        'additional_url',
        'source_link',
        'added_by',
    ];

    /**
     * 🔹 Cast JSON fields to arrays
     */
    protected $casts = [
        'brand_id'    => 'array',
        'category_id' => 'array',
        'industry_id' => 'array',
        'solution_id' => 'array',
        'product_id'  => 'array',
    ];

    /**
     * 🔹 Scope: filter by type (news, trends, blogs, client_stories, tech_contents)
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 🔹 Scope: filter by brand (JSON field)
     */
    public function scopeForBrand($query, $brandId)
    {
        return $query->whereJsonContains('brand_id', $brandId);
    }

    /**
     * 🔹 Scope: featured only
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', '1');
    }

    /**
     * 🔹 Scope: trending (last 30 days)
     */
    public function scopeTrending($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * 🔹 Relationship: admin/user who added the item
     */
    public function addedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by');
    }

    /**
     * 🔹 Helper: get Brand models safely from JSON IDs
     */
    public function brands()
    {
        $ids = is_array($this->brand_id) ? $this->brand_id : json_decode($this->brand_id, true) ?? [];
        return Brand::whereIn('id', $ids)->get();
    }

    /**
     * 🔹 Helper: get the first associated Brand safely
     */
    public function firstBrand()
    {
        $ids = is_array($this->brand_id) ? $this->brand_id : json_decode($this->brand_id, true) ?? [];
        return Brand::find($ids[0] ?? null);
    }
}
