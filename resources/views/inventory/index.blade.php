@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Inventario</h2>

    @if(session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif

    <div class="flex items-center gap-3 mb-4">
      @can('articulo agregar')  <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Nuevo Artículo</a> @endcan 
        <form action="{{ route('inventory.index') }}" method="GET" class="flex-1 flex items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por tipo, marca, modelo, nro de serie, bien nacional y tipo de articulo." class="w-full px-3 py-2 border rounded">
            <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Buscar</button>
            @if(!empty($search))
                <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-gray-700 underline">Limpiar</a>
            @endif
        </form>
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