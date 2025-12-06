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
                @foreach($tipoInventario as $type)
                    <option value="{{ $type->name }}" {{ $inventory->item_type == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Marca(si aplica)</label>
            <input type="text" name="brand" class="w-full px-3 py-2 border rounded" value="{{ $inventory->brand }}">
        </div>

        <div>
            <label>Modelo(si aplica)</label>
            <input type="text" name="model" class="w-full px-3 py-2 border rounded" value="{{ $inventory->model }}">
        </div>

        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="w-full px-3 py-2 border rounded" value="{{ $inventory->name }}">
        </div>
        <div class="flex items-center gap-2 mt-2">
            <input id="recycled" type="checkbox" name="recycled" value="1" {{ $inventory->recycled ? 'checked' : '' }}>
            <label for="recycled" class="select-none">Reciclado</label>
        </div>
        <div>
            <label>Artículo ingresado por</label>
            <input type="text" name="entered_by" class="w-full px-3 py-2 border rounded" value="{{ $inventory->entered_by }}">
        </div>
        <div>
            <label>Fecha de ingreso</label>
            <input type="date" name="entry_date" class="w-full px-3 py-2 border rounded" value="{{ $inventory->entry_date }}">
        </div>

        <div>
            <label>Capacidad(si aplica)</label>
            <input type="text" name="capacity" class="w-full px-3 py-2 border rounded" value="{{ $inventory->capacity }}">
        </div>

        <div>
            <label>Tipo(si aplica)</label>
            <input type="text" name="type" class="w-full px-3 py-2 border rounded" value="{{ $inventory->type }}">
        </div>

        <div>
            <label>Generación(si aplica)</label>
            <input type="text" name="generation" class="w-full px-3 py-2 border rounded" value="{{ $inventory->generation }}">
        </div>

        <div>
            <label>Número de serie(si aplica)</label>
            <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ $inventory->serial_number }}">
        </div>

        <div>
            <label>Bien nacional(si aplica)</label>
            <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ $inventory->national_asset_tag }}">
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
