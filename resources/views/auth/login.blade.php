@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-semibold mb-4 text-center text-gray-900 dark:text-white">Iniciar sesión</h2>

  @if(session('error'))
    <div class="text-sm text-red-600 mb-4">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ url('/login') }}" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
      <input name="email" type="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Contraseña</label>
      <input name="password" type="password" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('password') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Entrar</button>
    </div>
  </form>

  <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
    ¿No tienes cuenta?
    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Regístrate</a>
  </p>
</div>
@endsection