@extends('admin.master')
@section('title', 'Accounts Receivable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Receivable</h4>
                    <div>
                        <a href="{{ route('admin.accounts-receivables.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                        <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                Total Receivables</div>
                                            <div class="h5 mb-0">${{ number_format($receivables->sum('client_amount'), 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                Pending Payments</div>
                                            <div class="h5 mb-0">${{ number_format($receivables->where('client_payment_status', 'pending')->sum('client_amount'), 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                Overdue</div>
                                            <div class="h5 mb-0">${{ number_format($receivables->where('client_payment_status', 'overdue')->sum('client_amount'), 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                Paid</div>
                                            <div class="h5 mb-0">${{ number_format($receivables->where('client_payment_status', 'paid')->sum('client_amount'), 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="receivablesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>RFQ Code</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Payment Status</th>
                                    <th>Payment Value</th>
                                    <th>Days Left</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receivables as $receivable)
                                <tr class="{{ $receivable->due_date && \Carbon\Carbon::parse($receivable->due_date)->lt(now()) && $receivable->client_payment_status != 'paid' ? 'table-danger' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $receivable->client_name }}</div>
                                        @if($receivable->company_name)
                                            <small class="text-muted">{{ $receivable->company_name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($receivable->rfq)
                                            <span class="badge bg-info">RFQ-{{ $receivable->rfq->rfq_code }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($receivable->client_amount, 2) }}</td>
                                    <td>
                                        @if($receivable->due_date)
                                            <div class="{{ $receivable->due_date && \Carbon\Carbon::parse($receivable->due_date)->lt(now()) && $receivable->client_payment_status != 'paid' ? 'text-danger fw-bold' : '' }}">
                                                {{ \Carbon\Carbon::parse($receivable->due_date)->format('M d, Y') }}
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $receivable->client_payment_status == 'paid' ? 'success' : ($receivable->client_payment_status == 'partial' ? 'warning' : ($receivable->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($receivable->client_payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($receivable->client_payment_value)
                                            <span class="text-primary">${{ number_format($receivable->client_payment_value, 2) }}</span>
                                        @else
                                            <span class="text-muted">$0.00</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($receivable->due_date && $receivable->client_payment_status != 'paid')
                                            @php
                                                $daysLeft = \Carbon\Carbon::parse($receivable->due_date)->diffInDays(now(), false);
                                            @endphp
                                            @if($daysLeft > 0)
                                                <span class="badge bg-danger">Overdue by {{ abs($daysLeft) }} days</span>
                                            @else
                                                <span class="badge bg-warning">{{ abs($daysLeft) }} days left</span>
                                            @endif
                                        @else
                                            <span class="badge bg-success">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.accounts-receivables.show', $receivable->id) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="View Details"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.accounts-receivables.edit', $receivable->id) }}" 
                                               class="btn btn-warning btn-sm"
                                               title="Edit"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.accounts-receivables.destroy', $receivable->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete"
                                                        data-bs-toggle="tooltip"
                                                        onclick="return confirm('Are you sure you want to delete this accounts receivable record?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-receipt fa-3x mb-3"></i>
                                            <h5>No Accounts Receivable Found</h5>
                                            <p>Start by creating your first accounts receivable record.</p>
                                            <a href="{{ route('admin.accounts-receivables.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Create First Receivable
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($receivables->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold text-success">${{ number_format($receivables->sum('client_amount'), 2) }}</td>
                                    <td colspan="2"></td>
                                    <td class="fw-bold text-primary">${{ number_format($receivables->sum('client_payment_value'), 2) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Export to Excel function
function exportToExcel() {
    // Simple table export (you can enhance this with a proper Excel export library)
    const table = document.getElementById('receivablesTable');
    let csv = [];
    
    // Get headers
    const headers = [];
    for (let i = 0; i < table.rows[0].cells.length - 1; i++) { // -1 to exclude actions column
        headers.push(table.rows[0].cells[i].innerText);
    }
    csv.push(headers.join(','));
    
    // Get rows data
    for (let i = 1; i < table.rows.length; i++) {
        const row = table.rows[i];
        const rowData = [];
        
        for (let j = 0; j < row.cells.length - 1; j++) { // -1 to exclude actions column
            let cellData = row.cells[j].innerText.replace(/,/g, ';');
            cellData = cellData.replace(/\$/g, ''); // Remove dollar signs
            rowData.push(cellData);
        }
        
        csv.push(rowData.join(','));
    }
    
    // Download CSV
    const csvString = csv.join('\n');
    const blob = new Blob([csvString], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', 'accounts_receivable_' + new Date().toISOString().split('T')[0] + '.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

// Auto-refresh page every 5 minutes to update status
setTimeout(function() {
    window.location.reload();
}, 300000); // 5 minutes
</script>
@endpush

@push('styles')
<style>
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
}
.card .card-body .h5 {
    font-size: 1.25rem;
}
.badge {
    font-size: 0.75em;
}
.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush