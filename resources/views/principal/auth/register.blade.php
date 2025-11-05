@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <h2 class="text-center text-2xl font-bold mb-4">Principal Register</h2>

    <form method="POST" action="{{ route('principal.register.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Principal Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border p-2">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" required class="w-full border p-2">
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border p-2">
        </div>

        <button type="submit" class="btn btn-primary w-full">Register</button>
    </form>

    <p class="mt-4 text-center">
        Already have an account? 
        <a href="{{ route('principal.login') }}" class="text-blue-500 underline">Login here</a>
    </p>
@endsection
