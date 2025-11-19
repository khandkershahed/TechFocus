@extends('admin.master')
@section('title', 'Banking Transactions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Banking Transactions</h4>
                    <a href="{{ route('admin.bankings.create') }}" class="btn btn-primary btn-sm">
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
                                    <th>Date</th>
                                    <th>Bank Name</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankings as $banking)
                                <tr>
                                    <td>{{ $banking->id }}</td>
                                    <td>
                                        @if($banking->date)
                                            {{ \Carbon\Carbon::parse($banking->date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $banking->bank_name }}</td>
                                    <td class="text-success">{{ $banking->deposit ? number_format($banking->deposit, 2) : '0.00' }}</td>
                                    <td class="text-danger">{{ $banking->withdraw ? number_format($banking->withdraw, 2) : '0.00' }}</td>
                                    <td>{{ $banking->purpose ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $banking->status == 'active' ? 'success' : 'warning' }}">
                                            {{ $banking->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bankings.show', $banking->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bankings.edit', $banking->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bankings.destroy', $banking->id) }}" method="POST" class="d-inline">
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