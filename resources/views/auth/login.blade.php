@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-cover bg-center"
     style="background-image: url('{{ asset('images/login-fondo.jpg') }}');">
     
    <div class="max-w-md w-full bg-white/90 dark:bg-gray-800/90 rounded-lg shadow-md p-6 backdrop-blur-sm">
        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-900 dark:text-white">
            Iniciar sesión
        </h2>

        @if(session('error'))
            <div class="text-sm text-red-600 mb-4 px-3 py-2 bg-red-50 dark:bg-red-900/30 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Contraseña</label>
                <div class="relative">
                    <input name="password" id="password" type="password" required
                           class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                    @error('password')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror

                    {{-- Botón ojo --}}
                    <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                                     c4.477 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.065 7-9.542 7
                                     -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19
                                     c-4.478 0-8.268-2.943-9.542-7
                                     a9.956 9.956 0 012.223-3.592M6.42 6.42
                                     A9.953 9.953 0 0112 5
                                     c4.477 0 8.268 2.943 9.542 7
                                     a9.97 9.97 0 01-4.293 5.433M15 12
                                     a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>
@endsection
