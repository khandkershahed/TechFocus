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
    $rfqIds = Rfq::pluck('id')->toArray();

    $rfqId = $request->rfq_id === 'manual' ? null : $request->rfq_id;

    $request->validate([
        'rfq_id' => ['required', function ($attr, $value, $fail) use ($rfqIds) {
            if($value !== 'manual' && !in_array($value, $rfqIds)) {
                $fail('The selected RFQ ID is invalid.');
            }
        }],
        'principal_name' => 'required|string|max:255',
        'principal_amount' => 'required|numeric',
        'due_date' => 'required|date',
        // Add other validations as needed
    ]);

    $data = $request->except(['invoice','principal_po']);
    $data['rfq_id'] = $rfqId;

    if($request->hasFile('invoice')) {
        $data['invoice'] = $request->file('invoice')->store('payable_invoices','public');
    }

    if($request->hasFile('principal_po')) {
        $data['principal_po'] = $request->file('principal_po')->store('principal_pos','public');
    }

    AccountsPayable::create($data);

    return redirect()->route('admin.accounts-payables.index')
        ->with('success','Accounts payable created successfully.');
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