@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    
    {{-- Logo o Título (Componente Blade opcional) --}}
    <div>
        <a href="/">
            {{-- Asumiendo que tienes un componente Blade para el logo --}}
            {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            <h1 class="text-3xl font-bold text-indigo-600">INN-Inventario</h1>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

        {{-- Formulario con Lógica de Alpine/Axios --}}
        <form 
            method="POST" 
            action="{{ route('login') }}" 
            x-data="{ 
                form: { email: '', password: '', remember: false },
                errors: {},
                isProcessing: false,
                
                async submit() {
                    this.isProcessing = true;
                    this.errors = {};
                    
                    try {
                        // 1. Petición POST a la ruta de login
                        const response = await axios.post('{{ route('login') }}', this.form);

                        // 2. Si es exitoso, redirigir al dashboard (o ruta destino)
                        window.location.href = '{{ url('/dashboard') }}';
                        
                    } catch (error) {
                        // 3. Manejo de errores de validación de Laravel (código 422)
                        if (error.response && error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            // Manejar otros errores
                            alert('Error de conexión o servidor.');
                            console.error('Error de Login:', error);
                        }
                    } finally {
                        this.isProcessing = false;
                    }
                }
            }" 
            @submit.prevent="submit" {{-- Llama a la función submit de Alpine --}}
        >
            @csrf

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    x-model="form.email" 
                    required 
                    autofocus
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                {{-- Muestra el error de validación --}}
                <span x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-sm text-red-600 dark:text-red-400 mt-2"></span>
            </div>

            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contraseña</label>
                <input 
                    id="password" 
                    type="password" 
                    x-model="form.password" 
                    required 
                    autocomplete="current-password"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                 {{-- Muestra el error de validación --}}
                <span x-show="errors.password" x-text="errors.password ? errors.password[0] : ''" class="text-sm text-red-600 dark:text-red-400 mt-2"></span>
            </div>

            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input id="remember" type="checkbox" x-model="form.remember" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recuérdame</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <button 
                    type="submit" 
                    :disabled="isProcessing"
                    class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 disabled:opacity-50"
                >
                    <span x-show="!isProcessing">Iniciar Sesión</span>
                    <span x-show="isProcessing">Cargando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection