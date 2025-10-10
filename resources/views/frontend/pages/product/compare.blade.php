@extends('frontend.master')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 main-color">Compare Products</h2>

    @if($products->isEmpty())
        <p class="text-center">No products selected for comparison.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-2">
                        <img src="{{ asset($product->thumbnail ?? 'frontend/assets/images/default.png') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="mb-2">Price: {{ $product->price ?? 'N/A' }}</p>
                            <a href="{{ route('products.compare.remove', $product->id) }}" class="btn btn-sm btn-outline-danger">Remove</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

                        <div class="text-center mt-4">
                   <a href="{{ route('products.compare.result') }}" class="btn btn-primary">Proceed to Compare</a>

                        </div>

    @endif
</div>
@endsection
