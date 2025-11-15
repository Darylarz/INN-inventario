@extends('layouts.app')

@section('header', 'Herramientas')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto bg-white shadow p-6 rounded">
        <a href="{{ route('herramientas.crear') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Nueva Herramienta
        </a>

        <table class="w-full mt-5 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Nombre</th>
                    <th class="border px-3 py-2">Tipo</th>
                    <th class="border px-3 py-2 w-32">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($herramientas as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->nombre }}</td>
                        <td class="border px-3 py-2">{{ $item->tipo }}</td>
                        <td class="border px-3 py-2 text-center">
                            <a href="{{ route('herramientas.editar', $item->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('herramientas.eliminar', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar herramienta?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $herramientas->links() }}
    </div>
</div>
@endsection
