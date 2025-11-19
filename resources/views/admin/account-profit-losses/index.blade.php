@extends('admin.master')
@section('title', 'Profit & Loss')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Profit & Loss Accounts</h4>
                    <a href="{{ route('admin.account-profit-losses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>RFQ ID</th>
                                    <th>Sales Price</th>
                                    <th>Cost Price</th>
                                    <th>Profit</th>
                                    <th>Loss</th>
                                    <th>Gross Margin %</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profitLosses as $pl)
                                <tr>
                                    <td>{{ $pl->id }}</td>
                                    <td>{{ $pl->rfq_id }}</td>
                                    <td class="text-success">{{ number_format($pl->sales_price, 2) }}</td>
                                    <td class="text-danger">{{ number_format($pl->cost_price, 2) }}</td>
                                    <td class="text-success">{{ number_format($pl->profit, 2) }}</td>
                                    <td class="text-danger">{{ number_format($pl->loss, 2) }}</td>
                                    <td class="{{ $pl->gross_makup_percentage >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($pl->gross_makup_percentage, 2) }}%
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.account-profit-losses.show', $pl->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.account-profit-losses.edit', $pl->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.account-profit-losses.destroy', $pl->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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