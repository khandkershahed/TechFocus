@extends('admin.master')
@section('title', 'Edit Accounts Receivable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Accounts Receivable</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.accounts-receivables.update', $accountsReceivable->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">RFQ *</label>
                                    <select class="form-control @error('rfq_id') is-invalid @enderror" id="rfq_id" name="rfq_id" required>
                                        <option value="">Select RFQ</option>
                                        @foreach($rfqs as $rfq)
                                            <option value="{{ $rfq->id }}" {{ old('rfq_id', $accountsReceivable->rfq_id) == $rfq->id ? 'selected' : '' }}>
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
                                        <option value="cash" {{ old('payment_type', $accountsReceivable->payment_type) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_type', $accountsReceivable->payment_type) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cheque" {{ old('payment_type', $accountsReceivable->payment_type) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        <option value="online" {{ old('payment_type', $accountsReceivable->payment_type) == 'online' ? 'selected' : '' }}>Online</option>
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
                                    <label for="client_name">Client Name *</label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name', $accountsReceivable->client_name) }}" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_po_number">Client PO Number</label>
                                    <input type="text" class="form-control @error('client_po_number') is-invalid @enderror" id="client_po_number" name="client_po_number" value="{{ old('client_po_number', $accountsReceivable->client_po_number) }}">
                                    @error('client_po_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_date">PO Date</label>
                                    <input type="date" class="form-control @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ old('po_date', $accountsReceivable->po_date) }}">
                                    @error('po_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date *</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $accountsReceivable->due_date) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_amount">Client Amount *</label>
                                    <input type="number" step="0.01" class="form-control @error('client_amount') is-invalid @enderror" id="client_amount" name="client_amount" value="{{ old('client_amount', $accountsReceivable->client_amount) }}" required>
                                    @error('client_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_days">Credit Days</label>
                                    <input type="number" class="form-control @error('credit_days') is-invalid @enderror" id="credit_days" name="credit_days" value="{{ old('credit_days', $accountsReceivable->credit_days) }}">
                                    @error('credit_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_payment_status">Payment Status</label>
                                    <select class="form-control @error('client_payment_status') is-invalid @enderror" id="client_payment_status" name="client_payment_status">
                                        <option value="pending" {{ old('client_payment_status', $accountsReceivable->client_payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="partial" {{ old('client_payment_status', $accountsReceivable->client_payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="paid" {{ old('client_payment_status', $accountsReceivable->client_payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ old('client_payment_status', $accountsReceivable->client_payment_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('client_payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_payment_value">Payment Value</label>
                                    <input type="number" step="0.01" class="form-control @error('client_payment_value') is-invalid @enderror" id="client_payment_value" name="client_payment_value" value="{{ old('client_payment_value', $accountsReceivable->client_payment_value) }}">
                                    @error('client_payment_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_po">Client PO File</label>
                                    <input type="file" class="form-control @error('client_po') is-invalid @enderror" id="client_po" name="client_po">
                                    @if($accountsReceivable->client_po)
                                        <small class="form-text text-muted">
                                            Current file: {{ $accountsReceivable->client_po }}
                                        </small>
                                    @endif
                                    @error('client_po')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice">Invoice File</label>
                                    <input type="file" class="form-control @error('invoice') is-invalid @enderror" id="invoice" name="invoice">
                                    @if($accountsReceivable->invoice)
                                        <small class="form-text text-muted">
                                            Current file: {{ $accountsReceivable->invoice }}
                                        </small>
                                    @endif
                                    @error('invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_money_receipt">Money Receipt Number</label>
                            <input type="text" class="form-control @error('client_money_receipt') is-invalid @enderror" id="client_money_receipt" name="client_money_receipt" value="{{ old('client_money_receipt', $accountsReceivable->client_money_receipt) }}">
                            @error('client_money_receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Receivable</button>
                        <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection