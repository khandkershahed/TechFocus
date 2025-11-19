<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsPayable;
use App\Models\Rfq;
use Illuminate\Http\Request;

class AccountsPayableController extends Controller
{
    public function index()
    {
        $payables = AccountsPayable::with('rfq')->get();
        return view('admin.accounts-payables.index', compact('payables'));
    }

    public function create()
    {
        $rfqs = Rfq::all();
        return view('admin.accounts-payables.create', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'principal_name' => 'required|string|max:255',
            'principal_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('payable_invoices', 'public');
            $request->merge(['invoice' => $invoicePath]);
        }

        if ($request->hasFile('principal_po')) {
            $principalPoPath = $request->file('principal_po')->store('principal_pos', 'public');
            $request->merge(['principal_po' => $principalPoPath]);
        }

        AccountsPayable::create($request->all());

        return redirect()->route('admin.accounts-payables.index')
            ->with('success', 'Accounts payable created successfully.');
    }

    public function show(AccountsPayable $accountsPayable)
    {
        return view('admin.accounts-payables.show', compact('accountsPayable'));
    }

    public function edit(AccountsPayable $accountsPayable)
    {
        $rfqs = Rfq::all();
        return view('admin.accounts-payables.edit', compact('accountsPayable', 'rfqs'));
    }

    public function update(Request $request, AccountsPayable $accountsPayable)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'principal_name' => 'required|string|max:255',
            'principal_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('payable_invoices', 'public');
            $request->merge(['invoice' => $invoicePath]);
        }

        if ($request->hasFile('principal_po')) {
            $principalPoPath = $request->file('principal_po')->store('principal_pos', 'public');
            $request->merge(['principal_po' => $principalPoPath]);
        }

        $accountsPayable->update($request->all());

        return redirect()->route('admin.accounts-payables.index')
            ->with('success', 'Accounts payable updated successfully.');
    }

    public function destroy(AccountsPayable $accountsPayable)
    {
        $accountsPayable->delete();

        return redirect()->route('admin.accounts-payables.index')
            ->with('success', 'Accounts payable deleted successfully.');
    }
}