@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
    <h2 class="text-center text-2xl font-bold mb-4">Principal Login</h2>

    <form method="POST" action="{{ route('principal.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-3">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" name="password" required 
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-gray-600">Remember Me</span>
            </label>
        </div>

    <button type="submit" 
    class="btn btn-primary w-full">
    Login
</button>

    </form>

    <div class="mt-6 text-center space-y-2">
        <p class="text-gray-600">
            Don't have an account? 
            <a href="{{ route('principal.register') }}" class="text-blue-600 hover:text-blue-700 font-semibold underline">
                Register here
            </a>
        </p>
        
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// SweetAlert for login responses
document.addEventListener('DOMContentLoaded', function() {
    @if(session('swal'))
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] }}',
            timer: {{ session('swal')['timer'] ?? 4000 }},
            showConfirmButton: {{ isset(session('swal')['timer']) ? 'false' : 'true' }},
            timerProgressBar: true,
        });
    @endif
});
</script>
@endpush