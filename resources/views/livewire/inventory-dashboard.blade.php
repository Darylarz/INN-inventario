<div class="p-6">
  <div class="mb-4 flex items-center justify-between gap-4">
    <input wire:model.debounce.300ms="search" placeholder="Buscar..." class="border p-2 rounded w-full" />

    <!-- Botón para ir a crear -->
    <a href="{{ route('inventario-create') }}"
       class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      Crear artículo
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Marca</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Modelo</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">SN</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Tipo</th>
          <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($inventories as $item)
          <tr>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->brand }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->model }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->serial_number }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->type ?? $item->item_type }}</td>
            <td class="px-4 py-2 text-sm text-right">
              <a href="{{ route('inventario-edit', $item->id) }}" class="text-indigo-600 hover:underline mr-3">Editar</a>

              <form method="POST" action="{{ route('inventario-destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Eliminar artículo?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $inventories->links() }}
  </div>
</div>