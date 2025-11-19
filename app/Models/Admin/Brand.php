<?php

namespace App\Models\Admin;

use App\Models\Country;
use App\Models\Principal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'country_id',
        'title',
        'slug',
        'description',
        'image',
        'logo',
        'website_url',
        'category',
        'status',
        'rejection_reason',
        'approved_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relationship with BrandPage - One brand can have one brand page
     */
    public function brandPage()
    {
        return $this->hasOne(BrandPage::class, 'brand_id');
    }

    public function brandProducts()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    // If you already have 'products', maybe 'brandProducts' is redundant
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByPrincipal($query, $principalId)
    {
        return $query->where('principal_id', $principalId);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get brands that have brand pages
     */
    public function scopeHasBrandPage($query)
    {
        return $query->whereHas('brandPage');
    }

    /**
     * Scope to get brands that don't have brand pages
     */
    public function scopeDoesntHaveBrandPage($query)
    {
        return $query->whereDoesntHave('brandPage');
    }

    /**
     * Scope to get brands with their brand pages
     */
    public function scopeWithBrandPage($query)
    {
        return $query->with('brandPage');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'approved' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger'
        ];

        return '<span class="badge bg-' . ($badges[$this->status] ?? 'secondary') . '">' . ucfirst($this->status) . '</span>';
    }

    public function getIsApprovedAttribute()
    {
        return $this->status === 'approved';
    }

    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    public function getIsRejectedAttribute()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if brand has a brand page
     */
    public function getHasBrandPageAttribute()
    {
        return $this->brandPage()->exists();
    }

    /**
     * Get brand page status
     */
    public function getBrandPageStatusAttribute()
    {
        return $this->brandPage ? 'Created' : 'Not Created';
    }

    /**
     * Get display name with status indicator
     */
    public function getDisplayNameAttribute()
    {
        $statusIcon = $this->has_brand_page ? '✅' : '❌';
        return "{$this->title} {$statusIcon}";
    }

    /**
     * Automatically generate slug when creating brand
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = \Illuminate\Support\Str::slug($brand->title);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('title') && empty($brand->slug)) {
                $brand->slug = \Illuminate\Support\Str::slug($brand->title);
            }
        });
    }
}