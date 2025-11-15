@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Editar artículo</h2>

    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Tipo de artículo</label>
            <select name="item_type" class="w-full px-3 py-2 border rounded">
                <option value="">-- seleccionar --</option>
                @foreach($inventoryTypes as $type)
                    <option value="{{ $type->name }}" {{ $inventory->item_type == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Marca</label>
            <input type="text" name="brand" class="w-full px-3 py-2 border rounded" value="{{ $inventory->brand }}">
        </div>

        <div>
            <label>Modelo</label>
            <input type="text" name="model" class="w-full px-3 py-2 border rounded" value="{{ $inventory->model }}">
        </div>

        <div>
            <label>Capacidad</label>
            <input type="text" name="capacity" class="w-full px-3 py-2 border rounded" value="{{ $inventory->capacity }}">
        </div>

        <div>
            <label>Tipo</label>
            <input type="text" name="type" class="w-full px-3 py-2 border rounded" value="{{ $inventory->type }}">
        </div>

        <div>
            <label>Generación</label>
            <input type="text" name="generation" class="w-full px-3 py-2 border rounded" value="{{ $inventory->generation }}">
        </div>

        <div>
            <label>Número de serie</label>
            <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ $inventory->serial_number }}">
        </div>

        <div>
            <label>Bien nacional</label>
            <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ $inventory->national_asset_tag }}">
        </div>

        <div>
            <label>Nombre herramienta</label>
            <input type="text" name="tool_name" class="w-full px-3 py-2 border rounded" value="{{ $inventory->tool_name }}">
        </div>

        <div>
            <label>Color</label>
            <input type="text" name="color" class="w-full px-3 py-2 border rounded" value="{{ $inventory->color }}">
        </div>

        <div>
            <label>Modelo impresora</label>
            <input type="text" name="printer_model" class="w-full px-3 py-2 border rounded" value="{{ $inventory->printer_model }}">
        </div>

        <div>
            <label>Material / Categoría</label>
            <input type="text" name="material_type" class="w-full px-3 py-2 border rounded" value="{{ $inventory->material_type }}">
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
