@extends('frontend.master')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 main-color">Compare Products</h2>

    @if($products->isEmpty())
        <p class="text-center">No products selected for comparison.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Feature</th>
                        @foreach($products as $product)
                            <th>{{ $product->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Thumbnail</td>
                        @foreach($products as $product)
                            <td>
                                <img src="{{ asset($product->thumbnail ?? 'frontend/assets/images/default.png') }}" 
                                     alt="{{ $product->name }}" style="max-width: 100px;">
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Price</td>
                        @foreach($products as $product)
                            <td>{{ $product->price ?? 'N/A' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Short Description</td>
                        @foreach($products as $product)
                            <td>{!! $product->short_desc ?? 'N/A' !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Overview</td>
                        @foreach($products as $product)
                            <td>{!! $product->overview ?? 'N/A' !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Specification</td>
                        @foreach($products as $product)
                            <td>{!! $product->specification ?? 'N/A' !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Accessories</td>
                        @foreach($products as $product)
                            <td>{!! $product->accessories ?? 'N/A' !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Warranty</td>
                        @foreach($products as $product)
                            <td>{!! $product->warranty ?? 'N/A' !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Stock</td>
                        @foreach($products as $product)
                            <td>{{ $product->stock ?? 'N/A' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>SKU Code</td>
                        @foreach($products as $product)
                            <td>{{ $product->sku_code ?? 'N/A' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Brand</td>
                        @foreach($products as $product)
                            <td>{{ $product->brand?->name ?? 'N/A' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Categories</td>
                        @foreach($products as $product)
                            <td>
                                @if(is_array($product->category_id))
                                    @foreach($product->category_id as $cat)
                                        <span class="badge bg-secondary">{{ $cat }}</span>
                                    @endforeach
                                @else
                                    {{ $product->category_id ?? 'N/A' }}
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Color</td>
                        @foreach($products as $product)
                            <td>
                                @if(is_array($product->color_id))
                                    @foreach($product->color_id as $color)
                                        <span class="badge bg-info">{{ $color }}</span>
                                    @endforeach
                                @else
                                    {{ $product->color_id ?? 'N/A' }}
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>Action</td>
                        @foreach($products as $product)
                            <td>
                                <a href="{{ route('products.compare.remove', $product->id) }}" class="btn btn-sm btn-outline-danger">
                                    Remove
                                </a>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Back</a>
            <a href="{{ route('products.compare.index') }}" class="btn btn-primary">Refresh Comparison</a>
        </div>
    @endif
</div>
@endsection
