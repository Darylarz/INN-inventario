@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
      Usuarios
    </h1>

    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
      + Crear usuario
    </a>
  </div>

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

  {{-- Buscador --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
      <input
        type="text"
        name="search"
        value="{{ $search }}"
        placeholder="Buscar por nombre o email…"
        class="flex-1 rounded border-gray-300 dark:border-gray-600
               dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
      >
      <button
        type="submit"
        class="px-4 py-2 rounded bg-gray-700 text-white hover:bg-gray-800"
      >
        Buscar
      </button>
    </form>
  </div>

  {{-- Tabla --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
            Nombre
          </th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
            Email
          </th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
            Rol
          </th>
          <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-200">
            Acciones
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($users as $user)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-4 py-3 text-gray-800 dark:text-gray-100">
              {{ $user->name }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
              {{ $user->email }}
            </td>
            <td class="px-4 py-3">
              <span class="inline-block px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-indigo-200">
                {{ $user->roles->first()?->name ?? '—' }}
              </span>
            </td>
            <td class="px-4 py-3 text-right">
              <div class="inline-flex items-center gap-3">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="text-blue-600 hover:underline">
                  Editar
                </a>

                <form method="POST"
                      action="{{ route('admin.users.destroy', $user->id) }}"
                      onsubmit="return confirm('¿Eliminar usuario?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">
                    Eliminar
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
              No hay usuarios registrados
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación --}}
  <div class="mt-6">
    {{ $users->links() }}
  </div>
</div>
@endsection
