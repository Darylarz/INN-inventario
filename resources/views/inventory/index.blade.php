@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Inventario</h2>

    {{-- Resumen global de unidades --}}
    @isset($totalUnits)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
        <div class="text-sm text-gray-600 dark:text-gray-300">Unidades totales</div>
        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format((int)($totalUnits ?? 0)) }}</div>
      </div>
      <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded shadow p-4">
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">Unidades por categoría</div>
        <div class="flex flex-wrap gap-2">
          @forelse(($totalsByType ?? collect()) as $type => $sum)
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200 text-sm">
              <span class="font-medium">{{ $type ?: 'Sin categoría' }}</span>
              <span class="inline-flex items-center justify-center rounded bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 text-xs font-semibold px-2 py-0.5">{{ (int)$sum }}</span>
            </span>
          @empty
            <span class="text-sm text-gray-500 dark:text-gray-400">Sin datos de categorías</span>
          @endforelse
        </div>
      </div>
    </div>
    @endisset

    @if(session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif

    @if(($lowStockItems ?? collect())->count())
      <div class="mb-4 rounded border border-yellow-300 bg-yellow-50 text-yellow-800 p-4">
        <div class="font-semibold mb-2">Alerta: stock bajo en {{ ($lowStockItems ?? collect())->count() }} artículo(s)</div>
        <ul class="list-disc pl-5 space-y-1">
          @foreach($lowStockItems as $i)
            <li>
              {{ $i->item_type ?? 'Artículo' }} —
              {{ trim(($i->brand ?? '').' '.($i->model ?? '')) }}
              {{ $i->tool_name ? ' · '.$i->tool_name : '' }}
              {{ $i->printer_model ? ' · '.$i->printer_model : '' }}
              {{ $i->material_type ? ' · '.$i->material_type : '' }}
              ({{ (int)($i->quantity ?? 0) }})
              <a href="{{ route('inventory.show', $i->id) }}" class="underline">ver</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="space-y-3 mb-4">
      <div class="flex items-center gap-3">
        @can('articulo agregar')
          <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Nuevo Artículo</a>
        @endcan
      </div>

      <form action="{{ route('inventory.index') }}" method="GET" class="flex-1 flex items-center gap-2">
        <input type="hidden" name="page" value="1">
        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Buscar por marca, modelo, nro de serie, bien nacional, tipo, modelo impresora, capacidad y generación" class="w-full px-3 py-2 border rounded">
        <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Buscar</button>
        @if(!empty($search) || filled(request('search')))
          <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-gray-700 underline">Limpiar</a>
        @endif
      </form>
    </div>

    @php
      // Obtener la colección de la página actual para agrupar por tipo sin afectar la paginación
      $pageItems = $inventories->getCollection();
      $pcItems = $pageItems->filter(fn($i) => in_array($i->item_type, ['PC','Hardware']));
      $consumableItems = $pageItems->filter(fn($i) => $i->item_type === 'Consumible');
      $toolItems = $pageItems->filter(fn($i) => $i->item_type === 'Herramienta');
    @endphp

    {{-- Tabla PC / Hardware --}}
    <h3 class="text-lg font-semibold mt-6 mb-2">PC / Hardware</h3>
    <table class="table-auto border-collapse border border-gray-300 w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-3 py-2">Nombre</th>
          <th class="border px-3 py-2">Número de serie</th>
          <th class="border px-3 py-2">Bien Nacional</th>
          
          
          <th class="border px-3 py-2">Modelo</th>
          
          
          
          
          <th class="border px-3 py-2">Reciclado</th>
          <th class="border px-3 py-2">Artículo ingresado por</th>
          <th class="border px-3 py-2">Fecha de ingreso</th>
          @can('usuario crear')
            <th class="border px-3 py-2">Acciones</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @forelse($pcItems as $item)
          <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2">{{ $item->name ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->serial_number ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->national_asset_tag ?? '-' }}</td>
            
            
            <td class="border px-3 py-2">{{ $item->model ?? '-' }}</td>
            
            
            
            <td class="border px-3 py-2">{{ $item->recycled ? 'Sí' : 'No' }}</td>
            <td class="border px-3 py-2">{{ $item->entered_by ?? '-' }}</td>
            <td class="border px-3 py-2">{{ optional($item->entry_date)->format('Y-m-d') ?? ($item->entry_date ?? '-') }}</td>
            @can('usuario crear')
              <td class="border px-3 py-2">
                <a href="{{ route('inventory.show', $item->id) }}" class="inline-block px-2 py-1 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 mr-2">Detalle</a>
                <a href="{{ route('inventory.entrada.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-green-600 hover:bg-green-700 text-white mr-2">Entrada</a>
                <a href="{{ route('inventory.salida.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white mr-2">Salida</a>
                <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-600 mr-2">Editar</a>
                <form action="{{ route('inventory.disable', $item->id) }}" method="POST" class="inline" onsubmit="var r = prompt('Motivo de desincorporación (opcional):'); if (r === null) { return false; } this.querySelector('input[name=disabled_reason]').value = r; return confirm('¿Desincorporar artículo?');">
                  @csrf
                  <input type="hidden" name="disabled_reason" value="">
                  <button class="text-yellow-600 mr-2">Desincorporar</button>
                </form>
                
              </td>
            @endcan
          </tr>
        @empty
          <tr><td colspan="13" class="text-center py-3 text-gray-500">Sin resultados</td></tr>
        @endforelse
      </tbody>
    </table>

    {{-- Tabla Consumibles --}}
    <h3 class="text-lg font-semibold mt-8 mb-2">Consumibles</h3>
    <table class="table-auto border-collapse border border-gray-300 w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-3 py-2">Nombre</th>
          <th class="border px-3 py-2">Marca</th>
          
          <th class="border px-3 py-2">Color</th>
          
          <th class="border px-3 py-2">Material / Categoría</th>
          <th class="border px-3 py-2">Reciclado</th>
          <th class="border px-3 py-2">Artículo ingresado por</th>
          <th class="border px-3 py-2">Fecha de ingreso</th>
          @can('usuario crear')
            <th class="border px-3 py-2">Acciones</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @forelse($consumableItems as $item)
          <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2">{{ $item->name ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->brand ?? '-' }}</td>
            
            <td class="border px-3 py-2">{{ $item->color ?? '-' }}</td>
            
            <td class="border px-3 py-2">{{ $item->material_type ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->recycled ? 'Sí' : 'No' }}</td>
            <td class="border px-3 py-2">{{ $item->entered_by ?? '-' }}</td>
            <td class="border px-3 py-2">{{ optional($item->entry_date)->format('Y-m-d') ?? ($item->entry_date ?? '-') }}</td>
            @can('usuario crear')
              <td class="border px-3 py-2">
                <a href="{{ route('inventory.show', $item->id) }}" class="inline-block px-2 py-1 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 mr-2">Detalle</a>
                <a href="{{ route('inventory.entrada.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-green-600 hover:bg-green-700 text-white mr-2">Entrada</a>
                <a href="{{ route('inventory.salida.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white mr-2">Salida</a>
                <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-600 mr-2">Editar</a>
                <form action="{{ route('inventory.disable', $item->id) }}" method="POST" class="inline" onsubmit="var r = prompt('Motivo de desincorporación (opcional):'); if (r === null) { return false; } this.querySelector('input[name=disabled_reason]').value = r; return confirm('¿Desincorporar artículo?');">
                  @csrf
                  <input type="hidden" name="disabled_reason" value="">
                  <button class="text-yellow-600 mr-2">Desincorporar</button>
                </form>
                
              </td>
            @endcan
          </tr>
        @empty
          <tr><td colspan="10" class="text-center py-3 text-gray-500">Sin resultados</td></tr>
        @endforelse
      </tbody>
    </table>

    {{-- Tabla Herramientas --}}
    <h3 class="text-lg font-semibold mt-8 mb-2">Herramientas</h3>
    <table class="table-auto border-collapse border border-gray-300 w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-3 py-2">Nombre</th>
          <th class="border px-3 py-2">Marca</th>
          <th class="border px-3 py-2">Modelo</th>
          
          <th class="border px-3 py-2">Tipo herramienta</th>
          <th class="border px-3 py-2">Reciclado</th>
          <th class="border px-3 py-2">Artículo ingresado por</th>
          <th class="border px-3 py-2">Fecha de ingreso</th>
          @can('usuario crear')
            <th class="border px-3 py-2">Acciones</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @forelse($toolItems as $item)
          <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2">{{ $item->name ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->brand ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->model ?? '-' }}</td>
            
            <td class="border px-3 py-2">{{ $item->tool_type ?? '-' }}</td>
            <td class="border px-3 py-2">{{ $item->recycled ? 'Sí' : 'No' }}</td>
            <td class="border px-3 py-2">{{ $item->entered_by ?? '-' }}</td>
            <td class="border px-3 py-2">{{ optional($item->entry_date)->format('Y-m-d') ?? ($item->entry_date ?? '-') }}</td>
            @can('usuario crear')
              <td class="border px-3 py-2">
                <a href="{{ route('inventory.show', $item->id) }}" class="inline-block px-2 py-1 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 mr-2">Detalle</a>
                <a href="{{ route('inventory.entrada.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-green-600 hover:bg-green-700 text-white mr-2">Entrada</a>
                <a href="{{ route('inventory.salida.create', $item->id) }}" class="inline-block px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white mr-2">Salida</a>
                <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-600 mr-2">Editar</a>
                <form action="{{ route('inventory.disable', $item->id) }}" method="POST" class="inline" onsubmit="var r = prompt('Motivo de desincorporación (opcional):'); if (r === null) { return false; } this.querySelector('input[name=disabled_reason]').value = r; return confirm('¿Desincorporar artículo?');">
                  @csrf
                  <input type="hidden" name="disabled_reason" value="">
                  <button class="text-yellow-600 mr-2">Desincorporar</button>
                </form>
                
              </td>
            @endcan
          </tr>
        @empty
          <tr><td colspan="9" class="text-center py-3 text-gray-500">Sin resultados</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-6">
      {{ $inventories->links() }}
    </div>
</div>
@endsection