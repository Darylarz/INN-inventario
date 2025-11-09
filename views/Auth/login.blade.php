@extends('app') {{-- Extiende tu layout base con Vite y Alpine --}}

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        
        {{-- Aquí puedes poner el logo o título --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Iniciar Sesión</h1>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            
            {{-- Muestra el mensaje de estado de la sesión, si existe (ej. después de un registro) --}}
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Formulario de Login --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Campo Email --}}
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Contraseña con Alpine.js para alternar visibilidad --}}
                <div class="mt-4" x-data="{ show: false }">
                    <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contraseña</label>
                    
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" class="block mt-1 w-full" name="password" required autocomplete="current-password" />
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <svg x-show="!show" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.875A10.024 10.024 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.706 0 3.336.52 4.708 1.442M19.942 16.058l-1.442-1.442M12 9a3 3 0 00-3 3c0 .873.344 1.66.899 2.251m3.101-3.101A3 3 0 0012 15a3 3 0 002.101-.899M21 21L3 3" />
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Opciones de Recordar y Olvidó Contraseña --}}
                <div class="block mt-4 flex justify-between items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                    </label>

                    @if ($canResetPassword)
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            ¿Olvidó su contraseña?
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection