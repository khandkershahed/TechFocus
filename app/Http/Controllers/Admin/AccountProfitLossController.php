<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountProfitLoss;
use App\Models\Rfq;
use Illuminate\Http\Request;

class AccountProfitLossController extends Controller
{
    public function index()
    {
        $profitLosses = AccountProfitLoss::with('rfq')->get();
        return view('admin.account-profit-losses.index', compact('profitLosses'));
    }

    public function create()
    {
        $rfqs = Rfq::all();
        return view('admin.account-profit-losses.create', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'sales_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
        ]);

        $profit = $request->sales_price - $request->cost_price;
        $request->merge([
            'profit' => $profit > 0 ? $profit : 0,
            'loss' => $profit < 0 ? abs($profit) : 0,
            'gross_makup_percentage' => $request->cost_price > 0 ? (($request->sales_price - $request->cost_price) / $request->cost_price) * 100 : 0,
            'gross_makup_ammount' => $request->sales_price - $request->cost_price,
        ]);

        AccountProfitLoss::create($request->all());

        return redirect()->route('admin.account-profit-losses.index')
            ->with('success', 'Profit/Loss record created successfully.');
    }

    public function show(AccountProfitLoss $accountProfitLoss)
    {
        return view('admin.account-profit-losses.show', compact('accountProfitLoss'));
    }

    public function edit(AccountProfitLoss $accountProfitLoss)
    {
        $rfqs = Rfq::all();
        return view('admin.account-profit-losses.edit', compact('accountProfitLoss', 'rfqs'));
    }

    public function update(Request $request, AccountProfitLoss $accountProfitLoss)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'sales_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
        ]);

        $profit = $request->sales_price - $request->cost_price;
        $request->merge([
            'profit' => $profit > 0 ? $profit : 0,
            'loss' => $profit < 0 ? abs($profit) : 0,
            'gross_makup_percentage' => $request->cost_price > 0 ? (($request->sales_price - $request->cost_price) / $request->cost_price) * 100 : 0,
            'gross_makup_ammount' => $request->sales_price - $request->cost_price,
        ]);

        $accountProfitLoss->update($request->all());

        return redirect()->route('admin.account-profit-losses.index')
            ->with('success', 'Profit/Loss record updated successfully.');
    }

    public function destroy(AccountProfitLoss $accountProfitLoss)
    {
        $accountProfitLoss->delete();

        return redirect()->route('admin.account-profit-losses.index')
            ->with('success', 'Profit/Loss record deleted successfully.');
    }
}