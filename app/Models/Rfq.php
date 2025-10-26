<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_code',
        'salesman_id',
        'user_id',
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
    
    ];

    protected $casts = [
        'create_date' => 'date',
        'close_date' => 'date',
        'sale_date' => 'date',
        'tax' => 'double',
        'vat' => 'double',
        'total_price' => 'double',
        'quoted_price' => 'double',
        'budget' => 'double',
        'qty' => 'integer',
        'category' => 'array',
        'brand' => 'array',
        'industry' => 'array',
        'solution' => 'array',
    ];

    /**
     * Get the salesman (admin) associated with the RFQ.
     */
    public function salesman()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'salesman_id');
    }

    /**
     * Get the user who submitted the RFQ.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
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
}