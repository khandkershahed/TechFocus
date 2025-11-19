<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsReceivable;
use App\Models\Rfq;
use Illuminate\Http\Request;

class AccountsReceivableController extends Controller
{
    public function index()
    {
        $receivables = AccountsReceivable::with('rfq')->get();
        return view('admin.accounts-receivables.index', compact('receivables'));
    }

    public function create()
    {
        $rfqs = Rfq::all();
        return view('admin.accounts-receivables.create', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'client_name' => 'required|string|max:255',
            'client_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        if ($request->hasFile('client_po')) {
            $clientPoPath = $request->file('client_po')->store('client_pos', 'public');
            $request->merge(['client_po' => $clientPoPath]);
        }

        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('invoices', 'public');
            $request->merge(['invoice' => $invoicePath]);
        }

        AccountsReceivable::create($request->all());

        return redirect()->route('admin.accounts-receivables.index')
            ->with('success', 'Accounts receivable created successfully.');
    }

    public function show(AccountsReceivable $accountsReceivable)
    {
        return view('admin.accounts-receivables.show', compact('accountsReceivable'));
    }

    public function edit(AccountsReceivable $accountsReceivable)
    {
        $rfqs = Rfq::all();
        return view('admin.accounts-receivables.edit', compact('accountsReceivable', 'rfqs'));
    }

    public function update(Request $request, AccountsReceivable $accountsReceivable)
    {
        $request->validate([
            'rfq_id' => 'required|exists:rfqs,id',
            'client_name' => 'required|string|max:255',
            'client_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        if ($request->hasFile('client_po')) {
            $clientPoPath = $request->file('client_po')->store('client_pos', 'public');
            $request->merge(['client_po' => $clientPoPath]);
        }

        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('invoices', 'public');
            $request->merge(['invoice' => $invoicePath]);
        }

        $accountsReceivable->update($request->all());

        return redirect()->route('admin.accounts-receivables.index')
            ->with('success', 'Accounts receivable updated successfully.');
    }

    public function destroy(AccountsReceivable $accountsReceivable)
    {
        $accountsReceivable->delete();

        return redirect()->route('admin.accounts-receivables.index')
            ->with('success', 'Accounts receivable deleted successfully.');
    }
}