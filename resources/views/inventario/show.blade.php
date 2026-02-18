@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-start justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Detalle del artículo</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">ID: {{ $inventario->id }} — {{ $inventario->marca }} {{ $inventario->modelo }}</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('inventario.entrada.create', $inventario) }}" class="inline-flex items-center px-3 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">Entrada</a>
      <a href="{{ route('inventario.salida.create', $inventario) }}" class="inline-flex items-center px-3 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Salida</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Stock actual</div>
      <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->cantidad ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Tipo</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->tipo_item ?? '-' }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Serial</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->numero_serial ?? '-' }}</div>
    </div>

<div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Bien Nacional</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->bien_nacional ?? '-' }}</div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Marca</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->marca ?? '-' }}</div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Capacidad</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->capacidad ?? '-' }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Generación</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->generacion ?? '-' }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Reciclado</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->reciclado ? 'Sí' : 'No' }}</div>
    </div>
      <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Ingresado por</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->ingresado_por ?? '-' }}</div>
          </div>
<div class="bg-white dark:bg-gray-800 rounded shadow p-4">
  <div class="text-sm text-gray-600 dark:text-gray-300">Fecha de Ingreso</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->created_at ?? '-' }}</div>
  </div>
<div class="bg-white dark:bg-gray-800 rounded shadow p-4">
  <div class="text-sm text-gray-600 dark:text-gray-300">Modelo</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->modelo ?? '-' }}</div>
  </div>

<div class="bg-white dark:bg-gray-800 rounded shadow p-4">
  <div class="text-sm text-gray-600 dark:text-gray-300">Nombre</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventario->nombre ?? '-' }}</div>
  </div>


  </div>
  



  <div class="bg-white dark:bg-gray-800 rounded shadow">
    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
      <h2 class="font-medium text-gray-900 dark:text-gray-100">Movimientos</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cantidad</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ubicación</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nota</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
          @forelse ($movimientos as $m)
            <tr>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->created_at->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-2 text-sm">
                @if($m->tipo === 'entrada')
                  <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-0.5 text-xs font-semibold">Entrada</span>
                @else
                  <span class="inline-flex items-center rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-0.5 text-xs font-semibold">Salida</span>
                @endif
              </td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->cantidad }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ optional($m->user)->nombre ?? '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ optional($m->ubicacion)->nombre ?? '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->nota ?? '-' }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Sin movimientos</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3">{{ $movimientos->links() }}</div>
  </div>
</div>
@endsection
