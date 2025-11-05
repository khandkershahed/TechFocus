@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-2" style="color: var(--main-color)">Create Your Account</h2>
                        <p class="text-muted mb-0">Join Tech Focus to explore more opportunities.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="signup_validation needs-validation" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control rounded-3"
                                    placeholder="John Doe"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="form-control rounded-3"
                                    placeholder="example@email.com"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" id="phone" name="phone_number"
                                    class="form-control rounded-3"
                                    placeholder="Enter your number"
                                    value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-semibold">Company Name</label>
                                <input type="text" id="company_name" name="company"
                                    class="form-control rounded-3"
                                    placeholder="Your company (optional)"
                                    value="{{ old('company') }}">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="user_type" class="form-label fw-semibold">Register As</label>
                                <select id="user_type" name="user_type"
                                    class="form-select  rounded-3" required>
                                    <option value="">-- Select User Type --</option>
                                    <option value="client" {{ old('user_type') == 'client' ? 'selected' : '' }}>Client</option>
                                    <option value="partner" {{ old('user_type') == 'partner' ? 'selected' : '' }}>Partner</option>
                                </select>
                                @error('user_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control rounded-3"
                                    placeholder="••••••••" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control rounded-3"
                                    placeholder="••••••••" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 d-flex align-items-center mt-2">
                                <input type="checkbox" id="terms_check" name="check_terms" class="form-check-input me-2" checked required>
                                <label for="terms_check" class="form-check-label small">
                                    I agree to the <a href="#" class="text-decoration-none" style="color: var(--main-color)">Terms & Conditions</a>.
                                </label>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn w-100 py-3 fw-bold text-white rounded-3"
                                    style="background-color: var(--primary-color); transition: 0.3s;">
                                    Sign Up
                                </button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <p class="text-muted mb-0">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="fw-semibold" style="color: var(--main-color)">
                                        Login now
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Optional bottom gradient bar -->
                <div class="bg-gradient" style="height: 5px; background: linear-gradient(90deg, var(--main-color), #ff7e5f)"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $(".needs-validation").on("submit", function(event) {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.addClass("was-validated");
    });

    // Password match validation
    $("#password, #password_confirmation").on("keyup change", function() {
        var password = $("#password").val();
        var confirmPassword = $("#password_confirmation").val();

        if (password !== confirmPassword) {
            $("#password_confirmation")[0].setCustomValidity("Passwords do not match");
        } else {
            $("#password_confirmation")[0].setCustomValidity("");
        }
    });
});
</script>
@endpush
