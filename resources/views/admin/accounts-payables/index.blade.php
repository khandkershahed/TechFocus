@extends('admin.master')
@section('title', 'Accounts Payable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Payable</h4>
                    <div>
                        <a href="{{ route('admin.accounts-payables.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                        <button class="btn btn-success btn-sm" onclick="exportToCSV()">
                            <i class="fas fa-download"></i> Export CSV
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
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Payables</div>
                                        <div class="h5 mb-0">${{ number_format($payables->sum('principal_amount'), 2) }}</div>
                                    </div>
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Payments</div>
                                        <div class="h5 mb-0">${{ number_format($payables->where('principal_payment_status', 'pending')->sum('principal_amount'), 2) }}</div>
                                    </div>
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Overdue</div>
                                        <div class="h5 mb-0">${{ number_format($payables->where('principal_payment_status', 'overdue')->sum('principal_amount'), 2) }}</div>
                                    </div>
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Paid</div>
                                        <div class="h5 mb-0">${{ number_format($payables->where('principal_payment_status', 'paid')->sum('principal_amount'), 2) }}</div>
                                    </div>
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="payablesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Principal Name</th>
                                    <th>RFQ ID</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payables as $payable)
                                    <tr class="{{ $payable->due_date && \Carbon\Carbon::parse($payable->due_date)->lt(now()) && $payable->principal_payment_status != 'paid' ? 'table-danger' : '' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payable->principal_name }}</td>
                                        <td>{{ $payable->rfq_id }}</td>
                                        <td class="fw-bold text-danger">${{ number_format($payable->principal_amount, 2) }}</td>
                                        <td>
                                            @if($payable->due_date)
                                                <div class="{{ $payable->due_date && \Carbon\Carbon::parse($payable->due_date)->lt(now()) && $payable->principal_payment_status != 'paid' ? 'text-danger fw-bold' : '' }}">
                                                    {{ \Carbon\Carbon::parse($payable->due_date)->format('M d, Y') }}
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $payable->principal_payment_status == 'paid' ? 'success' : ($payable->principal_payment_status == 'partial' ? 'warning' : ($payable->principal_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                                {{ ucfirst($payable->principal_payment_status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.accounts-payables.show', $payable->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.accounts-payables.edit', $payable->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.accounts-payables.destroy', $payable->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')" title="Delete" data-bs-toggle="tooltip">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-receipt fa-3x mb-3"></i>
                                                <h5>No Accounts Payable Found</h5>
                                                <p>Start by creating your first payable record.</p>
                                                <a href="{{ route('admin.accounts-payables.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Payable
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($payables->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold text-danger">${{ number_format($payables->sum('principal_amount'), 2) }}</td>
                                    <td colspan="3"></td>
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
// Tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Export to CSV
function exportToCSV() {
    const table = document.getElementById('payablesTable');
    let csv = [];

    // Headers
    const headers = [];
    for (let i = 0; i < table.rows[0].cells.length - 1; i++) { // exclude actions
        headers.push(table.rows[0].cells[i].innerText);
    }
    csv.push(headers.join(','));

    // Rows
    for (let i = 1; i < table.rows.length; i++) {
        const row = table.rows[i];
        const rowData = [];
        for (let j = 0; j < row.cells.length - 1; j++) { // exclude actions
            let cell = row.cells[j].innerText.replace(/,/g, ';').replace(/\$/g, '');
            rowData.push(cell);
        }
        csv.push(rowData.join(','));
    }

    // Download
    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', 'accounts_payable_' + new Date().toISOString().split('T')[0] + '.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

// Auto-refresh every 5 minutes
setTimeout(() => window.location.reload(), 300000);
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
