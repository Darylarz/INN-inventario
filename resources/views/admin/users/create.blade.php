@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
  <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Crear Usuario
  </h1>

  {{-- Mensajes --}}
  @if(session('status'))
    <div class="mb-4 p-4 rounded bg-green-500 text-white">
      {{ session('status') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-4 rounded bg-red-500 text-white">
      {{ session('error') }}
    </div>
  @endif

  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf

      {{-- Nombre --}}
      <div class="mb-5">
        <label for="name" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Nombre
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          required
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
        @error('name')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Email --}}
      <div class="mb-5">
        <label for="email" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Email
        </label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          required
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
        @error('email')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Rol --}}
      <div class="mb-5">
        <label for="role" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Rol
        </label>
        <select
          id="role"
          name="role"
          required
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
          <option value="">Seleccionar rol</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
          @endforeach
        </select>
        @error('role')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Contraseña --}}
      <div class="mb-5">
        <label for="password" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Contraseña
        </label>
        <input
          type="password"
          id="password"
          name="password"
          required
          minlength="8"
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
        @error('password')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror

        <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
          <strong>Requisitos:</strong>
          <ul class="list-disc ml-4 mt-1">
            <li>Mínimo 8 caracteres</li>
            <li>Una mayúscula</li>
            <li>Una minúscula</li>
            <li>Un número</li>
            <li>Un carácter especial (@ $ ! % * ? &)</li>
          </ul>
        </div>
      </div>

      {{-- Confirmar contraseña --}}
      <div class="mb-6">
        <label for="password_confirmation" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Confirmar contraseña
        </label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          required
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
      </div>

      {{-- Botones --}}
      <div class="flex justify-end gap-3">
        <a
          href="{{ route('admin.users') }}"
          class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700
                 text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600"
        >
          Cancelar
        </a>
        <button
          type="submit"
          class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
        >
          Crear usuario
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
