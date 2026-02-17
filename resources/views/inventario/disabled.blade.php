@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
      Artículos desincorporados
    </h2>

    <a href="{{ route('inventario.index') }}"
       class="inline-flex items-center px-4 py-2 rounded bg-gray-200 dark:bg-gray-700
              text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">
      ← Volver al inventario
    </a>
  </div>

  {{-- Mensajes --}}
  @if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-500 text-white">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-4 rounded bg-red-500 text-white">
      {{ session('error') }}
    </div>
  @endif

  {{-- Buscador --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
    <form action="{{ route('inventario.disabled') }}" method="GET"
          class="flex flex-col sm:flex-row gap-3">
      <input
        type="text"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Buscar por marca, modelo, serie, bien nacional…"
        class="flex-1 rounded border-gray-300 dark:border-gray-600
               dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
      >
      <button
        type="submit"
        class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
        Buscar
      </button>

      @if(!empty($search))
        <a href="{{ route('inventario.disabled') }}"
           class="px-4 py-2 rounded border text-gray-700 dark:text-gray-200
                  hover:bg-gray-100 dark:hover:bg-gray-700">
          Limpiar
        </a>
      @endif
    </form>
  </div>

  {{-- Tabla --}}
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Tipo</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Marca</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Modelo</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Serie</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Bien nacional</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Fecha</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Motivo</th>
          @can('usuario crear')
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-200">Acciones</th>
          @endcan
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($inventario as $item)
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-4 py-3 text-gray-800 dark:text-gray-100">
              {{ $item->tipo_item }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
              {{ $item->marca }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
              {{ $item->modelo }}
            </td>
            <td class="px-4 py-3 font-mono text-sm text-gray-700 dark:text-gray-300">
              {{ $item->numero_serial }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
              {{ $item->bien_nacional }}
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">
              {{ optional($item->fecha_desactivado)->format('Y-m-d H:i') }}
            </td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
              {{ $item->razon_desactivado ?? '—' }}
            </td>

            @can('usuario crear')
              <td class="px-4 py-3 text-right">
                <div class="inline-flex items-center gap-3">
                  <form action="{{ route('inventario.enable', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Reincorporar artículo?')">
                    @csrf
                    <button class="text-green-600 hover:underline">
                      Reincorporar
                    </button>
                  </form>

                  <form action="{{ route('inventario.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Desactivar artículo nuevamente?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline">
                      Desactivar
                    </button>
                  </form>
                </div>
              </td>
            @endcan
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
              No hay artículos desincorporados
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación --}}
  <div class="mt-6">
    {{ $inventario->links() }}
  </div>
</div>
@endsection
