@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Crear Cuenta</h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Campo Nombre --}}
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nombre</label>
                    <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Email --}}
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @error('email')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Contraseña --}}
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contraseña</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Confirmar Contraseña --}}
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        ¿Ya estás registrado?
                    </a>

                    <button class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection