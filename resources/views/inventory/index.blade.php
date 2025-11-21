@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Inventario</h2>

    @if(session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif

    <div class="space-y-3 mb-4">
      <div class="flex items-center gap-3">
        @can('articulo agregar')
          <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Nuevo Artículo</a>
        @endcan
      </div>

      <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar texto libre..." class="px-3 py-2 border rounded">

        @php
          $types = ['PC','Hardware','Consumable','Tool'];
          $labels = ['PC'=>'PC','Hardware'=>'Hardware','Consumable'=>'Consumible','Tool'=>'Herramienta'];
        @endphp
        <select name="item_type" class="px-3 py-2 border rounded">
          <option value="">Tipo (todos)</option>
          @foreach($types as $t)
            <option value="{{ $t }}" @selected(request('item_type')===$t)>{{ $labels[$t] ?? $t }}</option>
          @endforeach
        </select>

        <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Marca" class="px-3 py-2 border rounded">
        <input type="text" name="model" value="{{ request('model') }}" placeholder="Modelo" class="px-3 py-2 border rounded">
        <input type="text" name="serial_number" value="{{ request('serial_number') }}" placeholder="Nro de serie" class="px-3 py-2 border rounded">
        <input type="text" name="national_asset_tag" value="{{ request('national_asset_tag') }}" placeholder="Bien nacional" class="px-3 py-2 border rounded">

        <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border rounded">
        <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border rounded">

        @php $sort = request('sort'); @endphp
        <select name="sort" class="px-3 py-2 border rounded">
          <option value="id_desc" @selected($sort==='id_desc')>Recientes</option>
          <option value="brand_asc" @selected($sort==='brand_asc')>Marca A-Z</option>
          <option value="model_asc" @selected($sort==='model_asc')>Modelo A-Z</option>
          <option value="created_at_desc" @selected($sort==='created_at_desc')>Fecha creación ↓</option>
        </select>

        <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Aplicar</button>
        @if(request()->query())
          <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-gray-700 underline">Limpiar</a>
        @endif
      </form>

      @php
        $chips = collect([
          'q' => 'Texto',
          'item_type' => 'Tipo',
          'brand' => 'Marca',
          'model' => 'Modelo',
          'serial_number' => 'Serie',
          'national_asset_tag' => 'Bien Nal.',
          'from' => 'Desde',
          'to' => 'Hasta',
          'sort' => 'Orden',
        ])->filter(fn($label,$key)=>filled(request($key)));
      @endphp

      @if($chips->isNotEmpty())
        <div class="flex flex-wrap gap-2 items-center">
          <span class="text-sm text-gray-600">Filtros:</span>
          @foreach($chips as $key=>$label)
            <button
              type="button"
              onclick="const url=new URL(window.location.href);url.searchParams.delete('{{ $key }}');window.location.href=url.toString();"
              class="px-2 py-1 text-sm bg-gray-100 border rounded hover:bg-gray-200"
            >
              {{ $label }}: {{ request($key) }} 
            </button>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Tabla única: Todos los artículos --}}
    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Tipo</th>
                <th class="border px-3 py-2">Marca</th>
                <th class="border px-3 py-2">Modelo</th>
                <th class="border px-3 py-2">Capacidad</th>
                <th class="border px-3 py-2">Tipo (componente)</th>
                <th class="border px-3 py-2">Generación</th>
                <th class="border px-3 py-2">Número de serie</th>
                <th class="border px-3 py-2">Bien Nacional</th>
                @can('usuario crear')
                    <th class="border px-3 py-2">Acciones</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">{{ $item->item_type }}</td>
                    <td class="border px-3 py-2">{{ $item->brand ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->model ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->capacity ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->type ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->generation ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->serial_number ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $item->national_asset_tag ?? '-' }}</td>
                    @can('usuario crear')
                        <td class="border px-3 py-2">
                            <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-600 mr-2">Editar</a>
                            <form action="{{ route('inventory.disable', $item->id) }}" method="POST" class="inline" onsubmit="var r = prompt('Motivo de desincorporación (opcional):'); if (r === null) { return false; } this.querySelector('input[name=disabled_reason]').value = r; return confirm('¿Desincorporar artículo?');">
                                @csrf
                                <input type="hidden" name="disabled_reason" value="">
                                <button class="text-yellow-600 mr-2">Desincorporar</button>
                            </form>
                            <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar artículo?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $inventories->links() }}
    </div>
</div>
@endsection