<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category',
        'expense_type',
        'date',
        'month',
        'category',
        'type',
        'particulars',
        'voucher',
        'amount',
        'comment'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category');
    }

    public function type()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type');
    }
}