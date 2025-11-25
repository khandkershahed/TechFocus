@extends('admin.master')
@section('title', 'Create Accounts Receivable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Accounts Receivable</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.accounts-receivables.store') }}" method="POST" enctype="multipart/form-data" id="accountsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">RFQ *</label>
                                    <select class="form-control @error('rfq_id') is-invalid @enderror" 
                                        id="rfq_id" name="rfq_id" required onchange="handleRfqChange(this.value)">
                                        <option value="">Select RFQ</option>
                                        <option value="manual" {{ old('rfq_id') == 'manual' ? 'selected' : '' }}>
                                            Manual Input (No RFQ)
                                        </option>
                                        @foreach($rfqs as $rfq)
                                            <option value="{{ $rfq->id }}" {{ old('rfq_id') == $rfq->id ? 'selected' : '' }}>
                                                {{ $rfq->rfq_code }} - {{ $rfq->name ?? 'No Name' }} - {{ $rfq->company_name ?? 'No Company' }}
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
                                        <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_type') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cheque" {{ old('payment_type') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        <option value="online" {{ old('payment_type') == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Client Information Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_name">Client Name *</label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_email">Client Email</label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror" id="client_email" name="client_email" value="{{ old('client_email') }}">
                                    @error('client_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_phone">Client Phone</label>
                                    <input type="text" class="form-control @error('client_phone') is-invalid @enderror" id="client_phone" name="client_phone" value="{{ old('client_phone') }}">
                                    @error('client_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- PO Information Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_po_number">Client PO Number</label>
                                    <input type="text" class="form-control @error('client_po_number') is-invalid @enderror" id="client_po_number" name="client_po_number" value="{{ old('client_po_number') }}">
                                    @error('client_po_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_date">PO Date</label>
                                    <input type="date" class="form-control @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ old('po_date') }}">
                                    @error('po_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Amount and Due Date Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date *</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_amount">Client Amount *</label>
                                    <input type="number" step="0.01" class="form-control @error('client_amount') is-invalid @enderror" id="client_amount" name="client_amount" value="{{ old('client_amount') }}" required>
                                    @error('client_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Credit and Payment Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_days">Credit Days</label>
                                    <input type="number" class="form-control @error('credit_days') is-invalid @enderror" id="credit_days" name="credit_days" value="{{ old('credit_days') }}">
                                    @error('credit_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_payment_status">Payment Status</label>
                                    <select class="form-control @error('client_payment_status') is-invalid @enderror" id="client_payment_status" name="client_payment_status">
                                        <option value="pending" {{ old('client_payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="partial" {{ old('client_payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="paid" {{ old('client_payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ old('client_payment_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('client_payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_payment_value">Payment Value</label>
                                    <input type="number" step="0.01" class="form-control @error('client_payment_value') is-invalid @enderror" id="client_payment_value" name="client_payment_value" value="{{ old('client_payment_value') }}">
                                    @error('client_payment_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_money_receipt">Money Receipt Number</label>
                                    <input type="text" class="form-control @error('client_money_receipt') is-invalid @enderror" id="client_money_receipt" name="client_money_receipt" value="{{ old('client_money_receipt') }}">
                                    @error('client_money_receipt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- File Uploads -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_po_file">Client PO File</label>
                                    <input type="file" class="form-control @error('client_po') is-invalid @enderror" id="client_po" name="client_po">
                                    @error('client_po')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice">Invoice File</label>
                                    <input type="file" class="form-control @error('invoice') is-invalid @enderror" id="invoice" name="invoice">
                                    @error('invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Receivable</button>
                        <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function handleRfqChange(rfqId) {
    if (rfqId && rfqId !== 'manual') {
        loadRfqDetails(rfqId);
        // makeFieldsReadOnly(true);
    } else {
        clearFormFields();
        makeFieldsReadOnly(false);
    }
}

function loadRfqDetails(rfqId) {
    const fieldsToLoad = ['client_name', 'client_email', 'client_phone', 'company_name', 'client_po_number', 'po_date', 'client_amount'];
    fieldsToLoad.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.placeholder = 'Loading...';
    });

    fetch('/admin/get-rfq-details/' + rfqId)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const fieldMappings = {
                    'client_name': data.data.client_name,
                    'client_email': data.data.client_email,
                    'client_phone': data.data.client_phone,
                    'company_name': data.data.company_name,
                    'client_po_number': data.data.client_po_number,
                    'po_date': data.data.po_date,
                    'client_amount': data.data.client_amount
                };
                Object.keys(fieldMappings).forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = fieldMappings[fieldId] || '';
                });

                if (data.data.po_date) {
                    const poDate = new Date(data.data.po_date);
                    const dueDate = new Date(poDate);
                    dueDate.setDate(dueDate.getDate() + 30);
                    document.getElementById('due_date').value = dueDate.toISOString().split('T')[0];
                }
            } else {
                alert(data.message);
            }
        })
        .finally(() => {
            fieldsToLoad.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) field.placeholder = '';
            });
        });
}

function clearFormFields() {
    const fieldsToClear = ['client_name','client_email','client_phone','company_name','client_po_number','po_date','client_amount','due_date'];
    fieldsToClear.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });
}

function makeFieldsReadOnly(readOnly) {
    const fields = ['client_name','client_email','client_phone','company_name','client_po_number','po_date','client_amount'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.readOnly = readOnly;
    });
}

// Load preselected RFQ
document.addEventListener('DOMContentLoaded', () => {
    const rfqSelect = document.getElementById('rfq_id');
    if (rfqSelect.value) handleRfqChange(rfqSelect.value);
});
</script>

<style>
.loading {
    background-color: #f8f9fa !important;
    border-color: #6c757d !important;
}
</style>
@endsection
