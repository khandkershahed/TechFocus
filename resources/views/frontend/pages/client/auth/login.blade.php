@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<style>
    .form-control {
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
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

    .alert {
        font-size: 0.9rem;
    }
</style>
<section class="min-vh-100 d-flex align-items-center"
    style="background: linear-gradient(135deg, #f3f4f6 0%, #e0e7ff 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="p-4 bg-white shadow-lg rounded-3 p-lg-5 animate__animated animate__fadeIn">

                    {{-- Dynamic Title --}}
                    <h3 class="mb-1 text-center fw-bold" style="color: var(--primary-color); font-family: 'Poppins', sans-serif;">
                        {{ ucfirst($userType) }} Login
                    </h3>
                    <hr class="mx-auto mt-2 mb-3" style="width: 60px; border-top: 3px solid var(--primary-color);">
                    <p class="mb-4 text-center text-muted">
                        Welcome back! Log in to manage your dashboard and continue your journey.
                    </p>

                    {{-- Login Error --}}
                    @if ($errors->has('login_error'))
                    <div class="text-center alert alert-danger rounded-3">
                        {{ $errors->first('login_error') }}
                    </div>
                    @endif

                    {{-- Login Form --}}
                    <form action="{{ $userType === 'partner' ? route('plogin') : route('login') }}"
                        method="POST" class="login-validation needs-validation" novalidate>
                        @csrf

                        <input type="hidden" name="user_type" value="{{ $userType }}">
                        <input type="hidden" name="redirect_to" value="{{ request()->query('redirect_to') }}">
                        <input type="hidden" name="product_id" value="{{ request()->query('product_id') }}">

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control form-control-lg rounded-2" id="email"
                                placeholder="Enter your email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="pwd" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control form-control-lg rounded-2" id="pwd"
                                placeholder="Enter your password" name="password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>

                        {{-- Links --}}
                        <div class="flex-wrap mb-4 d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="small text-decoration-none"
                                style="color: var(--primary-color);">
                                Forgot Password?
                            </a>
                            @endif
                            <span class="mt-2 small mt-sm-0">
                                New here?
                                <a href="{{ route('register') }}" class="fw-semibold" style="color: var(--primary-color);">
                                    Sign up
                                </a>
                            </span>
                        </div>

                        {{-- Submit --}}
                        {{-- <div class="d-grid">
                            <button type="submit"
                                class="text-white shadow-sm btn btn-lg rounded-2"
                                style="background-color: var(--primary-color); transition: 0.3s;">
                                Login as {{ ucfirst($userType) }}
                            </button>
                        </div> --}}
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