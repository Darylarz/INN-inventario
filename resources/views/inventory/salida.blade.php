@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Salida de artículo</h1>

  <div class="bg-white dark:bg-gray-800 shadow rounded p-4 mb-4">
    <div class="text-sm text-gray-600 dark:text-gray-300">Artículo</div>
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $inventory->brand }} {{ $inventory->model }} (ID: {{ $inventory->id }})</div>
    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">Stock actual: <span class="font-semibold">{{ $inventory->quantity ?? 0 }}</span></div>
  </div>

  <form method="POST" action="{{ route('inventory.salida.store', $inventory) }}" class="bg-white dark:bg-gray-800 shadow rounded p-4 space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cantidad a retirar</label>
      <input type="number" name="quantity" min="1" max="{{ max(0, (int)($inventory->quantity ?? 0)) }}" required class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" value="{{ old('quantity', 1) }}">
      @error('quantity')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nota (opcional)</label>
      <input type="text" name="note" maxlength="255" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" value="{{ old('note') }}">
      @error('note')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center justify-end gap-2">
      <a href="{{ route('inventory.show', $inventory) }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">Cancelar</a>
      <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">Registrar salida</button>
    </div>
  </form>
</div>
@endsection
