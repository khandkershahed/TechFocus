<?php

namespace App\Models\Rfq;


use App\Models\Admin;
use App\Models\Admin\Product;
use App\Models\Rfq\RfqProduct;
use App\Models\Admin\SolutionDetail;
use Illuminate\Foundation\Auth\User;
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
        'create_date',
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
        
        // 🔥 NEW FIELDS from rfqCreate method
        'is_contact_address',
        'end_user_is_contact_address',
    ];

    protected $casts = [
        'create_date' => 'datetime',
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
        // 🔥 ADD THIS CAST for products_data
        'products_data' => 'array',
    ];

    /**
     * Default attribute values
     */
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

    /**
     * Get the salesman L1 (admin) associated with the RFQ.
     */
    public function salesmanL1()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'sales_man_id_L1');
    }

    /**
     * Get the salesman T1 (admin) associated with the RFQ.
     */
    public function salesmanT1()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'sales_man_id_T1');
    }

    /**
     * Get the salesman T2 (admin) associated with the RFQ.
     */
    public function salesmanT2()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'sales_man_id_T2');
    }

    /**
     * Get the user who submitted the RFQ.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the client associated with the RFQ.
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

    /**
     * Get the partner associated with the RFQ.
     */
    public function partner()
    {
        return $this->belongsTo(\App\Models\User::class, 'partner_id');
    }

    /**
     * Get the product associated with the RFQ.
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Admin\Product::class, 'product_id');
    }

    /**
     * Get the solution associated with the RFQ.
     */
    public function solution()
    {
        return $this->belongsTo(\App\Models\Admin\SolutionDetail::class, 'solution_id');
    }

    /**
     * 🔥 NEW: Get RFQ products relationship
     */
    public function rfqProducts()
    {
        return $this->hasMany(RfqProduct::class, 'rfq_id');
    }

    /**
     * 🔥 NEW: Get products from products_data
     */
    public function getProductsAttribute()
    {
        return $this->products_data ?? [];
    }

    /**
     * 🔥 NEW: Check if RFQ has products
     */
    public function getHasProductsAttribute()
    {
        return !empty($this->products_data) && is_array($this->products_data) && count($this->products_data) > 0;
    }

    /**
     * 🔥 NEW: Get product count
     */
    public function getProductsCountAttribute()
    {
        return $this->has_products ? count($this->products_data) : 0;
    }

    /**
     * 🔥 NEW: Calculate total quantity from all products
     */
    public function getTotalQuantityAttribute()
    {
        if (!$this->has_products) {
            return $this->rfqProducts->sum('qty') ?? 0;
        }

        $total = 0;
        foreach ($this->products_data as $product) {
            $total += $product['qty'] ?? 0;
        }
        return $total;
    }

    /**
     * 🔥 NEW: Calculate grand total from all products
     */
    public function getGrandTotalAttribute()
    {
        if (!$this->has_products) {
            return $this->rfqProducts->sum('grand_total') ?? 0;
        }

        $total = 0;
        foreach ($this->products_data as $product) {
            $total += $product['grand_total'] ?? $product['total_price'] ?? 0;
        }
        return $total;
    }

    /**
     * 🔥 NEW: Add a product to products_data
     */
    public function addProduct($productData)
    {
        $products = $this->products_data ?? [];
        $products[] = $productData;
        $this->products_data = $products;
        return $this;
    }

    /**
     * 🔥 NEW: Remove a product by index
     */
    public function removeProduct($index)
    {
        $products = $this->products_data ?? [];
        if (isset($products[$index])) {
            unset($products[$index]);
            $this->products_data = array_values($products);
        }
        return $this;
    }

    /**
     * 🔥 NEW: Update totals based on products_data
     */
    public function updateTotals()
    {
        $this->qty = $this->total_quantity;
        $this->total_price = $this->grand_total;
        $this->quoted_price = $this->grand_total;
        return $this;
    }

    /**
     * 🔥 NEW: Scope for RFQ code
     */
    public function scopeByRfqCode($query, $rfqCode)
    {
        return $query->where('rfq_code', $rfqCode);
    }

    /**
     * 🔥 NEW: Scope for today's RFQs
     */
    public function scopeToday($query)
    {
        return $query->whereDate('create_date', today());
    }

    /**
     * 🔥 NEW: Scope for specific status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 🔥 NEW: Scope for specific client type
     */
    public function scopeClientType($query, $clientType)
    {
        return $query->where('client_type', $clientType);
    }

    /**
     * 🔥 NEW: Get formatted create date
     */
    public function getFormattedCreateDateAttribute()
    {
        return $this->create_date?->format('M d, Y h:i A');
    }

    /**
     * 🔥 NEW: Get short message preview
     */
    public function getMessagePreviewAttribute()
    {
        if (empty($this->message)) {
            return 'No message';
        }
        
        return strlen($this->message) > 100 
            ? substr($this->message, 0, 100) . '...' 
            : $this->message;
    }

    /**
     * 🔥 NEW: Check if RFQ has shipping address
     */
    public function getHasShippingAddressAttribute()
    {
        return !empty($this->shipping_name) && !empty($this->shipping_address);
    }

    /**
     * 🔥 NEW: Check if RFQ has end user information
     */
    public function getHasEndUserAttribute()
    {
        return !empty($this->end_user_name) && !empty($this->end_user_company_name);
    }

    /**
     * 🔥 NEW: Get primary contact information
     */
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

    /**
     * 🔥 NEW: Boot method for automatic RFQ code generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set create date if not set
            if (empty($model->create_date)) {
                $model->create_date = now();
            }

            // Generate RFQ code if not set
            if (empty($model->rfq_code)) {
                $today = now()->format('ymd');
                $lastCode = self::where('rfq_code', 'like', "$today-%")->latest('id')->first();
                
                if ($lastCode) {
                    $parts = explode('-', $lastCode->rfq_code);
                    $lastNumber = isset($parts[1]) ? (int)$parts[1] : 0;
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }
                
                $model->rfq_code = $today . '-' . $newNumber;
            }

            // Generate deal code if not set
            if (empty($model->deal_code)) {
                $model->deal_code = 'DEAL-' . $model->rfq_code;
            }
        });

        static::updated(function ($model) {
            // Update related RFQ products if products_data changes
            if ($model->isDirty('products_data')) {
                // You can add logic here to sync with rfq_products table if needed
            }
        });
    }

    /**
     * 🔥 NEW: Get all products (from both products_data and rfqProducts relationship)
     */
    public function getAllProductsAttribute()
    {
        $products = [];

        // Add products from products_data
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

        // Add products from rfqProducts relationship
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
}