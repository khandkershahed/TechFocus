@extends('admin.master')
@section('title', 'Accounts Payable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Payable</h4>
                    <a href="{{ route('admin.accounts-payables.create') }}" class="btn btn-primary btn-sm">
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
                                    <th>Principal Name</th>
                                    <th>RFQ ID</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payables as $payable)
                                <tr>
                                    <td>{{ $payable->id }}</td>
                                    <td>{{ $payable->principal_name }}</td>
                                    <td>{{ $payable->rfq_id }}</td>
                                    <td class="text-danger">{{ number_format($payable->principal_amount, 2) }}</td>
                                    <td>
                                        @if($payable->due_date)
                                            {{ \Carbon\Carbon::parse($payable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $payable->principal_payment_status == 'paid' ? 'success' : ($payable->principal_payment_status == 'partial' ? 'warning' : ($payable->principal_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $payable->principal_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.accounts-payables.show', $payable->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.accounts-payables.edit', $payable->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.accounts-payables.destroy', $payable->id) }}" method="POST" class="d-inline">
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