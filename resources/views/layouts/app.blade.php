<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token CSRF (necesario para todas las peticiones POST/AJAX seguras en Laravel) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INN Inventario') }}</title>

    {{-- Carga de fuentes (opcional) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- 1. Directiva de Vite para cargar el CSS y JS principal (incluye Alpine/Axios) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        {{-- Navigation Bar --}}
        <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    {{-- Logo and Brand --}}
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard') }}" class="flex items-center">
                                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">INN Inventario</span>
                            </a>
                        </div>
                        
                        {{-- Navigation Links --}}
                        <div class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="{{ route('dashboard') }}" 
                               class="{{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('inventory.create') }}" 
                               class="{{ request()->routeIs('inventory.create') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Agregar Ítem
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" 
                               class="{{ request()->routeIs('profile.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Perfil
                            </a>
                        </div>
                    </div>
                    
                    {{-- User Menu --}}
                    <div class="flex items-center">
                        {{-- User Info --}}
                        <div class="hidden md:flex md:items-center md:space-x-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Hola, <span class="font-medium">{{ Auth::user()->name }}</span>
                            </span>
                        </div>
                        
                        {{-- Logout Button --}}
                        <div class="ml-4">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                        
                        {{-- Mobile menu button --}}
                        <div class="md:hidden ml-4">
                            <button type="button" 
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                    onclick="toggleMobileMenu()">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Mobile Menu --}}
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'border-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                            Dashboard
                        </a>
                        <a href="{{ route('inventory.create') }}" 
                           class="{{ request()->routeIs('inventory.create') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'border-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                            Agregar Ítem
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="{{ request()->routeIs('profile.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'border-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                            Perfil
                        </a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 px-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left block px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Contenido principal de la página --}}
        <main class="flex-1">
            {{-- 2. Directiva para inyectar el contenido de las vistas que extienden este layout --}}
            @yield('content')
        </main>
        
        {{-- Mobile Menu Toggle Script --}}
        <script>
            function toggleMobileMenu() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            }
        </script>
    </div>
</body>
</html>