@extends('layouts.app')

@section('header', 'Consumibles')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">

        <a href="{{ route('consumibles.crear') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Nuevo Consumible
        </a>

        <table class="w-full mt-5 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Categoría</th>
                    <th class="border px-3 py-2">Marca</th>
                    <th class="border px-3 py-2">Modelo</th>
                    <th class="border px-3 py-2">Color</th>
                    <th class="border px-3 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consumibles as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->categoria }}</td>
                        <td class="border px-3 py-2">{{ $item->marca }}</td>
                        <td class="border px-3 py-2">{{ $item->modelo }}</td>
                        <td class="border px-3 py-2">{{ $item->color }}</td>
                        <td class="border px-3 py-2 text-center">
                            <a href="{{ route('consumibles.editar', $item->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('consumibles.eliminar', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar consumible?')">
                                @csrf
                                @method('DELETE')
                                <button class="inline-block px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $consumibles->links() }}
    </div>
</div>
@endsection
