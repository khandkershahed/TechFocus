<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseType;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $expenseTypes = ExpenseType::with('expenseCategory')->get();
        return view('admin.expense-types.index', compact('expenseTypes'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        return view('admin.expense-types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'status' => 'required|string',
        ]);

        ExpenseType::create($request->all());

        return redirect()->route('admin.expense-types.index')
            ->with('success', 'Expense type created successfully.');
    }

    public function show(ExpenseType $expenseType)
    {
        return view('admin.expense-types.show', compact('expenseType'));
    }

    public function edit(ExpenseType $expenseType)
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        return view('admin.expense-types.edit', compact('expenseType', 'categories'));
    }

    public function update(Request $request, ExpenseType $expenseType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'status' => 'required|string',
        ]);

        $expenseType->update($request->all());

        return redirect()->route('admin.expense-types.index')
            ->with('success', 'Expense type updated successfully.');
    }

    public function destroy(ExpenseType $expenseType)
    {
        $expenseType->delete();

        return redirect()->route('admin.expense-types.index')
            ->with('success', 'Expense type deleted successfully.');
    }
}