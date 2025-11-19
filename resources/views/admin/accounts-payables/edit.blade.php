@extends('admin.master')
@section('title', 'Edit Accounts Payable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Accounts Payable</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.accounts-payables.update', $accountsPayable->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">RFQ *</label>
                                    <select class="form-control @error('rfq_id') is-invalid @enderror" id="rfq_id" name="rfq_id" required>
                                        <option value="">Select RFQ</option>
                                        @foreach($rfqs as $rfq)
                                            <option value="{{ $rfq->id }}" {{ old('rfq_id', $accountsPayable->rfq_id) == $rfq->id ? 'selected' : '' }}>
                                                {{ $rfq->id }} - {{ $rfq->title ?? 'RFQ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rfq_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type</label>
                                    <select class="form-control @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type">
                                        <option value="">Select Payment Type</option>
                                        <option value="cash" {{ old('payment_type', $accountsPayable->payment_type) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_type', $accountsPayable->payment_type) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cheque" {{ old('payment_type', $accountsPayable->payment_type) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        <option value="online" {{ old('payment_type', $accountsPayable->payment_type) == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_name">Principal Name *</label>
                                    <input type="text" class="form-control @error('principal_name') is-invalid @enderror" id="principal_name" name="principal_name" value="{{ old('principal_name', $accountsPayable->principal_name) }}" required>
                                    @error('principal_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_po_number">Principal PO Number</label>
                                    <input type="text" class="form-control @error('principal_po_number') is-invalid @enderror" id="principal_po_number" name="principal_po_number" value="{{ old('principal_po_number', $accountsPayable->principal_po_number) }}">
                                    @error('principal_po_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_amount">Principal Amount *</label>
                                    <input type="number" step="0.01" class="form-control @error('principal_amount') is-invalid @enderror" id="principal_amount" name="principal_amount" value="{{ old('principal_amount', $accountsPayable->principal_amount) }}" required>
                                    @error('principal_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_value">PO Value</label>
                                    <input type="text" class="form-control @error('po_value') is-invalid @enderror" id="po_value" name="po_value" value="{{ old('po_value', $accountsPayable->po_value) }}">
                                    @error('po_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date *</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $accountsPayable->due_date) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_date">Delivery Date</label>
                                    <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $accountsPayable->delivery_date) }}">
                                    @error('delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_days">Credit Days</label>
                                    <input type="number" class="form-control @error('credit_days') is-invalid @enderror" id="credit_days" name="credit_days" value="{{ old('credit_days', $accountsPayable->credit_days) }}">
                                    @error('credit_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_payment_status">Payment Status</label>
                                    <select class="form-control @error('principal_payment_status') is-invalid @enderror" id="principal_payment_status" name="principal_payment_status">
                                        <option value="pending" {{ old('principal_payment_status', $accountsPayable->principal_payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="partial" {{ old('principal_payment_status', $accountsPayable->principal_payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="paid" {{ old('principal_payment_status', $accountsPayable->principal_payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ old('principal_payment_status', $accountsPayable->principal_payment_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('principal_payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_payment_value">Payment Value</label>
                                    <input type="number" step="0.01" class="form-control @error('principal_payment_value') is-invalid @enderror" id="principal_payment_value" name="principal_payment_value" value="{{ old('principal_payment_value', $accountsPayable->principal_payment_value) }}">
                                    @error('principal_payment_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice">Invoice File</label>
                                    <input type="file" class="form-control @error('invoice') is-invalid @enderror" id="invoice" name="invoice">
                                    @if($accountsPayable->invoice)
                                        <small class="form-text text-muted">
                                            Current file: {{ $accountsPayable->invoice }}
                                        </small>
                                    @endif
                                    @error('invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal_po">Principal PO File</label>
                                    <input type="file" class="form-control @error('principal_po') is-invalid @enderror" id="principal_po" name="principal_po">
                                    @if($accountsPayable->principal_po)
                                        <small class="form-text text-muted">
                                            Current file: {{ $accountsPayable->principal_po }}
                                        </small>
                                    @endif
                                    @error('principal_po')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Payable</button>
                        <a href="{{ route('admin.accounts-payables.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection