@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

<section class="d-flex align-items-center justify-content-center" 
         style="min-height: 100vh; background: linear-gradient(135deg, #e3f2fd, #bbdefb);">

    <div class="p-4 border-0 shadow-lg card rounded-4" style="max-width: 450px; width: 100%; background: #fff;">

        <!-- Title -->
        <h3 class="mb-2 text-center fw-bold">Principal Register</h3>
        <p class="mb-4 text-center text-muted">
            Create your account to get started
        </p>

        <!-- Register Form -->
        <form method="POST" action="{{ route('principal.register.submit') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Principal Name</label>
                <input type="text" name="name" class="form-control form-control-lg" 
                       value="{{ old('name') }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control form-control-lg"
                       value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3">
                Register
            </button>
        </form>

        <!-- Links -->
        <div class="mt-4 text-center">
            <p class="text-muted">
                Already have an account?
                <a href="{{ route('principal.login') }}" 
                   class="fw-semibold text-primary text-decoration-underline">
                    Login here
                </a>
            </p>
        </div>

    </div>

</section>

@endsection


{{-- SWEETALERT FOR VALIDATION ERRORS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            html: `
                <div class="text-start">
                    <p>Please fix the following errors:</p>
                    <ul class="mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            `,
        });
    @endif
});
</script>
@endpush
