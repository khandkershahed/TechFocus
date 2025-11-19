@extends('admin.master')
@section('title', 'Accounts Receivable Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Receivable Details</h4>
                    <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $accountsReceivable->id }}</td>
                                </tr>
                                <tr>
                                    <th>RFQ ID</th>
                                    <td>{{ $accountsReceivable->rfq_id }}</td>
                                </tr>
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $accountsReceivable->client_name }}</td>
                                </tr>
                                <tr>
                                    <th>Client PO Number</th>
                                    <td>{{ $accountsReceivable->client_po_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ $accountsReceivable->payment_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Credit Days</th>
                                    <td>{{ $accountsReceivable->credit_days ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Client Amount</th>
                                    <td class="text-success">{{ number_format($accountsReceivable->client_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Value</th>
                                    <td>{{ $accountsReceivable->client_payment_value ? number_format($accountsReceivable->client_payment_value, 2) : '0.00' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        <span class="badge bg-{{ $accountsReceivable->client_payment_status == 'paid' ? 'success' : ($accountsReceivable->client_payment_status == 'partial' ? 'warning' : ($accountsReceivable->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $accountsReceivable->client_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Money Receipt</th>
                                    <td>{{ $accountsReceivable->client_money_receipt ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $accountsReceivable->created_at->format('M d, Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $accountsReceivable->updated_at->format('M d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>PO Date</th>
                                    <td>
                                        @if($accountsReceivable->po_date)
                                            {{ \Carbon\Carbon::parse($accountsReceivable->po_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <td>
                                        @if($accountsReceivable->due_date)
                                            {{ \Carbon\Carbon::parse($accountsReceivable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>File Attachments</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Client PO File:</strong>
                                        @if($accountsReceivable->client_po)
                                            <a href="{{ asset('storage/' . $accountsReceivable->client_po) }}" target="_blank" class="btn btn-info btn-sm ms-2">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted ms-2">No file attached</span>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>Invoice File:</strong>
                                        @if($accountsReceivable->invoice)
                                            <a href="{{ asset('storage/' . $accountsReceivable->invoice) }}" target="_blank" class="btn btn-info btn-sm ms-2">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted ms-2">No file attached</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.accounts-receivables.edit', $accountsReceivable->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.accounts-receivables.destroy', $accountsReceivable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this accounts receivable?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection