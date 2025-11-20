@extends('admin.master')
@section('title', 'Edit Expense')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>Edit Expense</h4></div>
        <div class="card-body">
            <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <label>Category *</label>
                        <select name="expense_category_id" id="expense_category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $expense->expense_category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Type *</label>
                        <select name="expense_type_id" id="expense_type_id" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $expense->expense_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6"><input type="date" name="date" value="{{ $expense->date->format('Y-m-d') }}" class="form-control" required></div>
                    <div class="col-md-6"><input type="number" name="amount" step="0.01" value="{{ $expense->amount }}" class="form-control" required></div>
                </div>

                <div class="mt-3">
                    <input type="text" name="particulars" value="{{ $expense->particulars }}" class="form-control" required>
                </div>

                <div class="mt-3">
                    <input type="file" name="voucher" class="form-control">
                    @if($expense->voucher)
                        <a href="{{ asset('storage/' . $expense->voucher) }}" target="_blank">Current Voucher</a>
                    @endif
                </div>

                <div class="mt-3">
                    <textarea name="comment" class="form-control">{{ $expense->comment }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update Expense</button>
            </form>
        </div>
    </div>
</div>
@endsection
