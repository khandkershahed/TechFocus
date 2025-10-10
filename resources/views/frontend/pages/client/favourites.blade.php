@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
@include('frontend.pages.client.partials.page_header')

<div class="container my-5">
    <h2 class="text-center mb-4 main-color">My Favourites</h2>

    @if($favorites->isEmpty())
        <div class="row my-5">
            <div class="col-lg-6 offset-lg-3">
                <div class="card border-0 rounded-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2 bg-light main-color">
                            No Products have been selected yet as favourites.
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($favorites as $fav)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-2">
                        <img src="{{ asset($fav->product->image ?? 'frontend/assets/images/default.png') }}"
                             class="card-img-top"
                             alt="{{ $fav->product->name ?? 'Product Image' }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $fav->product->name ?? 'Unnamed Product' }}</h5>

                            <form action="{{ route('favorites.destroy', $fav->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm mt-2">
                                    <i class="fa fa-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="container">
    <div class="row p-3">
        <div class="col-lg-12 col-sm-12">
            <p class="sub-color text-center w-75 mx-auto">
                *Prices are pre-tax. They exclude delivery charges and customs duties and do not include additional charges for installation or activation options.
                Prices are indicative only and may vary by country, with changes to the cost of raw materials and exchange rates.
            </p>
        </div>
    </div>
</div>
@endsection
