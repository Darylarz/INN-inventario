@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Reportes de Inventario</h2>
        <a href="{{ route('inventory.index') }}" class="px-3 py-2 text-sm bg-gray-100 border rounded hover:bg-gray-200">Volver</a>
    </div>

    <div class="bg-white border rounded p-4 shadow-sm">
        <form action="{{ route('reports.pdf') }}" method="POST" target="_blank" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-700 mb-1">Estado</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="all">Todos</option>
                    <option value="enabled">Activos</option>
                    <option value="disabled">Desincorporados</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Tipo</label>
                <select name="item_type" class="w-full border rounded px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($itemTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Desde</label>
                <input type="date" name="from" class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Hasta</label>
                <input type="date" name="to" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generar PDF</button>
            </div>
        </form>
    </div>
</div>
@endsection
