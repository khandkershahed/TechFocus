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
    // Eager load category and type relationships
    $expenses = Expense::with(['category', 'type'])->latest()->get();

    return view('admin.expenses.index', compact('expenses'));
}

    public function create()
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        return view('admin.expenses.create', compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'expense_category_id' => 'required|exists:expense_categories,id',
    //         'expense_type_id' => 'required|exists:expense_types,id',
    //         'date' => 'required|date',
    //         'amount' => 'required|numeric',
    //         'particulars' => 'required|string|max:255',
    //         'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
    //         'comment' => 'nullable|string|max:500'
    //     ]);

    //     $data = $request->only([
    //         'expense_category_id', 
    //         'expense_type_id', 
    //         'date', 
    //         'amount', 
    //         'particulars', 
    //         'comment'
    //     ]);

    //     if ($request->hasFile('voucher')) {
    //         $data['voucher'] = $request->file('voucher')->store('vouchers', 'public');
    //     }

    //     Expense::create($data);

    //     return redirect()->route('admin.expenses.index')->with('success', 'Expense created successfully.');
    // }
public function store(Request $request)
{
    $request->validate([
        'expense_category_id' => 'required|exists:expense_categories,id',
        'expense_type_id' => 'required|exists:expense_types,id',
        'date' => 'required|date',
        'amount' => 'required|numeric',
        'particulars' => 'required|string|max:255',
        'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'comment' => 'nullable|string|max:500'
    ]);

    // Get the category and type names
    $category = ExpenseCategory::find($request->expense_category_id);
    $type = ExpenseType::find($request->expense_type_id);

    $data = [
        'expense_category_id' => $request->expense_category_id,
        'expense_type_id' => $request->expense_type_id,
        'category' => $category ? $category->name : null, // Store name
        'type' => $type ? $type->name : null,             // Store name
        'date' => $request->date,
        'amount' => $request->amount,
        'particulars' => $request->particulars,
        'comment' => $request->comment,
    ];

    // Handle voucher file upload
    if ($request->hasFile('voucher')) {
        $data['voucher'] = $request->file('voucher')->store('vouchers', 'public');
    }
// dd($data);
    Expense::create($data);

    return redirect()->route('admin.expenses.index')->with('success', 'Expense created successfully.');
}



// public function update(Request $request, Expense $expense)
// {
//     $request->validate([
//         'expense_category_id' => 'required|exists:expense_categories,id',
//         'expense_type_id' => 'required|exists:expense_types,id',
//         'date' => 'required|date',
//         'amount' => 'required|numeric',
//         'particulars' => 'required|string|max:255',
//         'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
//         'comment' => 'nullable|string|max:500'
//     ]);

//     $categoryName = ExpenseCategory::find($request->expense_category_id)->name ?? null;
//     $typeName = ExpenseType::find($request->expense_type_id)->name ?? null;

//     $data = [
//         'expense_category' => $request->expense_category_id,
//         'expense_type' => $request->expense_type_id,
//         'category' => $categoryName,
//         'type' => $typeName,
//         'date' => $request->date,
//         'amount' => $request->amount,
//         'particulars' => $request->particulars,
//         'comment' => $request->comment,
//     ];

//     if ($request->hasFile('voucher')) {
//         $data['voucher'] = $request->file('voucher')->store('vouchers', 'public');
//     }

//     $expense->update($data);

//     return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
// }

       public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        $types = ExpenseType::where('expense_category_id', $expense->expense_category_id)
                            ->where('status', 'active')->get();

        return view('admin.expenses.edit', compact('expense', 'categories', 'types'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_type_id' => 'required|exists:expense_types,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'particulars' => 'required|string|max:255',
            'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'comment' => 'nullable|string|max:500'
        ]);

        $category = ExpenseCategory::find($request->expense_category_id);
        $type = ExpenseType::find($request->expense_type_id);

        $data = [
            'expense_category_id' => $request->expense_category_id,
            'expense_type_id' => $request->expense_type_id,
            'category' => $category ? $category->name : null,
            'type' => $type ? $type->name : null,
            'date' => $request->date,
            'amount' => $request->amount,
            'particulars' => $request->particulars,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('voucher')) {
            $data['voucher'] = $request->file('voucher')->store('vouchers', 'public');
        }

        $expense->update($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully.');
    }

    public function getTypesByCategory($categoryId)
    {
        $types = ExpenseType::where('expense_category_id', $categoryId)
                            ->where('status', 'active')
                            ->get();
        return response()->json($types);
    }
}
