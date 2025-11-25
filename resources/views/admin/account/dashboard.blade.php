@extends('admin.master')
@section('title', 'Account Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Account Dashboard</h1>
        <div class="d-flex">
            <a href="{{ route('admin.incomes.index') }}" class="btn btn-primary mr-2">
                <i class="fas fa-money-bill-wave"></i> View All Incomes
            </a>
            <a href="{{ route('admin.incomes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Income
            </a>
        </div>
    </div>

    <!-- Comparison Link Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                              <h2>  Accounts Comparison</h2>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                Compare Accounts Receivable vs Payable performance and metrics
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('account.comparison') }}" class="btn btn-info">
                                <i class="fas fa-balance-scale-left mr-2"></i>View Comparison
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Summary Cards -->
    <div class="row">
        <!-- Total Income Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Income
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($totalIncome, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-3x mb-2 text-primary" data-toggle="tooltip" title="Total Income"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Received Income Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Received Amount
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($totalReceived, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-3x mb-2 text-success" data-toggle="tooltip" title="Received Amount"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Income Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Income
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($pendingIncome, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-3x mb-2 text-warning" data-toggle="tooltip" title="Pending Income"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Profit/Loss Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $netProfitLoss >= 0 ? 'info' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $netProfitLoss >= 0 ? 'info' : 'danger' }} text-uppercase mb-1">
                                Net Profit/Loss
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($netProfitLoss, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-3x mb-2 text-{{ $netProfitLoss >= 0 ? 'info' : 'danger' }}" data-toggle="tooltip" title="Net Profit or Loss"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Type Breakdown -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Income by Type</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-primary mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Corporate Income</h6>
                                    <h4 class="text-primary">${{ number_format($corporateIncome, 2) }}</h4>
                                    <small class="text-muted">
                                        {{ $totalIncome > 0 ? number_format(($corporateIncome / $totalIncome) * 100, 1) : 0 }}% of total
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-info mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Online Income</h6>
                                    <h4 class="text-info">${{ number_format($onlineIncome, 2) }}</h4>
                                    <small class="text-muted">
                                        {{ $totalIncome > 0 ? number_format(($onlineIncome / $totalIncome) * 100, 1) : 0 }}% of total
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Financial Overview</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-danger">
                                <i class="fas fa-file-invoice-dollar fa-3x mb-2" data-toggle="tooltip" title="Expenses"></i>
                                <h6>Expenses</h6>
                                <h5>${{ number_format($totalExpenses, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-success">
                                <i class="fas fa-hand-holding-usd fa-3x mb-2" data-toggle="tooltip" title="Receivables"></i>
                                <h6>Receivables</h6>
                                <h5>${{ number_format($totalReceivables, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-warning">
                                <i class="fas fa-file-invoice-dollar fa-3x mb-2" data-toggle="tooltip" title="Payables"></i>
                                <h6>Payables</h6>
                                <h5>${{ number_format($totalPayables, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-info">
                                <i class="fas fa-piggy-bank fa-3x mb-2" data-toggle="tooltip" title="Bank Balance"></i>
                                <h6>Bank Balance</h6>
                                <h5>${{ number_format($totalBankDeposits - $totalBankWithdrawals, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Incomes & Monthly Breakdown -->
    <div class="row">
        <!-- Recent Incomes -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Incomes</h6>
                    <a href="{{ route('admin.incomes.create') }}" class="btn btn-sm btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Received</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentIncomes as $income)
                                <tr>
                                    <td>
                                        @if($income->date)
                                            {{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $income->client_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $income->type == 'corporate' ? 'primary' : 'info' }}">
                                            {{ ucfirst($income->type) }}
                                        </span>
                                    </td>
                                    <td class="text-success">${{ number_format($income->amount, 2) }}</td>
                                    <td class="text-success">${{ number_format($income->received_value, 2) }}</td>
                                    <td>
                                        @if($income->amount == $income->received_value)
                                            <span class="badge badge-success">Paid</span>
                                        @elseif($income->received_value > 0)
                                            <span class="badge badge-warning">Partial</span>
                                        @else
                                            <span class="badge badge-danger">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No income records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Income Breakdown -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Income (Last 6 Months)</h6>
                </div>
                <div class="card-body">
                    @forelse($monthlyIncome as $monthly)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="font-weight-bold">
                                {{ \Carbon\Carbon::createFromDate($monthly->year, $monthly->month, 1)->format('M Y') }}
                            </span>
                            <span class="text-success">${{ number_format($monthly->total_amount, 2) }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ $monthly->total_amount > 0 ? min(($monthly->total_amount / $totalIncome) * 100, 100) : 0 }}%">
                            </div>
                        </div>
                        <small class="text-muted">
                            Received: ${{ number_format($monthly->total_received, 2) }}
                        </small>
                    </div>
                    @empty
                    <p class="text-center text-muted">No monthly data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialize tooltips -->
@push('scripts')
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endpush

@endsection
