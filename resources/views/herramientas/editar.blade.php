@extends('layouts.app')

@section('header', 'Editar Herramienta')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded p-6 mt-6">
    <form action="{{ route('herramientas.actualizar', $herramienta->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $herramienta->nombre) }}" class="w-full border rounded px-2 py-1">
            @error('nombre') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium">Tipo</label>
            <input type="text" name="tipo" value="{{ old('tipo', $herramienta->tipo) }}" class="w-full border rounded px-2 py-1">
            @error('tipo') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
    </form>
</div>
@endsection
