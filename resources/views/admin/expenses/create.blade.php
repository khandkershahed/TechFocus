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
                            <!-- Expense Category -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expense_category_id" class="font-weight-bold">Category *</label>
                                    <select class="form-control @error('expense_category_id') is-invalid @enderror"
                                            id="expense_category_id"
                                            name="expense_category_id"
                                            required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('expense_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Expense Type -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expense_type_id" class="font-weight-bold">Type *</label>
                                    <select class="form-control @error('expense_type_id') is-invalid @enderror"
                                            id="expense_type_id"
                                            name="expense_type_id"
                                            required
                                            disabled>
                                        <option value="">Select Category First</option>
                                    </select>
                                    @error('expense_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Date and Amount -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date *</label>
                                    <input type="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           id="date"
                                           name="date"
                                           value="{{ old('date') }}"
                                           required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount *</label>
                                    <input type="number"
                                           step="0.01"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           id="amount"
                                           name="amount"
                                           value="{{ old('amount') }}"
                                           required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Particulars -->
                        <div class="form-group">
                            <label for="particulars">Particulars *</label>
                            <input type="text"
                                   class="form-control @error('particulars') is-invalid @enderror"
                                   id="particulars"
                                   name="particulars"
                                   value="{{ old('particulars') }}"
                                   required>
                            @error('particulars')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Voucher -->
                        <div class="form-group">
                            <label for="voucher">Voucher (File)</label>
                            <input type="file"
                                   class="form-control @error('voucher') is-invalid @enderror"
                                   id="voucher"
                                   name="voucher">
                            @error('voucher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror"
                                      id="comment"
                                      name="comment"
                                      rows="3">{{ old('comment') }}</textarea>
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

{{-- jQuery AJAX for Expense Type --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const typeSelect = $('#expense_type_id');
    const oldTypeId = "{{ old('expense_type_id') }}";

    function loadTypes(categoryId) {
        typeSelect.prop('disabled', true);
        typeSelect.html('<option value="">Loading...</option>');

        if (categoryId) {
            $.ajax({
                url: '/admin/expense-types-by-category/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let options = '<option value="">-- Select Type --</option>';
                    $.each(data, function(key, type) {
                        let selected = (oldTypeId == type.id) ? 'selected' : '';
                        options += `<option value="${type.id}" ${selected}>${type.name}</option>`;
                    });
                    typeSelect.html(options);
                    typeSelect.prop('disabled', false);
                },
                error: function() {
                    typeSelect.html('<option value="">Error loading types</option>');
                }
            });
        } else {
            typeSelect.html('<option value="">Select Category First</option>');
            typeSelect.prop('disabled', true);
        }
    }

    // Initial load if old category exists
    const categoryId = $('#expense_category_id').val();
    if (categoryId) {
        loadTypes(categoryId);
    }

    // On category change
    $('#expense_category_id').change(function() {
        loadTypes($(this).val());
    });
});
</script>
@endsection
