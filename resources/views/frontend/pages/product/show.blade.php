@extends('frontend.master')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($product->thumbnail) }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>Brand: {{ $product->brand->title ?? 'N/A' }}</p>
            <p>Price: ${{ $product->price }}</p>
            <p>SKU: {{ $product->sku_code }}</p>
            <p>{!! $product->description ?? '' !!}</p>
        </div>
    </div>
</div>
@endsection
