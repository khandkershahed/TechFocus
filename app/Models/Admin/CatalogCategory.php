<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogCategory extends Model
{
    use HasFactory;

    protected $table = 'catalog_categories';
    protected $primaryKey = 'category_id'; 
    public $incrementing = true;
    protected $guarded = [];

    // Relationship back to Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
