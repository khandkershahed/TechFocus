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
        'approved_at' => 'datetime', // Add this cast
    ];

    // Add these scopes for principal submission status
    public function scopeApproved($query)
    {
        return $query->where('submission_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('submission_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('submission_status', 'rejected');
    }

    // Principal relationship
    public function principal()
    {
        return $this->belongsTo(\App\Models\Principal::class);
    }

    // Status helper methods
    public function isApproved()
    {
        return $this->submission_status === 'approved';
    }

    public function isPending()
    {
        return $this->submission_status === 'pending';
    }

    public function isRejected()
    {
        return $this->submission_status === 'rejected';
    }

    public function getSubmissionStatusBadgeAttribute()
    {
        return match($this->submission_status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Approval methods
    public function approve()
    {
        $this->update([
            'submission_status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null
        ]);
    }

    public function reject($reason = null)
    {
        $this->update([
            'submission_status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => null
        ]);
    }

    // Your existing relationships
    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'industry_products', 'product_id', 'industry_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function newsTrends()
    {
        return $this->belongsToMany(NewsTrend::class, 'news_trend_products', 'product_id', 'news_trend_id');
    }


    
}