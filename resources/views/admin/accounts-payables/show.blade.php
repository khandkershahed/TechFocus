@extends('admin.master')
@section('title', 'Accounts Payable Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Payable Details</h4>
                    <a href="{{ route('admin.accounts-payables.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $accountsPayable->id }}</td>
                                </tr>
                                <tr>
                                    <th>RFQ ID</th>
                                    <td>{{ $accountsPayable->rfq_id }}</td>
                                </tr>
                                <tr>
                                    <th>Principal Name</th>
                                    <td>{{ $accountsPayable->principal_name }}</td>
                                </tr>
                                <tr>
                                    <th>Principal PO Number</th>
                                    <td>{{ $accountsPayable->principal_po_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ $accountsPayable->payment_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>PO Value</th>
                                    <td>{{ $accountsPayable->po_value ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Principal Amount</th>
                                    <td class="text-danger">{{ number_format($accountsPayable->principal_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Value</th>
                                    <td>{{ $accountsPayable->principal_payment_value ? number_format($accountsPayable->principal_payment_value, 2) : '0.00' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        <span class="badge bg-{{ $accountsPayable->principal_payment_status == 'paid' ? 'success' : ($accountsPayable->principal_payment_status == 'partial' ? 'warning' : ($accountsPayable->principal_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $accountsPayable->principal_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Credit Days</th>
                                    <td>{{ $accountsPayable->credit_days ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $accountsPayable->created_at->format('M d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Due Date</th>
                                    <td>
                                        @if($accountsPayable->due_date)
                                            {{ \Carbon\Carbon::parse($accountsPayable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Delivery Date</th>
                                    <td>
                                        @if($accountsPayable->delivery_date)
                                            {{ \Carbon\Carbon::parse($accountsPayable->delivery_date)->format('M d, Y') }}
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
                                        <strong>Invoice File:</strong>
                                        @if($accountsPayable->invoice)
                                            <a href="{{ asset('storage/' . $accountsPayable->invoice) }}" target="_blank" class="btn btn-info btn-sm ms-2">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted ms-2">No file attached</span>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>Principal PO File:</strong>
                                        @if($accountsPayable->principal_po)
                                            <a href="{{ asset('storage/' . $accountsPayable->principal_po) }}" target="_blank" class="btn btn-info btn-sm ms-2">
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
                        <a href="{{ route('admin.accounts-payables.edit', $accountsPayable->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.accounts-payables.destroy', $accountsPayable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this accounts payable?')">
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