@extends('frontend.master')

@section('metadata')
    <title>Verify Your Email | Principal</title>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 px-4">
    <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-md w-full text-center transform transition duration-500 hover:scale-105">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-blue-100 p-5 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12l-4-4m0 0l-4 4m4-4v12" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-extrabold mb-3 text-gray-800">Verify Your Email</h2>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            We've sent a verification link to your email address. Click the link in your inbox to activate your account.
        </p>

        <!-- Show email if available -->
        @if(session('principal_email') || auth('principal')->user())
            <div class="mb-6 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg font-medium">
                Verification email sent to: 
                <span class="font-semibold">{{ session('principal_email') ?? auth('principal')->user()->email }}</span>
            </div>
        @endif

        <!-- Flash messages -->
        @foreach (['success' => 'green', 'message' => 'blue', 'error' => 'red'] as $msg => $color)
            @if(session($msg))
                <div class="mb-4 px-4 py-3 bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-700 rounded-lg text-left">
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach

        <!-- Resend Verification Form -->
        <form method="POST" action="{{ route('principal.verification.send') }}" class="mb-4">
            @csrf
            @if(session('principal_email'))
                <input type="hidden" name="email" value="{{ session('principal_email') }}">
            @endif
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 transform hover:scale-105">
                Resend Verification Email
            </button>
        </form>

        <!-- Login link -->
        <p class="mt-6 text-gray-500 text-sm">
            Already verified? 
            <a href="{{ route('principal.login') }}" class="text-blue-600 font-semibold underline hover:text-blue-700 transition duration-150">
                Login here
            </a>
        </p>

        <!-- Optional footer -->
        <p class="mt-4 text-gray-400 text-xs">
            Didn’t receive the email? Check your spam folder or try resending.
        </p>
    </div>
</div>
@endsection

{{-- SweetAlert Script --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 5000,
            showConfirmButton: false,
            timerProgressBar: true,
            position: 'top-end',
            toast: true,
        });
    @endif

    @if(session('message'))
        Swal.fire({
            icon: 'info',
            title: 'Notice',
            text: '{{ session('message') }}',
            timer: 4000,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
        });
    @endif
});
</script>
@endpush
