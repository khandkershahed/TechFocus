@extends('admin.master')
@section('title', 'Accounts Receivable Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Accounts Receivable Details</h4>
                        <small class="text-muted">ID: {{ $accountsReceivable->id }}</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.accounts-receivables.edit', $accountsReceivable->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Status Alert -->
                    @if($accountsReceivable->due_date && \Carbon\Carbon::parse($accountsReceivable->due_date)->lt(now()) && $accountsReceivable->client_payment_status != 'paid')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Overdue!</strong> This invoice was due on {{ \Carbon\Carbon::parse($accountsReceivable->due_date)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($accountsReceivable->due_date)->diffForHumans() }})
                    </div>
                    @endif

                    @if($accountsReceivable->client_payment_status == 'paid')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Paid!</strong> This invoice has been fully paid.
                    </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">RFQ Reference:</th>
                                            <td>
                                                @if($accountsReceivable->rfq)
                                                    <span class="badge bg-info">RFQ-{{ $accountsReceivable->rfq->rfq_code }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Client Name:</th>
                                            <td class="fw-bold">{{ $accountsReceivable->client_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Company Name:</th>
                                            <td>{{ $accountsReceivable->company_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Email:</th>
                                            <td>
                                                @if($accountsReceivable->client_email)
                                                    <a href="mailto:{{ $accountsReceivable->client_email }}">{{ $accountsReceivable->client_email }}</a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Client Phone:</th>
                                            <td>
                                                @if($accountsReceivable->client_phone)
                                                    <a href="tel:{{ $accountsReceivable->client_phone }}">{{ $accountsReceivable->client_phone }}</a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave me-2"></i>Payment Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Total Amount:</th>
                                            <td class="fw-bold text-success fs-5">${{ number_format($accountsReceivable->client_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Paid Amount:</th>
                                            <td class="fw-bold text-primary">${{ number_format($accountsReceivable->client_payment_value ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Balance Due:</th>
                                            <td class="fw-bold text-danger">${{ number_format($accountsReceivable->client_amount - ($accountsReceivable->client_payment_value ?? 0), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status:</th>
                                            <td>
                                                <span class="badge bg-{{ $accountsReceivable->client_payment_status == 'paid' ? 'success' : ($accountsReceivable->client_payment_status == 'partial' ? 'warning' : ($accountsReceivable->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }} fs-6">
                                                    {{ ucfirst($accountsReceivable->client_payment_status ?? 'pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Type:</th>
                                            <td>{{ $accountsReceivable->payment_type ? ucfirst(str_replace('_', ' ', $accountsReceivable->payment_type)) : 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Dates & Terms -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Dates & Terms</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">PO Number:</th>
                                            <td>{{ $accountsReceivable->client_po_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>PO Date:</th>
                                            <td>
                                                @if($accountsReceivable->po_date)
                                                    {{ \Carbon\Carbon::parse($accountsReceivable->po_date)->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Due Date:</th>
                                            <td class="{{ $accountsReceivable->due_date && \Carbon\Carbon::parse($accountsReceivable->due_date)->lt(now()) && $accountsReceivable->client_payment_status != 'paid' ? 'text-danger fw-bold' : 'fw-bold' }}">
                                                @if($accountsReceivable->due_date)
                                                    {{ \Carbon\Carbon::parse($accountsReceivable->due_date)->format('M d, Y') }}
                                                    @if($accountsReceivable->client_payment_status != 'paid')
                                                        <br>
                                                        <small class="text-muted">
                                                            @php
                                                                $daysLeft = \Carbon\Carbon::parse($accountsReceivable->due_date)->diffInDays(now(), false);
                                                            @endphp
                                                            @if($daysLeft > 0)
                                                                <span class="badge bg-danger">Overdue by {{ abs($daysLeft) }} days</span>
                                                            @else
                                                                <span class="badge bg-warning">{{ abs($daysLeft) }} days left</span>
                                                            @endif
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Credit Days:</th>
                                            <td>{{ $accountsReceivable->credit_days ?? '0' }} days</td>
                                        </tr>
                                        <tr>
                                            <th>Money Receipt:</th>
                                            <td>{{ $accountsReceivable->client_money_receipt ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                   <!-- File Attachments -->
<div class="col-md-6">
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0"><i class="fas fa-paperclip me-2"></i>File Attachments</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Client PO File:</strong>
                    @if($accountsReceivable->client_po)
                        <div>
                            <a href="{{ route('admin.accounts-receivables.download-client-po', $accountsReceivable->id) }}" 
                               class="btn btn-outline-primary btn-sm"
                               data-bs-toggle="tooltip" 
                               title="Download PO File">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="{{ Storage::url($accountsReceivable->client_po) }}" 
                               target="_blank" 
                               class="btn btn-outline-info btn-sm"
                               data-bs-toggle="tooltip" 
                               title="View PO File">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    @else
                        <span class="badge bg-secondary">No file attached</span>
                    @endif
                </div>
                @if($accountsReceivable->client_po)
                    <small class="text-muted">
                        Uploaded on: {{ \Carbon\Carbon::parse($accountsReceivable->updated_at)->format('M d, Y H:i A') }}<br>
                        File: {{ basename($accountsReceivable->client_po) }}
                    </small>
                @endif
            </div>

            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Invoice File:</strong>
                    @if($accountsReceivable->invoice)
                        <div>
                            <a href="{{ route('admin.accounts-receivables.download-invoice', $accountsReceivable->id) }}" 
                               class="btn btn-outline-primary btn-sm"
                               data-bs-toggle="tooltip" 
                               title="Download Invoice">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="{{ Storage::url($accountsReceivable->invoice) }}" 
                               target="_blank" 
                               class="btn btn-outline-info btn-sm"
                               data-bs-toggle="tooltip" 
                               title="View Invoice">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    @else
                        <span class="badge bg-secondary">No file attached</span>
                    @endif
                </div>
                @if($accountsReceivable->invoice)
                    <small class="text-muted">
                        Uploaded on: {{ \Carbon\Carbon::parse($accountsReceivable->updated_at)->format('M d, Y H:i A') }}<br>
                        File: {{ basename($accountsReceivable->invoice) }}
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px;
}

.timeline-content {
    padding: 10px 0;
}

.card-header {
    border-bottom: none;
}

.table-borderless th {
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.8em;
    padding: 0.5em 0.75em;
}

.btn-group .btn {
    margin-right: 5px;
}
</style>
@endpush