<?php

namespace App\Models\Rfq\Rfq;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory, Userstamps;

    // Mass assignable fields
    protected $fillable = [
        'rfq_code',
        'name',
        'email',
        'phone',
        'user_id',
        'salesman_id',
        'partner_id',
        'product_id',
        'solution_id',
        'status',
        'rfq_type',
        'budget',
        'delivery_location',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function salesman()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'salesman_id');
    }

    public function partner()
    {
        return $this->belongsTo(\App\Models\User::class, 'partner_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Admin\Product::class, 'product_id');
    }

    public function solution()
    {
        return $this->belongsTo(\App\Models\Admin\SolutionDetail::class, 'solution_id');
    }

    /**
     * Return RFQ data with all related information dynamically
     *
     * @return array
     */
    public function fullInfo()
    {
        $relations = [
            'salesman' => 'name',
            'user' => 'name',
            'partner' => 'name',
            'product' => 'name',
            'solution' => 'name',
        ];

        $data = [
            'rfq_code' => $this->rfq_code,
            'client_name' => $this->name,
            'client_email' => $this->email,
            'client_phone' => $this->phone,
            'status' => $this->status,
            'rfq_type' => $this->rfq_type,
            'budget' => $this->budget,
            'delivery_location' => $this->delivery_location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Add related names dynamically
        foreach ($relations as $relation => $attribute) {
            $data[$relation] = $this->$relation ? $this->$relation->$attribute : null;
        }

        return $data;
    }
}
