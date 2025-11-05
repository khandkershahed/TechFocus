@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
        <div class="bg-white shadow-xl rounded-2xl p-10 max-w-lg w-full text-center transform transition duration-300 hover:scale-105">
            
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-blue-500 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12l-4-4m0 0l-4 4m4-4v12" />
                </svg>
            </div>

            <!-- Title -->
            <h2 class="text-3xl font-extrabold mb-3 text-gray-800">Verify Your Email</h2>

            <!-- Description -->
            <p class="text-gray-600 mb-6">
                We have sent a verification link to your email address. Please check your inbox and click the link to activate your account.
            </p>

            <!-- Flash messages -->
            @if(session('message'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-left">
                    {{ session('message') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-lg text-left">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Resend form -->
            <form method="POST" action="{{ route('principal.verification.send') }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-200">
                    Resend Verification Email
                </button>
            </form>

            {{-- <!-- Optional dashboard link -->
            <p class="mt-6 text-gray-500 text-sm">
                Already verified? 
                <a href="{{ route('principal.dashboard') }}" class="text-blue-500 font-semibold underline hover:text-blue-600 transition duration-150">
                    Go to Dashboard
                </a>
            </p> --}}
        </div>
    </div>
@endsection
