@extends('admin.master')
@section('title', 'Create Expense')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Expense</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expense_category">Category *</label>
                                    <select class="form-control @error('expense_category') is-invalid @enderror" id="expense_category" name="expense_category" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('expense_category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('expense_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expense_type">Type *</label>
                                    <select class="form-control @error('expense_type') is-invalid @enderror" id="expense_type" name="expense_type" required>
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('expense_type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('expense_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date *</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount *</label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="particulars">Particulars *</label>
                            <input type="text" class="form-control @error('particulars') is-invalid @enderror" id="particulars" name="particulars" value="{{ old('particulars') }}" required>
                            @error('particulars')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="voucher">Voucher (File)</label>
                            <input type="file" class="form-control @error('voucher') is-invalid @enderror" id="voucher" name="voucher">
                            @error('voucher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Expense</button>
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('expense_category').addEventListener('change', function() {
    const categoryId = this.value;
    const typeSelect = document.getElementById('expense_type');
    
    if (categoryId) {
        fetch(`/admin/expense-types-by-category/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                typeSelect.innerHTML = '<option value="">Select Type</option>';
                data.forEach(type => {
                    typeSelect.innerHTML += `<option value="${type.id}">${type.name}</option>`;
                });
            });
    } else {
        typeSelect.innerHTML = '<option value="">Select Type</option>';
    }
});
</script>
@endsection