@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Ubicaciones</h1>
    <a href="{{ route('ubicaciones.create') }}" 
    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700">Nueva ubicación</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('success') }}</div>
  @endif

  <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-lime-200 dark:bg-lime-700">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">ID</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Nombre</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Código</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Descripción</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Activo</th>
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
          <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $l->is_active ?  'Si' : 'No' }}</td>
          <td class="px-4 py-2 text-sm">
            <a href="{{ route('ubicaciones.edit', $l) }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700">Editar</a>
            <form method="POST" action="{{ route('ubicaciones.deactivate', $l) }}" class="inline-block" onsubmit="return confirm('¿Desactivar ubicación?');">
              @csrf
              <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600"
               style="color: white !important;">Desactivar</button>
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
