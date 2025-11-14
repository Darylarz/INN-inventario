<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
  <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Crear artículo</h2>

  @if(session('error')) <div class="text-sm text-red-600 mb-3">{{ session('error') }}</div> @endif
  @if(session('success')) <div class="text-sm text-green-600 mb-3">{{ session('success') }}</div> @endif

  <form wire:submit.prevent="submit" class="space-y-4">
    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Marca</label>
      <input wire:model.defer="brand" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('brand') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Modelo</label>
      <input wire:model.defer="model" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('model') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Número de serie</label>
      <input wire:model.defer="serial_number" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('serial_number') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Etiqueta patrimonio</label>
      <input wire:model.defer="national_asset_tag" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('national_asset_tag') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Tipo</label>
      <select wire:model.defer="item_type" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        <option value="">-- seleccionar --</option>
        @foreach($inventoryTypes as $type)
          <option value="{{ $type->name }}">{{ $type->name }}</option>
        @endforeach
      </select>
      @error('item_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-700 dark:text-gray-300">Modelo impresora</label>
      <input wire:model.defer="printer_model" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
      @error('printer_model') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="flex justify-end">
      <a href="{{ route('inventario-index') }}" class="mr-2 text-sm text-gray-600 hover:underline">Cancelar</a>
      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Crear</button>
    </div>
  </form>
</div>