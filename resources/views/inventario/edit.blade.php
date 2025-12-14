@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Editar artículo</h2>

    <form action="{{ route('inventario.update', $inventario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Tipo de artículo</label>
            <select name="tipo_item" class="w-full px-3 py-2 border rounded">
                <option value="">-- seleccionar --</option>
                @foreach($tipoInventario as $tipo)
                    <option value="{{ $tipo->nombre }}" {{ $inventario->tipo_item == $tipo->nombre ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Marca(si aplica)</label>
            <input type="text" name="marca" class="w-full px-3 py-2 border rounded" value="{{ $inventario->marca }}">
        </div>

        <div>
            <label>Modelo(si aplica)</label>
            <input type="text" name="modelo" class="w-full px-3 py-2 border rounded" value="{{ $inventario->modelo }}">
        </div>

        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="w-full px-3 py-2 border rounded" value="{{ $inventario->name }}">
        </div>
        <div class="flex items-center gap-2 mt-2">
            <input id="reciclado" type="checkbox" name="reciclado" value="1" {{ $inventario->reciclado ? 'checked' : '' }}>
            <label for="reciclado" class="select-none">Reciclado</label>
        </div>
        <div>
            <label>Artículo ingresado por</label>
            <input type="text" name="ingresado_por" class="w-full px-3 py-2 border rounded" value="{{ $inventario->ingresado_por }}">
        </div>
        <div>
            <label>Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border rounded" value="{{ $inventario->fecha_ingreso }}">
        </div>

        <div>
            <label>Capacidad(si aplica)</label>
            <input type="text" name="capacidad" class="w-full px-3 py-2 border rounded" value="{{ $inventario->capacidad }}">
        </div>

        <div>
            <label>Tipo(si aplica)</label>
            <input type="text" name="tipo" class="w-full px-3 py-2 border rounded" value="{{ $inventario->tipo }}">
        </div>

        <div>
            <label>Generación(si aplica)</label>
            <input type="text" name="generacion" class="w-full px-3 py-2 border rounded" value="{{ $inventario->generacion }}">
        </div>

        <div>
            <label>Número de serie(si aplica)</label>
            <input type="text" name="numero_serial" class="w-full px-3 py-2 border rounded" value="{{ $inventario->numero_serial }}">
        </div>

        <div>
            <label>Bien nacional(si aplica)</label>
            <input type="text" name="bien_nacional" class="w-full px-3 py-2 border rounded" value="{{ $inventario->bien_nacional }}">
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
