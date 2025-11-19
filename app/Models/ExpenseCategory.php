<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'comments',
        'notes',
        'custom'
    ];

    public function expenseTypes()
    {
        return $this->hasMany(ExpenseType::class, 'expense_category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category');
    }
}