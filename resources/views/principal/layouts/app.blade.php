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
        <div class="px-4 mx-auto ">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <i class="mr-3 text-2xl text-blue-600 fa-solid fa-store"></i>
                    <span class="text-xl font-bold text-gray-800">TechFocus Principal</span>
                </div>
                <div class="relative flex items-center space-x-4">

                    <!-- User + Welcome -->
                    <div
                        id="userMenuBtn"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span class="font-semibold text-gray-700 uppercase">
                            Welcome, {{ auth('principal')->user()->legal_name }}
                        </span>
                        <i class="text-3xl text-gray-600 fa-solid fa-user-circle"></i>
                    </div>

                    <!-- Dropdown -->
                    <div
                        id="userDropdown"
                        class="absolute right-0 hidden w-40 py-2 bg-white border border-gray-200 rounded-lg shadow-lg top-12">
                        <form method="POST" action="{{ route('principal.logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="mr-2 fa-solid fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 min-h-screen bg-white shadow-lg">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('principal.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ Route::current()->getName() == 'principal.dashboard' ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                        <i class="mr-3 fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                    {{-- <a href="{{ route('principal.brands.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ in_array(Route::current()->getName(), ['principal.brands.index', 'principal.brands.create', 'principal.brands.edit']) ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="mr-3 fa-solid fa-store"></i>
                    <span>My Brands</span>
                    </a> --}}
                </div>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6">
            @if(session('success'))
            <div class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded">
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
                <div class="flex items-center">
                    <i class="mr-2 fa-solid fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>

</html>