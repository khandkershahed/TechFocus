<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class CatalogCategory extends Model
{
    use HasFactory, HasSlug, Userstamps;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Slug configuration
     */
    protected $slugSourceColumn = 'catalog'; // Change 'catalog' to the column you want slug from

    /**
     * Relationships
     */

    // Relation to main Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    
}
