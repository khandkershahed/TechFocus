<?php

namespace App\Models\Admin;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandPage extends Model
{
    use HasFactory, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // Relationships with rows
    public function rowFour()
    {
        return $this->belongsTo(Row::class, 'row_four_id');
    }
    
    public function rowFive()
    {
        return $this->belongsTo(Row::class, 'row_five_id');
    }
    
    public function rowSeven()
    {
        return $this->belongsTo(Row::class, 'row_seven_id');
    }
    
    public function rowEight()
    {
        return $this->belongsTo(Row::class, 'row_eight_id');
    }
    
    // Relationships with solution cards
    public function solutionCardOne()
    {
        return $this->belongsTo(SolutionCard::class, 'solution_card_one_id');
    }
    
    public function solutionCardTwo()
    {
        return $this->belongsTo(SolutionCard::class, 'solution_card_two_id');
    }
    
    public function solutionCardThree()
    {
        return $this->belongsTo(SolutionCard::class, 'solution_card_three_id');
    }

    // Relationship with brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get brand name safely with fallback
     */
    public function brandName()
    {
        return $this->brand ? $this->brand->title : 'N/A';
    }

    /**
     * Get brand status through relationship
     */
    public function getBrandStatusAttribute()
    {
        return $this->brand ? $this->brand->status : 'unknown';
    }

    /**
     * Check if brand is approved
     */
    public function getIsBrandApprovedAttribute()
    {
        return $this->brand && $this->brand->status === 'approved';
    }

    /**
     * Scope to only include brand pages with approved brands
     */
    public function scopeWithApprovedBrand($query)
    {
        return $query->whereHas('brand', function($query) {
            $query->where('status', 'approved');
        });
    }

    /**
     * Scope to include brand pages with specific brand status
     */
    public function scopeWithBrandStatus($query, $status)
    {
        return $query->whereHas('brand', function($query) use ($status) {
            $query->where('status', $status);
        });
    }
}