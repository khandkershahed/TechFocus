@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 main-color">Compare Products</h2>

    @if($products->isEmpty())
        <p class="text-center">No products selected for comparison yet.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset($product->thumbnail ?? 'frontend/assets/images/default.png') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p>Price: {{ $product->price ?? 'N/A' }}</p>
                            <a href="{{ route('products.compare.remove', $product->id) }}" class="btn btn-outline-danger btn-sm">Remove</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
