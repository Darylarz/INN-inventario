@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Ubicaciones</h1>
    <a href="{{ route('ubicaciones.create') }}" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Nueva ubicación</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('success') }}</div>
  @endif

  <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">ID</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Nombre</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Código</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Descripción</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
        @forelse($ubicaciones as $l)
        <tr>
          <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $l->id }}</td>
          <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $l->nombre }}</td>
          <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $l->codigo ?? '-' }}</td>
          <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $l->descripcion ?? '-' }}</td>
          <td class="px-4 py-2 text-sm">
            <a href="{{ route('ubicaciones.edit', $l) }}" class="inline-block px-2 py-1 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 mr-2">Editar</a>
            <form method="POST" action="{{ route('ubicaciones.deactivate', $l) }}" class="inline-block" onsubmit="return confirm('¿Desactivar ubicación?');">
              @csrf
              <button class="inline-block px-2 py-1 rounded bg-yellow-600 hover:bg-yellow-700 text-white">Desactivar</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-4 py-6 text-sm text-gray-500 dark:text-gray-300 text-center">No hay ubicaciones registradas</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="px-4 py-3">{{ $ubicaciones->links() }}</div>
  </div>
</div>
@endsection
