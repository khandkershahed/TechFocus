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

    public function scopeByCategory($query, $category)
{
    return $query->where('category', $category);
}
public function brandPage()
{
    return $this->hasOne(\App\Models\Admin\BrandPage::class, 'brand_id');
}

}