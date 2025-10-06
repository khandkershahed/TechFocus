<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\NewsTrend;

class Brand extends Model
{
    protected $fillable = ['title', 'slug', 'logo', 'image', 'status'];

    /**
     * Brand page relationship
     */
    public function brandPage()
    {
        return $this->hasOne(BrandPage::class);
    }

    /**
     * Get all news/trends that reference this brand in JSON
     * Returns a query builder, not a collection
     */
    public function newsTrends()
    {
        return NewsTrend::whereJsonContains('brand_id', $this->id);
    }
}
