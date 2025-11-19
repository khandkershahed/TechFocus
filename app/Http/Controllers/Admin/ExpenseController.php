<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['category', 'type'])->get();
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        $types = ExpenseType::where('status', 'active')->get();
        return view('admin.expenses.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category' => 'required|exists:expense_categories,id',
            'expense_type' => 'required|exists:expense_types,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'particulars' => 'required|string|max:255',
        ]);

        if ($request->hasFile('voucher')) {
            $voucherPath = $request->file('voucher')->store('vouchers', 'public');
            $request->merge(['voucher' => $voucherPath]);
        }

        Expense::create($request->all());

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        $types = ExpenseType::where('status', 'active')->get();
        return view('admin.expenses.edit', compact('expense', 'categories', 'types'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category' => 'required|exists:expense_categories,id',
            'expense_type' => 'required|exists:expense_types,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'particulars' => 'required|string|max:255',
        ]);

        if ($request->hasFile('voucher')) {
            $voucherPath = $request->file('voucher')->store('vouchers', 'public');
            $request->merge(['voucher' => $voucherPath]);
        }

        $expense->update($request->all());

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    public function getTypesByCategory($categoryId)
    {
        $types = ExpenseType::where('expense_category_id', $categoryId)
            ->where('status', 'active')
            ->get();
        return response()->json($types);
    }
}