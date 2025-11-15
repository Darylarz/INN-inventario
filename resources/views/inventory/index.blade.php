@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Inventario</h2>

    @if(session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif

    <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Nuevo Artículo</a>

    <table class="w-full mt-5 border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Tipo</th>
                <th class="border px-3 py-2">Marca</th>
                <th class="border px-3 py-2">Modelo</th>
                <th class="border px-3 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $item)
            <tr>
                <td class="border px-3 py-2">{{ $item->item_type }}</td>
                <td class="border px-3 py-2">{{ $item->brand }}</td>
                <td class="border px-3 py-2">{{ $item->model }}</td>
                <td class="border px-3 py-2">
                    <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-600 mr-2">Editar</a>
                    <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar artículo?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $inventories->links() }}
    </div>
</div>
@endsection
