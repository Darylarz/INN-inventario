@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Page Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard de Inventario</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Gestiona y busca en tu inventario de equipos y materiales.
                </p>
            </div>
            
            {{-- Mensajes de éxito/error --}}
            @if (session('status'))
                <div class="mb-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-md p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" id="inventory-container">
            
                {{-- Área de Búsqueda y Botón de Agregar --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div class="flex-1 max-w-md relative">
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
                        
                        <div class="flex space-x-3">
                            @can('articulo agregar')
                                <a href="{{ route('inventory.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Agregar Ítem
                                </a>
                            @endcan
                            
                            {{-- Stats Badge --}}
                            <div class="inline-flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ $inventories->total() }} ítems
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Tabla de Inventario --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
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
                
                {{-- Pagination --}}
                @if($inventories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $inventories->links() }}
                    </div>
                @endif
            </div>
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