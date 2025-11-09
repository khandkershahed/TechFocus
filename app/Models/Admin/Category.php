<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use App\Models\Admin\CatalogCategory;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Admin\Product;

class Category extends Model
{
    use HasFactory, Userstamps, HasSlug;

    protected $guarded = [];

    protected $slugSourceColumn = 'name';

    /**
     * Parent category relation (lazy loaded only when needed)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Children categories relation
     */
    // public function children(): HasMany
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    /**
     * Return parent name (avoid N+1 queries by eager loading 'parent')
     */
    public function parentName(): ?string
    {
        return $this->parent ? $this->parent->name : null;
    }

    /**
     * Products related to this category.
     * Optimized with proper query, supports pagination.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('name', 'ASC');
    }

    /**
     * JSON-based products accessor (if product IDs are stored in JSON).
     * Use only when needed to avoid full table scan.
     */
    public function getJsonProductsAttribute()
    {
        return Product::whereJsonContains('category_id', $this->id);
        // Notice: do NOT call get() here for server-side usage; paginate or query instead
    }

    /**
     * Catalogs associated with this category
     */
    public function catalogs(): HasMany
    {
        return $this->hasMany(CatalogCategory::class, 'category_id', 'id');
    }

    /**
     * Scope: Only parent categories
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: Only child categories
     */
    public function scopeChildrenOf($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

// Direct children
public function children()
{
    return $this->hasMany(Category::class, 'parent_id', 'id');
}

// Recursive children
public function childrenRecursive()
{
    return $this->children()->select('id', 'name', 'slug', 'parent_id')->with('childrenRecursive');
}



}
