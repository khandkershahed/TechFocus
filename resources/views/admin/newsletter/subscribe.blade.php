@extends('admin.master')

@section('metadata')
    <title>Subscribe to Our Newsletter</title>
@endsection

@section('content')

<!-- 📰 Newsletter Subscription Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-3">Subscribe to Our Newsletter</h2>
                        <p class="text-muted mb-4">
                            Stay updated with our latest products, news, and exclusive offers.  
                            We send emails twice a month—no spam, promise!
                        </p>

                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Subscription Form -->
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control form-control-lg text-center @error('email') is-invalid @enderror"
                                       placeholder="Enter your email address" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="country_id" class="form-select form-select-lg text-center @error('country_id') is-invalid @enderror" required>
                                    <option value="">Select your country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill">Subscribe</button>
                        </form>

                        <p class="mt-4 small text-muted">
                            By subscribing, you agree to our 
                            <a href="{{ route('terms') }}" class="text-decoration-none fw-bold main-color">Terms & Policy</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
