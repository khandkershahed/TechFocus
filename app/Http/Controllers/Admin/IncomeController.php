<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Rfq;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with(['rfq'])->get();
        return view('admin.incomes.index', compact('incomes'));
    }

    public function create()
    {
        $rfqs = Rfq::all();
     
        return view('admin.incomes.create', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:corporate,online',
        ]);

        Income::create($request->all());

        return redirect()->route('admin.incomes.index')
            ->with('success', 'Income record created successfully.');
    }

    public function show(Income $income)
    {
        return view('admin.incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $rfqs = Rfq::all();
     
        return view('admin.incomes.edit', compact('income', 'rfqs'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:corporate,online',
        ]);

        $income->update($request->all());

        return redirect()->route('admin.incomes.index')
            ->with('success', 'Income record updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('admin.incomes.index')
            ->with('success', 'Income record deleted successfully.');
    }
}