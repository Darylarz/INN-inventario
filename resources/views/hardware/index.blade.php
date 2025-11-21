@extends('layouts.app')

@section('header', 'Inventario de Hardware')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto bg-white shadow rounded-lg p-6">

        <a href="{{ route('hardware.crear') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Nuevo Artículo
        </a>

        <table class="w-full mt-5 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">Marca</th>
                    <th class="px-3 py-2 border">Modelo</th>
                    <th class="px-3 py-2 border">Tipo</th>
                    <th class="px-3 py-2 border">Serial</th>
                    <th class="px-3 py-2 border">Bien Nacional</th>
                    <th class="px-3 py-2 border w-32">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articulos as $item)
                    <tr class="border">
                        <td class="px-3 py-2 border">{{ $item->marca }}</td>
                        <td class="px-3 py-2 border">{{ $item->modelo }}</td>
                        <td class="px-3 py-2 border">{{ $item->tipo }}</td>
                        <td class="px-3 py-2 border">{{ $item->serial }}</td>
                        <td class="px-3 py-2 border">{{ $item->bien_nacional }}</td>
                        <td class="px-3 py-2 border text-center">
                            <a href="{{ route('hardware.editar', $item->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('hardware.eliminar', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar artículo?');">
                                @csrf
                                @method('DELETE') 
                                <button class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-4 text-center">Sin registros</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $articulos->links() }}
        </div>
    </div>
</div>
@endsection

