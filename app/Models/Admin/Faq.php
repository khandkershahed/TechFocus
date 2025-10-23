<?php

namespace App\Models\Admin;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relationship: Each FAQ belongs to a Dynamic Category.
     */
    public function dynamicCategory()
    {
        return $this->belongsTo(DynamicCategory::class, 'dynamic_category_id');
    }

    /**
     * Accessor: Get the dynamic category name directly as a property.
     * Example: $faq->category_name
     */
    public function getCategoryNameAttribute()
    {
        return $this->dynamicCategory->name ?? 'Uncategorized';
    }

    /**
     * Scope: Only published FAQs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
