@extends('layouts.app')

@section('content')
    <div class="flex-grow p-10 overflow-y-auto">
        <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Inventario de Artículos</h2>

        {{-- Mostrar mensajes de éxito/error --}}
        @if(session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl" id="inventory-container">
            
            {{-- Área de Búsqueda y Botón de Agregar --}}
            <div class="mb-4 flex justify-between items-center">
                <div class="w-1/3 relative">
                    <input 
                        id="search-input"
                        type="text" 
                        value="{{ request()->search ?? '' }}"
                        placeholder="Buscar por Marca, Modelo o Serial..." 
                        class="p-2 pr-16 border border-gray-300 rounded-lg w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                    
                    {{-- Clear button (show only when there's text) --}}
                    @if(request()->search)
                        <button 
                            id="clear-search"
                            type="button"
                            class="absolute right-8 top-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            title="Limpiar búsqueda"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                    
                    {{-- Loading spinner --}}
                    <div id="loading-spinner" class="absolute right-2 top-2 hidden">
                        <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                {{-- Botón para agregar --}}
                @can('articulo agregar')
                    <a 
                        href="{{ route('inventory.create') }}" 
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
                    >
                        + Agregar Nuevo Ítem
                    </a>
                @endcan
            </div>
    
            {{-- TABLA DE ARTÍCULOS --}}
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Marca</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Modelo / Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bien Nacional</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serial</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tbody id="inventory-tbody">
                        @forelse($inventories as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item->brand ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->model ?? $item->item_type ?? $item->printer_model ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ ucfirst(str_replace('_', ' ', $item->type)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->national_asset_tag ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->serial_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    @can('articulo modificar')
                                        <a href="{{ route('inventory.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                            Editar
                                        </a>
                                    @endcan
                                    @can('articulo eliminar')
                                        <form action="{{ route('inventory.destroy', $item) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ítem?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 focus:outline-none">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endcan    
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    No hay ítems de inventario registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </tbody>
            </table>

            
        </div>
    </div>
@endsection

<script>
// Simple vanilla JS search - no frameworks needed
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const tbody = document.getElementById('inventory-tbody');
    const spinner = document.getElementById('loading-spinner');
    let searchTimeout;
    
    // Focus at the end of existing text if there's a search term
    if (searchInput.value) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = this.value.trim();
        
        searchTimeout = setTimeout(() => {
            if (searchTerm === '') {
                // Reload page to show all results
                window.location.href = '{{ route("dashboard") }}';
                return;
            }
            
            performSearch(searchTerm);
        }, 300);
    });
    
    // Add clear button functionality
    const clearButton = document.getElementById('clear-search');
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            window.location.href = '{{ route("dashboard") }}';
        });
    }
    
    function performSearch(searchTerm) {
        spinner.classList.remove('hidden');
        
        // Use web route instead of API route
        window.location.href = `{{ route("dashboard") }}?search=${encodeURIComponent(searchTerm)}`;
    }
});
</script>