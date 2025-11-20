<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

protected $fillable = [
    'expense_category_id', // DB column for category ID
    'expense_type_id',     // DB column for type ID
    'category',            // DB column for category name
    'type',                // DB column for type name
    'date',
    'amount',
    'particulars',
    'voucher',
    'comment'
];


    protected $casts = [
        'date' => 'date',
    ];

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    // Relationship to Type
    public function type()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }
}
