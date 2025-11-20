@extends('admin.master')
@section('title', 'Accounts Comparison')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Accounts Receivable vs Payable Comparison</h1>
        <div class="d-flex">
            <a href="{{ route('admin.account.dashboard') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-info mr-2">
                <i class="fas fa-hand-holding-usd"></i> Receivables
            </a>
            <a href="{{ route('admin.accounts-payables.index') }}" class="btn btn-warning">
                <i class="fas fa-file-invoice-dollar"></i> Payables
            </a>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row">
        <!-- Net Cash Flow -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $netCashFlow >= 0 ? 'success' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $netCashFlow >= 0 ? 'success' : 'danger' }} text-uppercase mb-1">
                                Net Cash Flow</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ৳{{ number_format($netCashFlow, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receivable to Payable Ratio -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                R/P Ratio</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($receivableToPayableRatio, 2) }}:1
                            </div>
                            <div class="text-xs text-muted">
                                Receivable to Payable
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Efficiency -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Collection Efficiency</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($collectionEfficiency, 1) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Efficiency -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Payment Efficiency</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($paymentEfficiency, 1) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Cards -->
    <div class="row">
        <!-- Accounts Receivable -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-hand-holding-usd mr-2"></i>Accounts Receivable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="text-primary">
                                <h6>Total</h6>
                                <h4>৳{{ number_format($totalReceivables, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-success">
                                <h6>Received</h6>
                                <h4>৳{{ number_format($totalReceived, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-warning">
                                <h6>Pending</h6>
                                <h4>৳{{ number_format($pendingReceivables, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <h6 class="font-weight-bold">Status Breakdown</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivablesByStatus as $status)
                                <tr>
                                    <td>
                                        <span class="badge badge-{{ $status->client_payment_status == 'paid' ? 'success' : ($status->client_payment_status == 'partial' ? 'warning' : ($status->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($status->client_payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>{{ $status->count }}</td>
                                    <td>৳{{ number_format($status->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($overdueReceivables->count() > 0)
                    <div class="mt-3">
                        <h6 class="font-weight-bold text-danger">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Overdue Receivables: {{ $overdueReceivables->count() }}
                        </h6>
                        <small class="text-muted">Total: ৳{{ number_format($overdueReceivables->sum('client_amount'), 2) }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Accounts Payable -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning text-dark">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>Accounts Payable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="text-danger">
                                <h6>Total</h6>
                                <h4>৳{{ number_format($totalPayables, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-success">
                                <h6>Paid</h6>
                                <h4>৳{{ number_format($totalPaid, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-warning">
                                <h6>Pending</h6>
                                <h4>৳{{ number_format($pendingPayables, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <h6 class="font-weight-bold">Status Breakdown</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payablesByStatus as $status)
                                <tr>
                                    <td>
                                        <span class="badge badge-{{ $status->principal_payment_status == 'paid' ? 'success' : ($status->principal_payment_status == 'partial' ? 'warning' : ($status->principal_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($status->principal_payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>{{ $status->count }}</td>
                                    <td>৳{{ number_format($status->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($overduePayables->count() > 0)
                    <div class="mt-3">
                        <h6 class="font-weight-bold text-danger">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Overdue Payables: {{ $overduePayables->count() }}
                        </h6>
                        <small class="text-muted">Total: ৳{{ number_format($overduePayables->sum('principal_amount'), 2) }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Receivables -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Receivables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReceivables as $receivable)
                                <tr>
                                    <td>{{ $receivable->client_name }}</td>
                                    <td class="text-success">৳{{ number_format($receivable->client_amount, 2) }}</td>
                                    <td>
                                        @if($receivable->due_date)
                                            {{ \Carbon\Carbon::parse($receivable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $receivable->client_payment_status == 'paid' ? 'success' : ($receivable->client_payment_status == 'partial' ? 'warning' : ($receivable->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $receivable->client_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payables -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Recent Payables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Principal</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayables as $payable)
                                <tr>
                                    <td>{{ $payable->principal_name }}</td>
                                    <td class="text-danger">৳{{ number_format($payable->principal_amount, 2) }}</td>
                                    <td>
                                        @if($payable->due_date)
                                            {{ \Carbon\Carbon::parse($payable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $payable->principal_payment_status == 'paid' ? 'success' : ($payable->principal_payment_status == 'partial' ? 'warning' : ($payable->principal_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $payable->principal_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection