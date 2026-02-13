@extends('layouts.app')

@section('header', 'Editar Consumible')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6 mt-6">
    <form action="{{ route('consumibles.actualizar', $consumible->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <input type="text" name="categoria" value="{{ old('categoria', $consumible->categoria) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('categoria') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <input type="text" name="marca" value="{{ old('marca', $consumible->marca) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('marca') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo', $consumible->modelo) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('modelo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo de impresora / Color</label>
                <input type="text" name="modelo_impresora" value="{{ old('modelo_impresora', $consumible->modelo_impresora) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('modelo_impresora') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="text" name="color" value="{{ old('color', $consumible->color) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('color') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Material / Impresora destino</label>
                <input type="text" name="tipo_material" value="{{ old('tipo_material', $consumible->tipo_material) }}" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                @error('tipo_material') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
