<?php

namespace App\Models\Admin;

use App\Traits\HasSlug;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function products()
    {
        return Product::whereJsonContains('category_id', json_encode($this->id));
    }

    public function catalogs()
    {
        return $this->hasMany(CatalogCategory::class, 'category_id');
    }

}