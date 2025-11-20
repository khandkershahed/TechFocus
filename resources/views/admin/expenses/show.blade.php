@extends('admin.master')
@section('title', 'View Expense')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>Expense Details</h4></div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $expense->id }}</td></tr>
                <tr><th>Date</th><td>{{ $expense->date->format('M d, Y') }}</td></tr>
               <tr><th>Category</th><td>{{ $expense->category ?? 'N/A' }}</td></tr>
                        <tr><th>Type</th><td>{{ $expense->type ?? 'N/A' }}</td></tr>

                <tr><th>Particulars</th><td>{{ $expense->particulars }}</td></tr>
                <tr><th>Amount</th><td>{{ number_format($expense->amount,2) }}</td></tr>
                <tr><th>Comment</th><td>{{ $expense->comment }}</td></tr>
                <tr><th>Voucher</th>
                    <td>
                        @if($expense->voucher)
                            <a href="{{ asset('storage/'.$expense->voucher) }}" target="_blank">View Voucher</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
</div>
@endsection
