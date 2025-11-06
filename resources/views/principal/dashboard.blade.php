{{-- 
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Welcome Principal, {{ auth('principal')->user()->name }}</h1>

    <form method="POST" action="{{ route('principal.logout') }}">
        @csrf
        <button type="submit" 
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
            Logout
        </button>
    </form>
</div> --}}
@extends('principal.layouts.app')

@section('title', 'Principal Dashboard')

@section('content')
<div class="flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white min-h-screen">
        <div class="p-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold">Principal Panel</h2>
        </div>

        <nav class="mt-4">
            <ul>
                <li class="px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('principal.dashboard') ? 'bg-gray-700' : '' }}">
                    <a href="{{ route('principal.dashboard') }}" class="block">
                        <i class="fa-solid fa-gauge mr-2"></i> Dashboard
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-700 {{ request()->routeIs(['principal.brand.index', 'principal.category.index', 'principal.attribute.index', 'principal.product.index']) ? 'bg-gray-700' : '' }}">
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full text-left flex items-center justify-between">
                            <span><i class="fa-solid fa-truck mr-2"></i> Supply Chain</span>
                            <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid"></i>
                        </button>

                        <ul x-show="open" class="mt-2 ml-6 space-y-2 text-sm">
                            <li><a href="{{ route('principal.brand.index') }}" class="block hover:underline">Brands</a></li>
                            <li><a href="{{ route('principal.category.index') }}" class="block hover:underline">Categories</a></li>
                            <li><a href="{{ route('principal.attribute.index') }}" class="block hover:underline">Attributes</a></li>
                            <li><a href="{{ route('principal.product.index') }}" class="block hover:underline">Products</a></li>
                        </ul>
                    </div>
                </li>

                {{-- Add more menu sections here if needed --}}
            </ul>
        </nav>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">
                Welcome Principal, {{ auth('principal')->user()->name }}
            </h1>

            <form method="POST" action="{{ route('principal.logout') }}">
                @csrf
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                    Logout
                </button>
            </form>
        </div>

        {{-- Example dashboard content --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Dashboard Overview</h2>
            <p class="text-gray-700">You can manage your brands, categories, and products here.</p>
        </div>
    </main>
</div>
@endsection
