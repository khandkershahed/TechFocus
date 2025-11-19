@extends('admin.master')
@section('title', 'Profit & Loss Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Profit & Loss Details</h4>
                    <a href="{{ route('admin.account-profit-losses.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $accountProfitLoss->id }}</td>
                                </tr>
                                <tr>
                                    <th>RFQ ID</th>
                                    <td>{{ $accountProfitLoss->rfq_id }}</td>
                                </tr>
                                <tr>
                                    <th>Sales Price</th>
                                    <td class="text-success">{{ number_format($accountProfitLoss->sales_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Cost Price</th>
                                    <td class="text-danger">{{ number_format($accountProfitLoss->cost_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Gross Markup Amount</th>
                                    <td class="{{ $accountProfitLoss->gross_makup_ammount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($accountProfitLoss->gross_makup_ammount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Gross Markup Percentage</th>
                                    <td class="{{ $accountProfitLoss->gross_makup_percentage >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($accountProfitLoss->gross_makup_percentage, 2) }}%
                                    </td>
                                </tr>
                                <tr>
                                    <th>Net Profit Amount</th>
                                    <td class="text-success">{{ number_format($accountProfitLoss->net_profit_ammount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Net Profit Percentage</th>
                                    <td class="text-success">{{ number_format($accountProfitLoss->net_profit_percentage, 2) }}%</td>
                                </tr>
                                <tr>
                                    <th>Profit</th>
                                    <td class="text-success">{{ number_format($accountProfitLoss->profit, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Loss</th>
                                    <td class="text-danger">{{ number_format($accountProfitLoss->loss, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.account-profit-losses.edit', $accountProfitLoss->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.account-profit-losses.destroy', $accountProfitLoss->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this profit & loss record?')">
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
