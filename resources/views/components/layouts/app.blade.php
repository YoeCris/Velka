<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema Jatucachi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                                <!-- Espacio para logo/imagen -->
                                @if(file_exists(public_path('images/logos/Logo.png')))
                                    <img src="{{ asset('images/logos/Logo.png') }}" alt="Logo Jatucachi" class="h-10 w-30 object-contain">
                                @else
                                    <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-xl font-bold text-gray-800">Sistema Jatucachi</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('comuneros.index')" :active="request()->routeIs('comuneros.*')">
                                Padrón
                            </x-nav-link>
                            @if(auth()->user()->isSuperadmin())
                                <x-nav-link :href="route('reuniones.index')" :active="request()->routeIs('reuniones.*')">
                                    Reuniones
                                </x-nav-link>
                            @endif
                            <x-nav-link :href="route('reportes.padron')" :active="request()->routeIs('reportes.*')">
                                Reportes
                            </x-nav-link>
                            @if(auth()->user()->isSuperadmin())
                                <x-nav-link :href="route('condicion-masiva')" :active="request()->routeIs('condicion-masiva')">
                                    Condición Masiva
                                </x-nav-link>
                            @endif
                            <x-nav-link :href="route('profile')" :active="request()->routeIs('profile')">
                                Perfil
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-200">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('comuneros.index') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('comuneros.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                        Padrón
                    </a>
                    @if(auth()->user()->isSuperadmin())
                        <a href="{{ route('reuniones.index') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('reuniones.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                            Reuniones
                        </a>
                    @endif
                    <a href="{{ route('reportes.padron') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('reportes.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                        Reportes
                    </a>
                    @if(auth()->user()->isSuperadmin())
                        <a href="{{ route('condicion-masiva') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('condicion-masiva') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                            Condición Masiva
                        </a>
                    @endif
                    <a href="{{ route('profile') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('profile') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-lg font-medium">
                        Perfil
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @if (session('message'))
                <div class="px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        // Cerrar mobile menu al hacer clic fuera
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.querySelector('[onclick="toggleMobileMenu()"]');
            
            if (!mobileMenu.classList.contains('hidden') && 
                !mobileMenu.contains(event.target) && 
                !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>

    @livewireScripts
</body>
</html>