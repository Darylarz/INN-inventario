@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
  <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Nueva ubicación</h1>

  <form method="POST" action="{{ route('ubicaciones.store') }}" class="bg-white dark:bg-gray-800 rounded shadow p-4 space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</label>
      <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="120" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
      @error('nombre')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Código (opcional)</label>
      <input type="text" name="codigo" value="{{ old('codigo') }}" maxlength="60" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
      @error('codigo')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Descripción (opcional)</label>
      <input type="text" name="descripcion" value="{{ old('descripcion') }}" maxlength="255" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
      @error('descripcion')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center justify-end gap-2">
      <a href="{{ route('ubicaciones.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">Cancelar</a>
      <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Crear</button>
    </div>
  </form>
</div>
@endsection
