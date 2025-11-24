@extends('admin.master')
@section('title', 'Edit Accounts Receivable')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Edit Accounts Receivable</h4>
                    <div class="badge bg-info">ID: {{ $accountsReceivable->id }}</div>
                </div>
                <div class="card-body">
                    @if($accountsReceivable->due_date && \Carbon\Carbon::parse($accountsReceivable->due_date)->lt(now()) && $accountsReceivable->client_payment_status != 'paid')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Overdue Invoice!</strong> This invoice was due on {{ \Carbon\Carbon::parse($accountsReceivable->due_date)->format('M d, Y') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.accounts-receivables.update', $accountsReceivable->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- RFQ Selection Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><i class="fas fa-file-invoice me-2"></i>RFQ Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfq_id">RFQ *</label>
                                            <select class="form-control @error('rfq_id') is-invalid @enderror" id="rfq_id" name="rfq_id" required onchange="loadRfqDetails(this.value)">
                                                <option value="">Select RFQ</option>
                                                @foreach($rfqs as $rfq)
                                                    <option value="{{ $rfq->id }}" {{ old('rfq_id', $accountsReceivable->rfq_id) == $rfq->id ? 'selected' : '' }}>
                                                        {{ $rfq->rfq_code }} - {{ $rfq->name ?? $rfq->company_name ?? 'N/A' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('rfq_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Select an RFQ to auto-fill client information</small>
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
                            </div>
                        </div>

                        <!-- Client Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0"><i class="fas fa-user me-2"></i>Client Information</h5>
                            </div>
                            <div class="card-body">
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
                                            <label for="client_email">Client Email</label>
                                            <input type="email" class="form-control @error('client_email') is-invalid @enderror" id="client_email" name="client_email" value="{{ old('client_email', $accountsReceivable->client_email) }}">
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
                                            <input type="text" class="form-control @error('client_phone') is-invalid @enderror" id="client_phone" name="client_phone" value="{{ old('client_phone', $accountsReceivable->client_phone) }}">
                                            @error('client_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $accountsReceivable->company_name) }}">
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PO & Payment Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0"><i class="fas fa-file-contract me-2"></i>PO & Payment Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_po_number">Client PO Number</label>
                                            <input type="text" class="form-control @error('client_po_number') is-invalid @enderror" id="client_po_number" name="client_po_number" value="{{ old('client_po_number', $accountsReceivable->client_po_number) }}">
                                            @error('client_po_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="po_date">PO Date</label>
                                            <input type="date" class="form-control @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ old('po_date', $accountsReceivable->po_date ? \Carbon\Carbon::parse($accountsReceivable->po_date)->format('Y-m-d') : '') }}">
                                            @error('po_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="due_date">Due Date *</label>
                                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $accountsReceivable->due_date ? \Carbon\Carbon::parse($accountsReceivable->due_date)->format('Y-m-d') : '') }}" required>
                                            @error('due_date')
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
                            </div>
                        </div>

                        <!-- Amount & Payment Status -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave me-2"></i>Amount & Payment Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_amount">Client Amount *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control @error('client_amount') is-invalid @enderror" id="client_amount" name="client_amount" value="{{ old('client_amount', $accountsReceivable->client_amount) }}" required>
                                            </div>
                                            @error('client_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_payment_value">Payment Value</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control @error('client_payment_value') is-invalid @enderror" id="client_payment_value" name="client_payment_value" value="{{ old('client_payment_value', $accountsReceivable->client_payment_value) }}">
                                            </div>
                                            @error('client_payment_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Amount that has been paid so far</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_money_receipt">Money Receipt Number</label>
                                            <input type="text" class="form-control @error('client_money_receipt') is-invalid @enderror" id="client_money_receipt" name="client_money_receipt" value="{{ old('client_money_receipt', $accountsReceivable->client_money_receipt) }}">
                                            @error('client_money_receipt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if($accountsReceivable->client_payment_value)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <strong>Payment Progress:</strong> 
                                            ${{ number_format($accountsReceivable->client_payment_value, 2) }} of 
                                            ${{ number_format($accountsReceivable->client_amount, 2) }} paid
                                            ({{ number_format(($accountsReceivable->client_payment_value / $accountsReceivable->client_amount) * 100, 1) }}%)
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- File Attachments -->
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title mb-0"><i class="fas fa-paperclip me-2"></i>File Attachments</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_po">Client PO File</label>
                                            <input type="file" class="form-control @error('client_po') is-invalid @enderror" id="client_po" name="client_po" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            @error('client_po')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($accountsReceivable->client_po)
                                                <div class="mt-2">
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle"></i> Current file: 
                                                        <a href="{{ asset('storage/' . $accountsReceivable->client_po) }}" target="_blank" class="text-decoration-none">
                                                            {{ basename($accountsReceivable->client_po) }}
                                                        </a>
                                                    </small>
                                                    <br>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" name="remove_client_po" id="remove_client_po" value="1">
                                                        <label class="form-check-label text-danger" for="remove_client_po">
                                                            Remove current file
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <small class="form-text text-muted">No file currently attached</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice">Invoice File</label>
                                            <input type="file" class="form-control @error('invoice') is-invalid @enderror" id="invoice" name="invoice" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            @error('invoice')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($accountsReceivable->invoice)
                                                <div class="mt-2">
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle"></i> Current file: 
                                                        <a href="{{ asset('storage/' . $accountsReceivable->invoice) }}" target="_blank" class="text-decoration-none">
                                                            {{ basename($accountsReceivable->invoice) }}
                                                        </a>
                                                    </small>
                                                    <br>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" name="remove_invoice" id="remove_invoice" value="1">
                                                        <label class="form-check-label text-danger" for="remove_invoice">
                                                            Remove current file
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <small class="form-text text-muted">No file currently attached</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Receivable
                                        </button>
                                        <a href="{{ route('admin.accounts-receivables.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.accounts-receivables.show', $accountsReceivable->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Function to load RFQ details
function loadRfqDetails(rfqId) {
    console.log('Loading RFQ details for:', rfqId);
    
    if (rfqId) {
        // Show loading state
        const fieldsToLoad = ['client_name', 'client_email', 'client_phone', 'company_name', 'client_po_number', 'po_date', 'client_amount'];
        fieldsToLoad.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.placeholder = 'Loading...';
                field.style.backgroundColor = '#f8f9fa';
            }
        });
        
        // Make AJAX call
        fetch('/admin/get-rfq-details/' + rfqId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.success) {
                    // Populate all fields with RFQ data
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
                        if (field) {
                            field.value = fieldMappings[fieldId] || '';
                            console.log(`Set ${fieldId} to:`, fieldMappings[fieldId]);
                        }
                    });
                    
                    // Calculate due date if po_date is available
                    if (data.data.po_date) {
                        const poDate = new Date(data.data.po_date);
                        const dueDate = new Date(poDate);
                        dueDate.setDate(dueDate.getDate() + 30);
                        document.getElementById('due_date').value = dueDate.toISOString().split('T')[0];
                    }
                    
                    console.log('All fields populated successfully!');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading RFQ details. Please check console for details.');
            })
            .finally(() => {
                // Remove loading state
                fieldsToLoad.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.placeholder = '';
                        field.style.backgroundColor = '';
                    }
                });
            });
    }
}

// Auto-calculate due date when credit days change
document.addEventListener('DOMContentLoaded', function() {
    const creditDaysInput = document.getElementById('credit_days');
    const poDateInput = document.getElementById('po_date');
    const dueDateInput = document.getElementById('due_date');
    
    if (creditDaysInput && poDateInput && dueDateInput) {
        creditDaysInput.addEventListener('change', calculateDueDate);
        poDateInput.addEventListener('change', calculateDueDate);
    }
    
    function calculateDueDate() {
        const poDate = poDateInput.value;
        const creditDays = parseInt(creditDaysInput.value) || 0;
        
        if (poDate && creditDays > 0) {
            const dueDate = new Date(poDate);
            dueDate.setDate(dueDate.getDate() + creditDays);
            dueDateInput.value = dueDate.toISOString().split('T')[0];
        }
    }
});

// Auto-update payment status based on payment value
document.addEventListener('DOMContentLoaded', function() {
    const paymentStatusSelect = document.getElementById('client_payment_status');
    const paymentValueInput = document.getElementById('client_payment_value');
    const clientAmountInput = document.getElementById('client_amount');
    
    if (paymentValueInput && paymentStatusSelect && clientAmountInput) {
        paymentValueInput.addEventListener('change', updatePaymentStatus);
        clientAmountInput.addEventListener('change', updatePaymentStatus);
    }
    
    function updatePaymentStatus() {
        const paymentValue = parseFloat(paymentValueInput.value) || 0;
        const clientAmount = parseFloat(clientAmountInput.value) || 0;
        
        if (clientAmount > 0) {
            if (paymentValue >= clientAmount) {
                paymentStatusSelect.value = 'paid';
            } else if (paymentValue > 0) {
                paymentStatusSelect.value = 'partial';
            } else {
                paymentStatusSelect.value = 'pending';
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.card-header {
    border-bottom: 2px solid rgba(0,0,0,.125);
}
.form-group {
    margin-bottom: 1.5rem;
}
.input-group-text {
    background-color: #f8f9fa;
}
.alert {
    border-left: 4px solid;
}
</style>
@endpush