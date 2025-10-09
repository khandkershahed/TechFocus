<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ url('/') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent. If you did not receive the email, we can send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
            {{-- Resend Verification Form --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary rounded-0">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            {{-- Logout Form --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-0">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
