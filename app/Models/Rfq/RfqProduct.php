<?php

namespace App\Models\Rfq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;
use App\Models\Rfq\Rfq;

class RfqProduct extends Model
{
    use HasFactory;

    protected $table = 'rfq_products';

    protected $fillable = [
        'rfq_id',
        'product_id',
        'product_name',
        'qty',
        'unit_price',
        'discount',
        'discount_price',
        'total_price',
        'sub_total',
        'tax',
        'tax_price',
        'vat',
        'vat_price',
        'grand_total',
        'sku_no',
        'model_no',
        'brand_name',
        'additional_product_name',
        'additional_qty',
        'image',
        'product_des',
        'additional_info',
    ];

    protected $casts = [
        'qty' => 'integer',
        'additional_qty' => 'integer',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'tax' => 'decimal:2',
        'tax_price' => 'decimal:2',
        'vat' => 'decimal:2',
        'vat_price' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected $appends = [
        'formatted_grand_total',
        'formatted_unit_price',
        'formatted_sub_total',
    ];

    /** ✅ Relationship with RFQ */
    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'rfq_id');
    }

    /** ✅ Relationship with Product */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /** ✅ Calculate prices automatically */
    public function calculatePrices()
    {
        // Calculate total price before discounts
        $this->total_price = $this->qty * (float) $this->unit_price;
        
        // Calculate discount price (percentage based)
        $this->discount_price = ((float) $this->total_price * (float) $this->discount) / 100;
        
        // Calculate subtotal after discount
        $this->sub_total = (float) $this->total_price - (float) $this->discount_price;
        
        // Calculate tax price
        $this->tax_price = ((float) $this->sub_total * (float) $this->tax) / 100;
        
        // Calculate VAT price
        $this->vat_price = ((float) $this->sub_total * (float) $this->vat) / 100;
        
        // Calculate grand total
        $this->grand_total = (float) $this->sub_total + (float) $this->tax_price + (float) $this->vat_price;
        
        return $this;
    }

    /** ✅ Boot method for automatic calculations */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Ensure numeric values
            $model->qty = (int) $model->qty;
            $model->unit_price = (float) $model->unit_price;
            $model->discount = (float) ($model->discount ?? 0);
            $model->tax = (float) ($model->tax ?? 0);
            $model->vat = (float) ($model->vat ?? 0);
            
            $model->calculatePrices();
        });

        static::created(function ($model) {
            // Update RFQ totals when new product is added
            if ($model->rfq) {
                $model->rfq->touch();
            }
        });

        static::updated(function ($model) {
            // Update RFQ totals when product is updated
            if ($model->rfq) {
                $model->rfq->touch();
            }
        });

        static::deleted(function ($model) {
            // Update RFQ totals when product is deleted
            if ($model->rfq) {
                $model->rfq->touch();
            }
        });
    }

    /** ✅ Scope for specific RFQ */
    public function scopeForRfq($query, $rfqId)
    {
        return $query->where('rfq_id', $rfqId);
    }

    /** ✅ Accessor for formatted prices */
    public function getFormattedGrandTotalAttribute()
    {
        return number_format($this->grand_total, 2);
    }

    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 2);
    }

    public function getFormattedSubTotalAttribute()
    {
        return number_format($this->sub_total, 2);
    }

    /** ✅ Check if product has discount */
    public function getHasDiscountAttribute()
    {
        return $this->discount > 0;
    }

    /** ✅ Get effective price after discount */
    public function getEffectivePriceAttribute()
    {
        return $this->unit_price * (1 - ($this->discount / 100));
    }

    /** ✅ Get formatted effective price */
    public function getFormattedEffectivePriceAttribute()
    {
        return number_format($this->effective_price, 2);
    }

    
}