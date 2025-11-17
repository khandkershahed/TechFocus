@extends('admin.master')

@section('title', 'Manage Role Scopes')

@section('content')
<div class="container">
    <h2>Manage Scopes for Role: <strong>{{ $role->name }}</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.role-scopes.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Brand Scopes -->
            <div class="col-md-3">
                <h5>Brand Access</h5>
                @foreach($brands as $brand)
                    <div class="form-check">
                        <input type="checkbox" name="scopes[brand][]" 
                               value="{{ $brand->id }}" 
                               id="brand_{{ $brand->id }}"
                               {{ $role->hasScope('brand', $brand->id) ? 'checked' : '' }}>
                        <label for="brand_{{ $brand->id }}">{{ $brand->name }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Category Scopes -->
            <div class="col-md-3">
                <h5>Category Access</h5>
                @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" name="scopes[category][]" 
                               value="{{ $category->id }}"
                               id="category_{{ $category->id }}"
                               {{ $role->hasScope('category', $category->id) ? 'checked' : '' }}>
                        <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Solution Scopes -->
            <div class="col-md-3">
                <h5>Solution Access</h5>
                @foreach($solutions as $solution)
                    <div class="form-check">
                        <input type="checkbox" name="scopes[solution][]" 
                               value="{{ $solution->id }}"
                               id="solution_{{ $solution->id }}"
                               {{ $role->hasScope('solution', $solution->id) ? 'checked' : '' }}>
                        <label for="solution_{{ $solution->id }}">{{ $solution->name }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Country Scopes -->
            <div class="col-md-3">
                <h5>Country Access</h5>
                @foreach($countries as $country)
                    <div class="form-check">
                        <input type="checkbox" name="scopes[country][]" 
                               value="{{ $country->id }}"
                               id="country_{{ $country->id }}"
                               {{ $role->hasScope('country', $country->id) ? 'checked' : '' }}>
                        <label for="country_{{ $country->id }}">{{ $country->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Scopes</button>
    </form>
</div>
@endsection