@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Desincorporados</h2>
        <a href="{{ route('inventario.index') }}" class="px-3 py-2 text-sm bg-gray-100 border rounded hover:bg-gray-200">Volver al inventario</a>
    </div>

    @if(session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="text-red-600 mb-3">{{ session('error') }}</div>
    @endif

    <div class="flex items-center gap-3 mb-4">
        <form action="{{ route('inventario.disabled') }}" method="GET" class="flex-1 flex items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por marca, modelo, serie, bien nacional..." class="w-full px-3 py-2 border rounded">
            <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Buscar</button>
            @if(!empty($search))
                <a href="{{ route('inventario.disabled') }}" class="px-3 py-2 text-gray-700 underline">Limpiar</a>
            @endif
        </form>
    </div>

    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Tipo</th>
                <th class="border px-3 py-2">Marca</th>
                <th class="border px-3 py-2">Modelo</th>
                <th class="border px-3 py-2">Número de serie</th>
                <th class="border px-3 py-2">Bien Nacional</th>
                <th class="border px-3 py-2">Fecha</th>
                <th class="border px-3 py-2">Motivo</th>
                @can('usuario crear')
                    <th class="border px-3 py-2">Acciones</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($inventario as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">{{ $item->tipo_item }}</td>
                    <td class="border px-3 py-2">{{ $item->marca }}</td>
                    <td class="border px-3 py-2">{{ $item->modelo }}</td>
                    <td class="border px-3 py-2">{{ $item->numero_serial }}</td>
                    <td class="border px-3 py-2">{{ $item->bien_nacional }}</td>
                    <td class="border px-3 py-2">{{ optional($item->fecha_desactivado)->format('Y-m-d H:i') }}</td>
                    <td class="border px-3 py-2">{{ $item->razon_desactivado ?? '-' }}</td>
                    @can('usuario crear')
                        <td class="border px-3 py-2">
                            <form action="{{ route('inventario.enable', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Reincorporar artículo?')">
                                @csrf
                                <button class="text-green-600">Reincorporar</button>
                            </form>
                            <form action="{{ route('inventario.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar artículo?')">
                  @csrf
                  @method('DELETE')
                  <button class="text-red-600">Eliminar</button>
                </form>
                        </td>
                    @endcan
                    
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-600">No hay artículos desincorporados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $inventario->links() }}
    </div>
</div>
@endsection
