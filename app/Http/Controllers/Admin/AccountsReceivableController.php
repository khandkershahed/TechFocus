<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsReceivable;
use App\Models\Rfq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'client_po' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['client_po', 'invoice']);

        // Handle file uploads with original names
        if ($request->hasFile('client_po')) {
            $file = $request->file('client_po');
            $originalName = $file->getClientOriginalName();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $clientPoPath = $file->storeAs('client_pos', $filename, 'public');
            $data['client_po'] = $clientPoPath;
        }

        if ($request->hasFile('invoice')) {
            $file = $request->file('invoice');
            $originalName = $file->getClientOriginalName();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $invoicePath = $file->storeAs('invoices', $filename, 'public');
            $data['invoice'] = $invoicePath;
        }

        AccountsReceivable::create($data);

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
            'client_po' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['client_po', 'invoice', 'remove_client_po', 'remove_invoice']);

        // Handle file uploads with original names
        if ($request->hasFile('client_po')) {
            // Delete old file if exists
            if ($accountsReceivable->client_po && Storage::disk('public')->exists($accountsReceivable->client_po)) {
                Storage::disk('public')->delete($accountsReceivable->client_po);
            }
            
            $file = $request->file('client_po');
            $originalName = $file->getClientOriginalName();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $clientPoPath = $file->storeAs('client_pos', $filename, 'public');
            $data['client_po'] = $clientPoPath;
        }

        if ($request->hasFile('invoice')) {
            // Delete old file if exists
            if ($accountsReceivable->invoice && Storage::disk('public')->exists($accountsReceivable->invoice)) {
                Storage::disk('public')->delete($accountsReceivable->invoice);
            }
            
            $file = $request->file('invoice');
            $originalName = $file->getClientOriginalName();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $invoicePath = $file->storeAs('invoices', $filename, 'public');
            $data['invoice'] = $invoicePath;
        }

        // Handle file removal
        if ($request->has('remove_client_po')) {
            if ($accountsReceivable->client_po && Storage::disk('public')->exists($accountsReceivable->client_po)) {
                Storage::disk('public')->delete($accountsReceivable->client_po);
            }
            $data['client_po'] = null;
        }

        if ($request->has('remove_invoice')) {
            if ($accountsReceivable->invoice && Storage::disk('public')->exists($accountsReceivable->invoice)) {
                Storage::disk('public')->delete($accountsReceivable->invoice);
            }
            $data['invoice'] = null;
        }

        $accountsReceivable->update($data);

        return redirect()->route('admin.accounts-receivables.index')
            ->with('success', 'Accounts receivable updated successfully.');
    }

    public function destroy(AccountsReceivable $accountsReceivable)
    {
        // Delete associated files
        if ($accountsReceivable->client_po && Storage::disk('public')->exists($accountsReceivable->client_po)) {
            Storage::disk('public')->delete($accountsReceivable->client_po);
        }
        if ($accountsReceivable->invoice && Storage::disk('public')->exists($accountsReceivable->invoice)) {
            Storage::disk('public')->delete($accountsReceivable->invoice);
        }

        $accountsReceivable->delete();

        return redirect()->route('admin.accounts-receivables.index')
            ->with('success', 'Accounts receivable deleted successfully.');
    }

    // File Download Methods
    public function downloadClientPo($id)
    {
        $accountsReceivable = AccountsReceivable::findOrFail($id);
        
        if (!$accountsReceivable->client_po) {
            abort(404, 'Client PO file not found');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($accountsReceivable->client_po)) {
            abort(404, 'File not found in storage');
        }
        
        $filename = basename($accountsReceivable->client_po);
        
        return Storage::disk('public')->download($accountsReceivable->client_po, $filename);
    }

    public function downloadInvoice($id)
    {
        $accountsReceivable = AccountsReceivable::findOrFail($id);
        
        if (!$accountsReceivable->invoice) {
            abort(404, 'Invoice file not found');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($accountsReceivable->invoice)) {
            abort(404, 'File not found in storage');
        }
        
        $filename = basename($accountsReceivable->invoice);
        
        return Storage::disk('public')->download($accountsReceivable->invoice, $filename);
    }

    // Method to get RFQ details via AJAX
    public function getRfqDetails($id)
    {
        try {
            $rfq = Rfq::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'client_name' => $rfq->name ?? $rfq->company_name ?? '',
                    'client_email' => $rfq->email ?? '',
                    'client_phone' => $rfq->phone ?? '',
                    'company_name' => $rfq->company_name ?? '',
                    'client_po_number' => $rfq->client_po ?? $rfq->po_number ?? '',
                    'po_date' => $rfq->create_date ? $rfq->create_date->format('Y-m-d') : '',
                    'client_amount' => $rfq->quoted_price ?? $rfq->total_price ?? 0,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'RFQ not found'
            ]);
        }
    }
}