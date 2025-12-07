@extends('admin.master')
@section('title', 'Account Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Account Dashboard</h1>
        <div class="d-flex">
            <a href="{{ route('admin.incomes.index') }}" class="px-4 py-2 me-2 btn btn-primary">
                <i class="fas fa-money-bill-wave"></i> View All Incomes
            </a>
            <a href="{{ route('admin.incomes.create') }}" class="px-4 py-2 btn btn-success">
                <i class="fas fa-plus"></i> Add Income
            </a>
        </div>
    </div>

    <!-- Comparison Link Card -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="shadow-none card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-info text-uppercase">
                              <h2>  Accounts Comparison</h2>
                            </div>
                            <div class="mb-0 text-gray-800 font-weight-bold">
                                Compare Accounts Receivable vs Payable performance and metrics
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('account.comparison') }}" class="btn btn-info">
                                <i class="mr-2 fas fa-balance-scale-left"></i>View Comparison
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
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow-none card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-primary text-uppercase">
                                Total Income
                            </div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                ${{ number_format($totalIncome, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="mb-2 fas fa-wallet fa-3x text-primary" data-toggle="tooltip" title="Total Income"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Received Income Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow-none card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs text-black font-weight-bold text-uppercase">
                                Received Amount
                            </div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                ${{ number_format($totalReceived, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="mb-2 fas fa-hand-holding-usd fa-3x text-success" data-toggle="tooltip" title="Received Amount"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Income Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow-none card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs text-black font-weight-bold text-uppercase">
                                Pending Income
                            </div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
                                ${{ number_format($pendingIncome, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="mb-2 fas fa-hourglass-half fa-3x text-warning" data-toggle="tooltip" title="Pending Income"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Profit/Loss Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="card border-left-{{ $netProfitLoss >= 0 ? 'info' : 'danger' }} shadow-none h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="text-black font-weight-bold text-{{ $netProfitLoss >= 0 ? 'info' : 'danger' }} text-uppercase mb-1">
                                Net Profit/Loss
                            </div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">
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
    <div class="mb-4 row">
        <div class="col-lg-6">
            <div class="mb-4 shadow-none card h-100">
                <div class="py-4 card-header">
                    <h3 class="m-0 text-black font-weight-bold">Income by Type</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 card border-left-primary">
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
                            <div class="mb-3 card border-left-info">
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
            <div class="mb-4 shadow-none card h-100">
                <div class="py-4 card-header">
                    <h3 class="m-0 text-black font-weight-bold">Financial Overview</h3>
                </div>
                <div class="card-body">
                    <div class="text-center row">
                        <div class="mb-3 col-6">
                            <div class="text-danger">
                                <i class="mb-2 fas fa-file-invoice-dollar fa-3x" data-toggle="tooltip" title="Expenses"></i>
                                <h6>Expenses</h6>
                                <h5>${{ number_format($totalExpenses, 2) }}</h5>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="text-success">
                                <i class="mb-2 fas fa-hand-holding-usd fa-3x" data-toggle="tooltip" title="Receivables"></i>
                                <h6>Receivables</h6>
                                <h5>${{ number_format($totalReceivables, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-warning">
                                <i class="mb-2 fas fa-file-invoice-dollar fa-3x" data-toggle="tooltip" title="Payables"></i>
                                <h6>Payables</h6>
                                <h5>${{ number_format($totalPayables, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-info">
                                <i class="mb-2 fas fa-piggy-bank fa-3x" data-toggle="tooltip" title="Bank Balance"></i>
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
    <div class="mb-4 row">
        <!-- Recent Incomes -->
        <div class="col-lg-8">
            <div class="mb-4 shadow-none card h-100">
                <div class="py-4 card-header d-flex justify-content-between align-items-center">
                    <h3 class="m-0 text-black font-weight-bold">Recent Incomes</h3>
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
            <div class="mb-4 shadow-none card h-100">
                <div class="py-5 card-header">
                    <h3 class="py-1 m-0 text-black font-weight-bold">Monthly Income (Last 6 Months)</h3>
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
                        <div class="mb-2 progress" style="height: 8px;">
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
