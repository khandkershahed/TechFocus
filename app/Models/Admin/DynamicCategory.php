<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicCategory extends Model
{
    use HasFactory, HasSlug, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $slugSourceColumn = 'name';

    /**
     * Relationship: A category can have many FAQs
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'dynamic_category_id');
    }

    /**
     * Optional: parent category relationship
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Optional: children categories
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
