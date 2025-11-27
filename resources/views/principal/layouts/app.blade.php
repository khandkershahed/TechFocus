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

                    {{-- <!-- User + Welcome -->
                    <div
                        id="userMenuBtn"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span class="font-semibold text-gray-700 uppercase">
                            Welcome, {{ auth('principal')->user()->legal_name }}
                        </span>
                        <i class="text-3xl text-gray-600 fa-solid fa-user-circle"></i>
                    </div> --}}
                    <!-- User + Welcome with Dropdown -->
<div class="relative" x-data="{ open: false }">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 cursor-pointer focus:outline-none"
        id="userMenuBtn">
        <span class="font-semibold text-gray-700 uppercase">
            Welcome, {{ auth('principal')->user()->legal_name }}
        </span>
        <i class="text-3xl text-gray-600 fa-solid fa-user-circle"></i>
    </button>

    <!-- Dropdown Menu -->
    <div 
        x-show="open" 
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 z-50 w-56 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg top-full">
        
        <!-- User Info -->
        <div class="p-3 border-b border-gray-100">
            <p class="text-sm font-medium text-gray-900 truncate">{{ auth('principal')->user()->legal_name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ auth('principal')->user()->email ?? 'No email' }}</p>
        </div>

        <!-- Settings Options -->
        <div class="p-1">
            <a href="{{ route('principal.profile.edit') }}"
               class="flex items-center px-3 py-2 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-100">
                <i class="w-5 mr-2 text-gray-500 fa-solid fa-user-edit"></i>
                Edit Profile
            </a>

            <!-- Check if route exists before using it -->
            @if(Route::has('principal.settings'))
                <a href="{{ route('principal.settings') }}"
                   class="flex items-center px-3 py-2 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-100">
                    <i class="w-5 mr-2 text-gray-500 fa-solid fa-cog"></i>
                    Settings
                </a>
            @else
                <a href="#"
                   class="flex items-center px-3 py-2 text-sm text-gray-500 transition-colors rounded-lg hover:bg-gray-100 opacity-75 cursor-not-allowed">
                    <i class="w-5 mr-2 fa-solid fa-cog"></i>
                    Settings
                </a>
            @endif

            @if(Route::has('principal.security'))
                <a href="{{ route('principal.security') }}"
                   class="flex items-center px-3 py-2 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-100">
                    <i class="w-5 mr-2 text-gray-500 fa-solid fa-shield-alt"></i>
                    Security
                </a>
            @else
                <a href="#"
                   class="flex items-center px-3 py-2 text-sm text-gray-500 transition-colors rounded-lg hover:bg-gray-100 opacity-75 cursor-not-allowed">
                    <i class="w-5 mr-2 fa-solid fa-shield-alt"></i>
                    Security
                </a>
            @endif

            @if(Route::has('principal.notifications'))
                <a href="{{ route('principal.notifications') }}"
                   class="flex items-center px-3 py-2 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-100">
                    <i class="w-5 mr-2 text-gray-500 fa-solid fa-bell"></i>
                    Notifications
                </a>
            @else
                <a href="#"
                   class="flex items-center px-3 py-2 text-sm text-gray-500 transition-colors rounded-lg hover:bg-gray-100 opacity-75 cursor-not-allowed">
                    <i class="w-5 mr-2 fa-solid fa-bell"></i>
                    Notifications
                </a>
            @endif
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100"></div>

        <!-- Logout -->
        <div class="p-1">
            <form method="POST" action="{{ route('principal.logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center w-full px-3 py-2 text-sm text-red-600 transition-colors rounded-lg hover:bg-red-50">
                    <i class="w-5 mr-2 fa-solid fa-right-from-bracket"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
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