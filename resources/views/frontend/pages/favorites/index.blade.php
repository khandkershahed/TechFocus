@extends('frontend.master')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">My Favorites</h2>

    @if($favorites->isEmpty())
        <p class="text-center">You have no favorite products yet.</p>
    @else
        <div class="row">
            @foreach($favorites as $fav)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img src="{{ $fav->product->image ?? '/default.png' }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $fav->product->name }}</h5>
                            <form action="{{ route('favorites.destroy', $fav->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
