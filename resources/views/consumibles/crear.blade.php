@extends('layouts.app')

@section('header', 'Nuevo Consumible')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6 mt-6">
    <form action="{{ route('consumibles.guardar') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Categoría</label>
                <input type="text" name="categoria" value="{{ old('categoria') }}" class="w-full border rounded px-2 py-1">
                @error('categoria') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Marca</label>
                <input type="text" name="marca" value="{{ old('marca') }}" class="w-full border rounded px-2 py-1">
                @error('marca') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo') }}" class="w-full border rounded px-2 py-1">
                @error('modelo') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Modelo de impresora / Color</label>
                <input type="text" name="modelo_impresora" value="{{ old('modelo_impresora') }}" class="w-full border rounded px-2 py-1">
                @error('modelo_impresora') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Color</label>
                <input type="text" name="color" value="{{ old('color') }}" class="w-full border rounded px-2 py-1">
                @error('color') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Tipo Material / Impresora destino</label>
                <input type="text" name="tipo_material" value="{{ old('tipo_material') }}" class="w-full border rounded px-2 py-1">
                @error('tipo_material') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
    </form>
</div>
@endsection
