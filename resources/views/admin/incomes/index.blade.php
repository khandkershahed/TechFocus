@extends('admin.master')
@section('title', 'Incomes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Incomes</h4>
                    <a href="{{ route('admin.incomes.create') }}" class="btn btn-primary btn-sm">
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
                                    <th>Client Name</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Received Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes as $income)
                                <tr>
                                    <td>{{ $income->id }}</td>
                                    <td>
                                        @if($income->date)
                                            {{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $income->client_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $income->type == 'corporate' ? 'primary' : 'info' }}">
                                            {{ ucfirst($income->type) }}
                                        </span>
                                    </td>
                                    <td class="text-success">{{ number_format($income->amount, 2) }}</td>
                                    <td class="text-success">{{ number_format($income->received_value, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.incomes.show', $income->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.incomes.destroy', $income->id) }}" method="POST" class="d-inline">
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