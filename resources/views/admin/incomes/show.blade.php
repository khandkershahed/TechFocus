@extends('admin.master')
@section('title', 'Income Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Income Details</h4>
                    <a href="{{ route('admin.incomes.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $income->id }}</td>
                                </tr>
                                <tr>
                                    <th>RFQ ID</th>
                                    <td>{{ $income->rfq_id ?? 'N/A' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Order ID</th>
                                    <td>{{ $income->order_id ?? 'N/A' }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $income->client_name }}</td>
                                </tr>
                                <tr>
                                    <th>PO Reference</th>
                                    <td>{{ $income->po_reference ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Date</th>
                                    <td>
                                        @if($income->date)
                                            {{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Month</th>
                                    <td>{{ $income->month ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>
                                        <span class="badge bg-{{ $income->type == 'corporate' ? 'primary' : 'info' }}">
                                            {{ ucfirst($income->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td class="text-success">{{ number_format($income->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Received Value</th>
                                    <td class="text-success">{{ number_format($income->received_value, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.incomes.edit', $income->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this income?')">
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