@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Entrada de artículo</h1>

  <div class="bg-white dark:bg-gray-800 shadow rounded p-4 mb-4">
    <div class="text-sm text-gray-600 dark:text-gray-300">Artículo</div>
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $inventario->marca }} {{ $inventario->modelo }} (ID: {{ $inventario->id }})</div>
    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">Stock actual: <span class="font-semibold">{{ $inventario->cantidad ?? 0 }}</span></div>
  </div>

  <form method="POST" action="{{ route('inventario.entrada.store', $inventario) }}" class="bg-white dark:bg-gray-800 shadow rounded p-4 space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cantidad a ingresar</label>
      <input type="number" name="cantidad" min="1" required class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" value="{{ old('cantidad', 1) }}">
      @error('cantidad')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nota (opcional)</label>
      <input type="text" name="nota" maxlength="255" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" value="{{ old('nota') }}">
      @error('nota')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center justify-end gap-2">
      <a href="{{ route('inventario.show', $inventario) }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">Cancelar</a>
      <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">Registrar entrada</button>
    </div>
  </form>
</div>
@endsection
