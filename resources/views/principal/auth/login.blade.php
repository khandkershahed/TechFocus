@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <h2 class="text-center text-2xl font-bold mb-4">Principal Login</h2>

    <form method="POST" action="{{ route('principal.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" required class="w-full border p-2">
        </div>

        <div class="mb-3">
            <input type="checkbox" name="remember"> Remember Me
        </div>

        <button type="submit" class="btn btn-primary w-full">Login</button>
    </form>

    <p class="mt-4 text-center">
        Don't have an account? 
        <a href="{{ route('principal.register') }}" class="text-blue-500 underline">Register here</a>
    </p>

@endsection