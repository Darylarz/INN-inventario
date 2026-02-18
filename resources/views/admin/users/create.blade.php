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
          Nombre *
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
          Email *
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
          Rol *
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
    Contraseña *
  </label>

  <div class="relative">
    <input
      type="password"
      id="password"
      name="password"
      required
      minlength="8"
      class="w-full rounded border-gray-300 dark:border-gray-600
             dark:bg-gray-700 dark:text-white pr-10
             focus:ring-blue-500 focus:border-blue-500"
    >

    {{-- Botón ojo --}}
    <button
      type="button"
      onclick="togglePassword()"
      class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500"
    >
      {{-- Ojo abierto --}}
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                          c4.477 0 8.268 2.943 9.542 7
                          -1.274 4.057-5.065 7-9.542 7
                          -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>


                    {{-- Ojo tachado --}}
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 hidden"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
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

  @error('password')
    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
  @enderror
</div class="mb-5">

      {{-- Confirmar contraseña --}}
      <label for="password_confirmation" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">
          Confirmar contraseña *
        </label>
      <div class="relative">
        
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          required
          class="w-full rounded border-gray-300 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
        >
            {{-- Botón ojo --}}
              <button
                type="button"
                onclick="togglePassword2()"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500"
              >
                                    {{-- Ojo abierto --}}
                    <svg id="eye-open2" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                          c4.477 0 8.268 2.943 9.542 7
                          -1.274 4.057-5.065 7-9.542 7
                          -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>


                    {{-- Ojo tachado --}}
                    <svg id="eye-closed2" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 hidden"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
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

function togglePassword2() {
    const input = document.getElementById('password_confirmation');
    const eyeOpen2 = document.getElementById('eye-open2');
    const eyeClosed2 = document.getElementById('eye-closed2');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen2.classList.add('hidden');
        eyeClosed2.classList.remove('hidden'); 
    } else {
        input.type = 'password';
        eyeOpen2.classList.remove('hidden');
        eyeClosed2.classList.add('hidden');
    }
}
</script>