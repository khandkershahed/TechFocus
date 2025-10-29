<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use App\Models\Admin\CatalogCategory;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admin\Product;

class Category extends Model
{
    use HasFactory, Userstamps, HasSlug;

    protected $guarded = [];

    protected $slugSourceColumn = 'name';

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentName(): ?string
    {
        return $this->parent ? $this->parent->name : null;
    }

    // ✅ JSON-based accessor for products
    public function getProductsAttribute()
    {
        return Product::whereJsonContains('category_id', $this->id)->get();
    }

    public function catalogs()
    {
        return $this->hasMany(CatalogCategory::class, 'category_id', 'category_id');
    }
    public function products()
{
    return $this->hasMany(Product::class)->orderBy('name', 'ASC');
}

}