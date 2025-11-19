@extends('admin.master')
@section('title', 'Create Profit & Loss')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Profit & Loss Account</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.account-profit-losses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">RFQ *</label>
                                    <select class="form-control @error('rfq_id') is-invalid @enderror" id="rfq_id" name="rfq_id" required>
                                        <option value="">Select RFQ</option>
                                        @foreach($rfqs as $rfq)
                                            <option value="{{ $rfq->id }}" {{ old('rfq_id') == $rfq->id ? 'selected' : '' }}>
                                                {{ $rfq->id }} - {{ $rfq->title ?? 'RFQ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rfq_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sales_price">Sales Price *</label>
                                    <input type="number" step="0.01" class="form-control @error('sales_price') is-invalid @enderror" id="sales_price" name="sales_price" value="{{ old('sales_price') }}" required>
                                    @error('sales_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cost_price">Cost Price *</label>
                                    <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" name="cost_price" value="{{ old('cost_price') }}" required>
                                    @error('cost_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gross_makup_percentage">Gross Markup Percentage</label>
                                    <input type="number" step="0.01" class="form-control @error('gross_makup_percentage') is-invalid @enderror" id="gross_makup_percentage" name="gross_makup_percentage" value="{{ old('gross_makup_percentage') }}">
                                    @error('gross_makup_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gross_makup_ammount">Gross Markup Amount</label>
                                    <input type="number" step="0.01" class="form-control @error('gross_makup_ammount') is-invalid @enderror" id="gross_makup_ammount" name="gross_makup_ammount" value="{{ old('gross_makup_ammount') }}">
                                    @error('gross_makup_ammount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="net_profit_percentage">Net Profit Percentage</label>
                                    <input type="number" step="0.01" class="form-control @error('net_profit_percentage') is-invalid @enderror" id="net_profit_percentage" name="net_profit_percentage" value="{{ old('net_profit_percentage') }}">
                                    @error('net_profit_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="net_profit_ammount">Net Profit Amount</label>
                                    <input type="number" step="0.01" class="form-control @error('net_profit_ammount') is-invalid @enderror" id="net_profit_ammount" name="net_profit_ammount" value="{{ old('net_profit_ammount') }}">
                                    @error('net_profit_ammount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profit">Profit</label>
                                    <input type="number" step="0.01" class="form-control @error('profit') is-invalid @enderror" id="profit" name="profit" value="{{ old('profit') }}">
                                    @error('profit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loss">Loss</label>
                                    <input type="number" step="0.01" class="form-control @error('loss') is-invalid @enderror" id="loss" name="loss" value="{{ old('loss') }}">
                                    @error('loss')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Profit & Loss</button>
                        <a href="{{ route('admin.account-profit-losses.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesPriceInput = document.getElementById('sales_price');
    const costPriceInput = document.getElementById('cost_price');
    const grossMarkupPercentageInput = document.getElementById('gross_makup_percentage');
    const grossMarkupAmountInput = document.getElementById('gross_makup_ammount');
    const profitInput = document.getElementById('profit');
    const lossInput = document.getElementById('loss');

    function calculateProfitLoss() {
        const salesPrice = parseFloat(salesPriceInput.value) || 0;
        const costPrice = parseFloat(costPriceInput.value) || 0;
        
        const profitLoss = salesPrice - costPrice;
        const grossMarkupAmount = salesPrice - costPrice;
        const grossMarkupPercentage = costPrice > 0 ? (grossMarkupAmount / costPrice) * 100 : 0;

        // Update fields
        grossMarkupAmountInput.value = grossMarkupAmount.toFixed(2);
        grossMarkupPercentageInput.value = grossMarkupPercentage.toFixed(2);
        
        if (profitLoss >= 0) {
            profitInput.value = profitLoss.toFixed(2);
            lossInput.value = '0.00';
        } else {
            profitInput.value = '0.00';
            lossInput.value = Math.abs(profitLoss).toFixed(2);
        }
    }

    salesPriceInput.addEventListener('input', calculateProfitLoss);
    costPriceInput.addEventListener('input', calculateProfitLoss);
});
</script>
@endsection