@extends('admin.master')

@section('title', 'Banking Transaction Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Banking Transaction Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bankings.index') }}">Banking Transactions</a></li>
                    <li class="breadcrumb-item active">Transaction Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaction Information</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.bankings.edit', $banking) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.bankings.destroy', $banking) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">ID</th>
                                        <td>{{ $banking->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td>{{ $banking->bank_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ \Carbon\Carbon::parse($banking->date)->format('M d, Y') }}</td>
                                    </tr>
                               
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Deposit Amount</th>
                                        <td>
                                            @if($banking->deposit)
                                                <span class="text-success font-weight-bold">
                                                    ${{ number_format($banking->deposit, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">$0.00</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Withdrawal Amount</th>
                                        <td>
                                            @if($banking->withdraw)
                                                <span class="text-danger font-weight-bold">
                                                    ${{ number_format($banking->withdraw, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">$0.00</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Type</th>
                                        <td>
                                            @if($banking->deposit && $banking->withdraw)
                                                <span class="badge badge-warning">Mixed</span>
                                            @elseif($banking->deposit)
                                                <span class="badge badge-success">Deposit</span>
                                            @elseif($banking->withdraw)
                                                <span class="badge badge-danger">Withdrawal</span>
                                            @else
                                                <span class="badge badge-secondary">No Transaction</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $banking->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $banking->updated_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($banking->deposit || $banking->withdraw)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="info-box">
                                    <span class="info-box-icon 
                                        @if($banking->deposit && !$banking->withdraw) bg-success
                                        @elseif($banking->withdraw && !$banking->deposit) bg-danger
                                        @else bg-warning @endif">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Net Transaction Amount</span>
                                        <span class="info-box-number 
                                            @if(($banking->deposit - $banking->withdraw) > 0) text-success
                                            @elseif(($banking->deposit - $banking->withdraw) < 0) text-danger
                                            @else text-secondary @endif">
                                            ${{ number_format(($banking->deposit - $banking->withdraw), 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.bankings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.bankings.edit', $banking) }}" class="btn btn-primary float-right">
                            <i class="fas fa-edit"></i> Edit Transaction
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .info-box {
        background: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        border-left: 4px solid #007bff;
    }
    .info-box-icon {
        float: left;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #007bff;
        color: white;
        border-radius: 0.25rem;
        margin-right: 1rem;
    }
    .info-box-content {
        margin-left: 85px;
    }
    .info-box-text {
        display: block;
        font-size: 14px;
        color: #6c757d;
    }
    .info-box-number {
        display: block;
        font-weight: bold;
        font-size: 24px;
    }
</style>
@endsection