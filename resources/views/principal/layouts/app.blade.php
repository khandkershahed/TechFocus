<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Dashboard - TechFocus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-store text-2xl text-blue-600 mr-3"></i>
                    <span class="text-xl font-bold text-gray-800">TechFocus Principal</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ auth('principal')->user()->name }}</span>
                    <form method="POST" action="{{ route('principal.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('principal.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ Route::current()->getName() == 'principal.dashboard' ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                        <i class="fa-solid fa-gauge-high mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    {{-- <a href="{{ route('principal.brands.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ in_array(Route::current()->getName(), ['principal.brands.index', 'principal.brands.create', 'principal.brands.edit']) ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                        <i class="fa-solid fa-store mr-3"></i>
                        <span>My Brands</span>
                    </a> --}}
                </div>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <i class="fa-solid fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <i class="fa-solid fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>