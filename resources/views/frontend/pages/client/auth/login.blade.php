@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-6 offset-lg-3 mb-5">
            <div class="card border-0 rounded-0 p-lg-5 p-3">

                {{-- Dynamic title --}}
                <h3 class="text-center font-poppins fw-bold mb-0">
                    {{ ucfirst($userType) }} Login
                </h3>
                <hr class="w-25 mx-auto mt-1" style="color: var(--main-color);">
                <p class="text-center font-poppins">
                    Welcome back! Please log in to access your dashboard and manage your account.
                </p>

                <div class="row mb-5">
                    <div class="col-lg-8 offset-lg-2">

                        {{-- Show login error --}}
                        @if ($errors->has('login_error'))
                            <div class="alert alert-danger text-center">
                                {{ $errors->first('login_error') }}
                            </div>
                        @endif

                        <form action="{{ $userType === 'partner' ? route('plogin') : route('login') }}" method="POST" class="login-validation" novalidate>
                            @csrf

                            {{-- Hidden user_type field --}}
                            <input type="hidden" name="user_type" value="{{ $userType }}">

                            {{-- Email --}}
                            <div class="mb-3 mt-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control rounded-0" id="email"
                                       placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
                                <div class="valid-feedback">Looks Good.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="pwd" class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control rounded-0" id="pwd"
                                       placeholder="Enter Password" name="password" required>
                                <div class="valid-feedback">Looks Good.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            {{-- Links --}}
                            <div class="row pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if (Route::has('password.request'))
                                            <p>
                                                <a href="{{ route('password.request') }}" class="my-3 main-color fs-7">
                                                    Forgot Your Password?
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="fs-7">
                                            First Time Here? 
                                            <a href="{{ route('register') }}" class="my-3 main-color fw-bold">
                                                Sign Up
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn common-btn-3 rounded-0 w-auto">
                                    Login
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
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
