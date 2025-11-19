@extends('admin.master')
@section('title', 'Create Income')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Income</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.incomes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">RFQ</label>
                                    <select class="form-control @error('rfq_id') is-invalid @enderror" id="rfq_id" name="rfq_id">
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
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_id">Order</label>
                                    <select class="form-control @error('order_id') is-invalid @enderror" id="order_id" name="order_id">
                                        <option value="">Select Order</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                                {{ $order->id }} - {{ $order->order_number ?? 'Order' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
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
                                    <label for="month">Month</label>
                                    <input type="text" class="form-control @error('month') is-invalid @enderror" id="month" name="month" value="{{ old('month') }}">
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                                    <label for="po_reference">PO Reference</label>
                                    <input type="text" class="form-control @error('po_reference') is-invalid @enderror" id="po_reference" name="po_reference" value="{{ old('po_reference') }}">
                                    @error('po_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type *</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="corporate" {{ old('type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                        <option value="online" {{ old('type') == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('type')
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
                            <label for="received_value">Received Value</label>
                            <input type="number" step="0.01" class="form-control @error('received_value') is-invalid @enderror" id="received_value" name="received_value" value="{{ old('received_value') }}">
                            @error('received_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Income</button>
                        <a href="{{ route('admin.incomes.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection