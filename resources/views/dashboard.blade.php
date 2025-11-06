@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        
        {{-- Menú Lateral (Sidebar) --}}
        <div class="flex flex-col w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-6 text-2xl font-bold text-indigo-600 dark:text-indigo-400 border-b dark:border-gray-700">
                Inventario INN
            </div>
            
            <nav class="flex-grow p-4 space-y-2">
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition duration-150 bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-7-7-7 7m14 0v10a1 1 0 001 1h3m-10 11V10a1 1 0 00-1-1h-2a1 1 0 00-1 1v11m-1-11v11a1 1 0 001 1h2a1 1 0 001-1v-11z"></path></svg>
                    Dashboard
                </a>

                {{-- Enlace que crearemos para la tabla de artículos --}}
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h2m0 0a2 2 0 012-2h2a2 2 0 012 2M7 7h10"></path></svg>
                    Artículos (Inventario)
                </a>
                
                {{-- Ejemplo de enlace condicional usando el permiso que definimos antes --}}
                @can('gestion usuarios')
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2a3 3 0 00-5.356-1.857M10 11V9m0 0v2m0 0H8m2 0h2"></path></svg>
                        Gestión de Usuarios
                    </a>
                @endcan

            </nav>
            
            <div class="p-4 border-t dark:border-gray-700">
                 {{-- Botón de Logout (usa el formulario POST estándar de Laravel) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>

        </div>

        {{-- Contenido Principal (Main Content) --}}
        <div class="flex-grow p-10 overflow-y-auto">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Panel Principal</h2>

            {{-- Aquí es donde irá tu tabla de inventario dinámica --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl">
                <p class="text-gray-600 dark:text-gray-400">
                    Hola, **{{ Auth::user()->name }}**!
                </p>
                <p class="mt-4 text-gray-700 dark:text-gray-300 font-medium">
                    ¡Listo para empezar con la tabla de inventario!
                </p>
            </div>
        </div>
    </div>
@endsection