@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <div class="flex items-start justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Detalle del artículo</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">ID: {{ $inventory->id }} — {{ $inventory->brand }} {{ $inventory->model }}</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('inventory.entrada.create', $inventory) }}" class="inline-flex items-center px-3 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">Entrada</a>
      <a href="{{ route('inventory.salida.create', $inventory) }}" class="inline-flex items-center px-3 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Salida</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Stock actual</div>
      <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $inventory->quantity ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Tipo</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventory->item_type ?? '-' }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
      <div class="text-sm text-gray-600 dark:text-gray-300">Serial</div>
      <div class="text-base text-gray-900 dark:text-gray-100 mt-1">{{ $inventory->serial_number ?? '-' }}</div>
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
          @forelse ($movements as $m)
            <tr>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->created_at->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-2 text-sm">
                @if($m->type === 'in')
                  <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-0.5 text-xs font-semibold">Entrada</span>
                @else
                  <span class="inline-flex items-center rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-0.5 text-xs font-semibold">Salida</span>
                @endif
              </td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->quantity }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ optional($m->user)->name ?? '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ optional($m->location)->name ?? '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $m->note ?? '-' }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Sin movimientos</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3">{{ $movements->links() }}</div>
  </div>
</div>
@endsection
