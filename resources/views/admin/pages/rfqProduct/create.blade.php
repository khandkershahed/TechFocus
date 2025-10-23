@extends('admin.master')

@section('title', 'Add RFQ Product')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add New RFQ Product</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rfqProducts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>RFQ</label>
                        <select name="rfq_id" class="form-control" required>
                            <option value="">Select RFQ</option>
                            @foreach($rfqs as $rfq)
                                <option value="{{ $rfq->id }}">{{ $rfq->id }} - {{ $rfq->title ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Product</label>
                        <select name="product_id" class="form-control">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Quantity</label>
                        <input type="number" name="qty" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Unit Price</label>
                        <input type="number" name="unit_price" class="form-control" step="0.01" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Discount (%)</label>
                        <input type="number" name="discount" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Brand</label>
                        <select name="brand_name" class="form-control">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Product Description</label>
                        <textarea name="product_des" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <a href="{{ route('rfqProducts.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
