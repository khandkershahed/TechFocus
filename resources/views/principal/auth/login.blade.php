@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

<!-- Full Page Section -->
<section class="d-flex align-items-center justify-content-center" 
         style="min-height: 100vh; background: linear-gradient(135deg, #e3f2fd, #bbdefb);">

    <div class="p-4 border-0 shadow-lg card rounded-4" style="max-width: 420px; width: 100%; background: #fff;">
        
        <!-- Title -->
        <h3 class="mb-2 text-center fw-bold">Principal Login</h3>
        <p class="mb-4 text-center text-muted">Access your account securely</p>

        <form method="POST" action="{{ route('principal.login.submit') }}">
            @csrf

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

            <!-- Remember -->
            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" name="remember" 
                       {{ old('remember') ? 'checked' : '' }} id="rememberMe">
                <label class="form-check-label" for="rememberMe">
                    Remember Me
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3">
                Login
            </button>
        </form>

        <!-- Links -->
        <div class="mt-4 text-center">
            <p class="text-muted">
                Don't have an account?
                <a href="{{ route('principal.register') }}" class="fw-semibold text-primary text-decoration-underline">
                    Register here
                </a>
            </p>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('swal'))
        let swalData = @json(session('swal'));
        Swal.fire({
            icon: swalData.icon || 'info',
            title: swalData.title || '',
            text: swalData.text || '',
            @if(isset($swal['timer']) || isset($swal['autoClose']) && $swal['autoClose'] === true)
                timer: swalData.timer || 4000,
                showConfirmButton: false,
                timerProgressBar: true,
            @else
                showConfirmButton: true,
            @endif
        });
    @endif
});
</script>
@endpush
