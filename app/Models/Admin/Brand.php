<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, HasSlug, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $slugSourceColumn = 'title';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to only include approved brands.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending brands.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include rejected brands.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get the brand products with optional product type filter.
     */
    public function brandProducts($productType = null)
    {
        $query = $this->hasMany(Product::class, 'brand_id')
            ->where('product_status', 'product');

        if ($productType) {
            $query->where('product_type', $productType);
        }

        return $query;
    }

    /**
     * Get all products for the brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /**
     * Get products by brand slug.
     */
    public static function getProductByBrand($slug)
    {
        return Brand::with('brandProducts')->where('slug', $slug)->firstOrFail();
    }

    /**
     * Get the brand page associated with the brand.
     */
    public function brandPage()
    {
        return $this->hasOne(BrandPage::class);
    }

    /**
     * Get the principal that owns the brand.
     */
    public function principal()
    {
        return $this->belongsTo(\App\Models\Principal::class);
    }

    /**
     * Check if the brand is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the brand is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the brand is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Get the status badge class for UI.
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the status text for display.
     */
    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Approve the brand.
     */
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null
        ]);
    }

    /**
     * Reject the brand.
     */
    public function reject($reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => null
        ]);
    }

    // Usage examples:
    // $topProducts = Brand::byCategory('Top')->approved()->get();
    // $featuredProducts = Brand::byCategory('Featured')->approved()->get();
    // $softwareProducts = $brand->brandProducts('software')->get();
    // $hardwareProducts = $brand->brandProducts('hardware')->get();
    // $pendingBrands = Brand::pending()->with('principal')->get();
}