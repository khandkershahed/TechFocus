@extends('admin.master')
@section('title', 'Accounts Receivable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Accounts Receivable</h4>
                    <a href="{{ route('admin.accounts-receivables.create') }}" class="btn btn-primary btn-sm">
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
                                    <th>Client Name</th>
                                    <th>RFQ ID</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivables as $receivable)
                                <tr>
                                    <td>{{ $receivable->id }}</td>
                                    <td>{{ $receivable->client_name }}</td>
                                    <td>{{ $receivable->rfq_id }}</td>
                                    <td class="text-success">{{ number_format($receivable->client_amount, 2) }}</td>
                                    <td>
                                        @if($receivable->due_date)
                                            {{ \Carbon\Carbon::parse($receivable->due_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $receivable->client_payment_status == 'paid' ? 'success' : ($receivable->client_payment_status == 'partial' ? 'warning' : ($receivable->client_payment_status == 'overdue' ? 'danger' : 'secondary')) }}">
                                            {{ $receivable->client_payment_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.accounts-receivables.show', $receivable->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.accounts-receivables.edit', $receivable->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.accounts-receivables.destroy', $receivable->id) }}" method="POST" class="d-inline">
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