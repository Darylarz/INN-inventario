{{-- 1. Extiende el Layout principal que ya tiene Vite y Alpine.js cargados --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900">
        
        <header class="text-center mb-10">
            <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white">
                ¡Bienvenido a <span class="text-indigo-600">INN-Inventario</span>!
            </h1>
            <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                Tu aplicación Laravel potenciada por **Blade** y **Alpine.js**.
            </p>
        </header>

        {{-- 2. Componente interactivo con Alpine.js --}}
        <div 
            class="p-6 max-w-sm mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg space-y-4"
            x-data="{ isOpen: false, message: '¡Hiciste clic!' }"
        >
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Ejemplo de Alpine
                </h2>
                
                {{-- Botón que usa Alpine para cambiar el estado --}}
                <button 
                    @click="isOpen = !isOpen" 
                    class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition"
                >
                    <span x-text="isOpen ? 'Ocultar Mensaje' : 'Mostrar Mensaje'"></span>
                </button>
            </div>

            {{-- 3. Elemento que se muestra/oculta basado en el estado 'isOpen' --}}
            <div x-show="isOpen" x-transition.duration.70ms>
                <p class="text-indigo-500 font-bold" x-text="message"></p>
                
                {{-- Ejemplo de input en tiempo real (x-model) --}}
                <input 
                    type="text" 
                    x-model="message" 
                    placeholder="Cambia el mensaje aquí..." 
                    class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
            </div>
        </div>

        {{-- ... otros contenidos de la página, como el componente Alpine ... --}}

        {{-- BOTONES DE INICIO DE SESIÓN Y REGISTRO (Siempre visibles) --}}
        <div class="mt-10 space-x-4">
            
            {{-- Botón de Iniciar Sesión (Login) --}}
            <a 
                href="{{ route('login') }}" 
                class="text-lg text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg transition duration-150 shadow-md"
            >
                Iniciar Sesión
            </a>

            {{-- El check Route::has('register') es una buena práctica para asegurar que la ruta exista --}}
            @if (Route::has('register'))
                {{-- Botón de Registro --}}
                <a 
                    href="{{ route('register') }}" 
                    class="text-lg text-indigo-600 border-2 border-indigo-600 hover:bg-indigo-100 px-6 py-3 rounded-lg transition duration-150"
                >
                    Registrarse
                </a>
            @endif
        </div>

    </div>
    {{-- ... Cierre del @endsection y el div principal ... --}}
        </div>

    </div>
@endsection