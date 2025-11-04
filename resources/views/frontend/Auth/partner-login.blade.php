@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<style>
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .animate__fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<section class="py-5 d-flex align-items-center min-vh-100" style="background: linear-gradient(135deg, #f7f8fa, #e9ecef);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="p-4 bg-white shadow-lg rounded-3 p-lg-5 animate__animated animate__fadeIn">
                    <!-- Title -->
                    <h3 class="mb-1 text-center fw-bold" style="color: var(--primary-color); font-family: 'Poppins', sans-serif;">
                        Partner Login
                    </h3>
                    <hr class="mx-auto mt-2 mb-3" style="width: 60px; border-top: 3px solid var(--primary-color);">
                    <p class="mb-4 text-center text-muted">
                        Welcome back! Please log in to access your partner dashboard.
                    </p>

                    <!-- Error Message -->
                    @if (session('error'))
                    <div class="text-center alert alert-danger rounded-3">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('partner.login.submit') }}" method="POST" class="login-validation needs-validation" novalidate>
                        @csrf

                        <input type="hidden" name="redirect_to" value="{{ request()->query('redirect_to') }}">
                        <input type="hidden" name="product_id" value="{{ request()->query('product_id') }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control form-control-lg rounded-2" id="email"
                                placeholder="Enter your email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control form-control-lg rounded-2" id="password"
                                placeholder="Enter your password" name="password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>

                        <!-- Links -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--primary-color);">
                                Forgot Password?
                            </a>
                            @endif
                            <span class="small">
                                New here?
                                <a href="{{ route('register') }}" class="fw-semibold" style="color: var(--primary-color);">
                                    Sign up as Client
                                </a>
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="text-white btn btn-lg rounded-2"
                                style="background-color: var(--primary-color); transition: 0.3s;">
                                Login as Partner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function() {
        "use strict";
        var forms = document.querySelectorAll(".login-validation");
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener("submit", function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            }, false);
        });
    })();
</script>
@endpush