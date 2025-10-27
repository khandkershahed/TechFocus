<?php

namespace App\Models\Rfq;

use App\Models\Admin;
use App\Models\Admin\Product;
use App\Models\Rfq\RfqProduct;
use App\Models\Admin\SolutionDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_code',
        'sales_man_id_L1',
        'sales_man_id_T1',
        'sales_man_id_T2',
        'user_id',
        'client_id',
        'partner_id',
        'product_id',
        'solution_id',
        'client_type',
        'name',
        'email',
        'phone',
        'company_name',
        'designation',
        'address',
        'country',
        'city',
        'zip_code',
        'is_reseller',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_company_name',
        'shipping_designation',
        'shipping_address',
        'shipping_country',
        'shipping_city',
        'shipping_zip_code',
        'end_user_name',
        'end_user_email',
        'end_user_phone',
        'end_user_company_name',
        'end_user_designation',
        'end_user_address',
        'end_user_country',
        'end_user_city',
        'end_user_zip_code',
        'project_name',
        'close_date',
        'sale_date',
        'pq_code',
        'pqr_code_one',
        'pqr_code_two',
        'qty',
        'category',
        'brand',
        'industry',
        'solution',
        'image',
        'message',
        'rfq_type',
        'call',
        'regular',
        'special',
        'tax_status',
        'deal_type',
        'status',
        'confirmation',
        'tax',
        'vat',
        'total_price',
        'quoted_price',
        'price_text',
        'currency',
        'rfq_department',
        'delivery_location',
        'budget',
        'project_status',
        'approximate_delivery_time',
        'client_po',
        'client_payment_pdf',
        'deal_code',
        'products_data',
        'is_contact_address',
        'end_user_is_contact_address',
    ];

    protected $casts = [
        'close_date' => 'datetime',
        'sale_date' => 'datetime',
        'tax' => 'decimal:2',
        'vat' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quoted_price' => 'decimal:2',
        'budget' => 'decimal:2',
        'qty' => 'integer',
        'category' => 'array',
        'brand' => 'array',
        'industry' => 'array',
        'solution' => 'array',
        'is_reseller' => 'boolean',
        'is_contact_address' => 'boolean',
        'end_user_is_contact_address' => 'boolean',
        'products_data' => 'array',
    ];

    protected $attributes = [
        'client_type' => 'anonymous',
        'rfq_type' => 'rfq',
        'status' => 'rfq_created',
        'deal_type' => 'new',
        'project_status' => 'pending',
        'is_reseller' => false,
        'is_contact_address' => false,
        'end_user_is_contact_address' => false,
    ];

    // ------------------- Relations -------------------
    public function salesmanL1()
    {
        return $this->belongsTo(Admin::class, 'sales_man_id_L1');
    }

    public function salesmanT1()
    {
        return $this->belongsTo(Admin::class, 'sales_man_id_T1');
    }

    public function salesmanT2()
    {
        return $this->belongsTo(Admin::class, 'sales_man_id_T2');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

    public function partner()
    {
        return $this->belongsTo(\App\Models\User::class, 'partner_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function solution()
    {
        return $this->belongsTo(SolutionDetail::class, 'solution_id');
    }

    public function rfqProducts()
    {
        return $this->hasMany(RfqProduct::class, 'rfq_id');
    }

    // ------------------- Products Data Helpers -------------------
    public function getProductsAttribute()
    {
        return $this->products_data ?? [];
    }

    public function getHasProductsAttribute()
    {
        return !empty($this->products_data) && is_array($this->products_data) && count($this->products_data) > 0;
    }

    public function getProductsCountAttribute()
    {
        return $this->has_products ? count($this->products_data) : 0;
    }

    public function getTotalQuantityAttribute()
    {
        if (!$this->has_products) {
            return $this->rfqProducts->sum('qty') ?? 0;
        }

        return array_sum(array_map(fn($p) => $p['qty'] ?? 0, $this->products_data));
    }

    public function getGrandTotalAttribute()
    {
        if (!$this->has_products) {
            return $this->rfqProducts->sum('grand_total') ?? 0;
        }

        return array_sum(array_map(fn($p) => $p['grand_total'] ?? $p['total_price'] ?? 0, $this->products_data));
    }

    public function addProduct($productData)
    {
        $products = $this->products_data ?? [];
        $products[] = $productData;
        $this->products_data = $products;
        return $this;
    }

    public function removeProduct($index)
    {
        $products = $this->products_data ?? [];
        if (isset($products[$index])) {
            unset($products[$index]);
            $this->products_data = array_values($products);
        }
        return $this;
    }

    public function updateTotals()
    {
        $this->qty = $this->total_quantity;
        $this->total_price = $this->grand_total;
        $this->quoted_price = $this->grand_total;
        return $this;
    }

    // ------------------- Scopes -------------------
    public function scopeByRfqCode($query, $rfqCode)
    {
        return $query->where('rfq_code', $rfqCode);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeClientType($query, $clientType)
    {
        return $query->where('client_type', $clientType);
    }

    // ------------------- Accessors -------------------
    public function getFormattedCreateDateAttribute()
    {
        return $this->created_at?->timezone('Asia/Dhaka')->format('F j, Y g:i A');
    }

    public function getMessagePreviewAttribute()
    {
        if (empty($this->message)) return 'No message';
        return strlen($this->message) > 100 ? substr($this->message, 0, 100) . '...' : $this->message;
    }

    public function getHasShippingAddressAttribute()
    {
        return !empty($this->shipping_name) && !empty($this->shipping_address);
    }

    public function getHasEndUserAttribute()
    {
        return !empty($this->end_user_name) && !empty($this->end_user_company_name);
    }

    public function getPrimaryContactAttribute()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company_name,
            'designation' => $this->designation,
        ];
    }

    public function getAllProductsAttribute()
    {
        $products = [];

        if ($this->has_products) {
            foreach ($this->products_data as $index => $product) {
                $products[] = [
                    'source' => 'products_data',
                    'index' => $index,
                    'product_name' => $product['product_name'] ?? 'Unknown Product',
                    'qty' => $product['qty'] ?? 1,
                    'sku_no' => $product['sku_no'] ?? null,
                    'model_no' => $product['model_no'] ?? null,
                    'brand_name' => $product['brand_name'] ?? null,
                    'additional_info' => $product['additional_info'] ?? null,
                ];
            }
        }

        foreach ($this->rfqProducts as $rfqProduct) {
            $products[] = [
                'source' => 'rfq_products',
                'id' => $rfqProduct->id,
                'product_name' => $rfqProduct->product_name,
                'qty' => $rfqProduct->qty,
                'sku_no' => $rfqProduct->sku_no,
                'model_no' => $rfqProduct->model_no,
                'brand_name' => $rfqProduct->brand_name,
                'additional_info' => $rfqProduct->additional_info,
                'image' => $rfqProduct->image,
            ];
        }

        return $products;
    }

    // ------------------- Boot Method -------------------
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate RFQ code if not set
            if (empty($model->rfq_code)) {
                $today = now()->format('ymd');
                $lastCode = self::where('rfq_code', 'like', "$today-%")->latest('id')->first();

                $newNumber = $lastCode ? ((int)explode('-', $lastCode->rfq_code)[1] + 1) : 1;
                $model->rfq_code = $today . '-' . $newNumber;
            }

            // Generate deal code if not set
            if (empty($model->deal_code)) {
                $model->deal_code = 'DEAL-' . $model->rfq_code;
            }
        });
    }
}
