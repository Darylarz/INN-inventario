@extends('layouts.app')

@section('content')
    {{-- Contenido Principal --}}
    <div class="flex-grow p-10 overflow-y-auto">
        <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Inventario de Artículos</h2>

        {{-- Componente ALPINE.JS para la tabla --}}
        <div 
            x-data="inventoryTable()" 
            x-init="loadArticles(1)" 
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl"
        >
            
            {{-- Loader (Opcional) --}}
            <div x-show="loading" class="text-center p-4 text-gray-500 dark:text-gray-400">
                Cargando inventario...
            </div>

            {{-- Área de Búsqueda y Botón de Agregar --}}
            <div x-show="!loading" class="mb-4 flex justify-between items-center">
                <input 
                    x-model.debounce.500ms="search" 
                    @input="loadArticles(1)" 
                    type="text" 
                    placeholder="Buscar por Marca, Modelo o Serial..." 
                    class="p-2 border border-gray-300 rounded-lg w-1/3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                
                {{-- Botón para agregar --}}
                @can('articulo agregar')
                    <a 
                        href="{{ route('inventory.create') }}" 
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-white"
                    >
                        + Agregar Nuevo Ítem
                    </a>
                @endcan
            </div>
    
            {{-- TABLA DE ARTÍCULOS --}}
            <table x-show="!loading" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
                    
                    {{-- Bucle para mostrar los artículos --}}
                    <template x-for="item in articles" :key="item.id">
                        <tr>
                            <td x-text="item.brand || '-'" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"></td>
                            <td x-text="item.model || item.item_type || item.printer_model" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                            <td x-text="item.type" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                            <td x-text="item.national_asset_tag || '-'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                            <td x-text="item.serial_number || '-'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                            
                            {{-- Columna de Acciones (Debe estar DENTRO del bucle) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                @can('articulo modificar')
                                    <a :href="`{{ url('/inventory') }}/${item.id}/edit`" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                        Editar
                                    </a>
                                @endcan

                                @can('articulo eliminar')
                                    {{-- Formulario de Eliminación --}}
                                    <form :action="`{{ url('/inventory') }}/${item.id}`" method="POST" class="inline" 
                                          @submit.prevent="confirm('¿Estás seguro de que deseas eliminar este ítem? Esta acción es irreversible.') ? $el.submit() : null">
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 focus:outline-none">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan    
                            </td>
                        </tr>
                    </template>
                    
                    {{-- Mensaje de No Hay Resultados --}}
                    <tr x-show="!loading && articles.length === 0">
                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">
                            No se encontraron ítems de inventario.
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Paginación (Mostrada solo si hay más de una página) --}}
            <div x-show="!loading && pagination.last_page > 1" class="mt-4 flex justify-between items-center">
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Mostrando <span x-text="pagination.from"></span> a <span x-text="pagination.to"></span> de <span x-text="pagination.total"></span> resultados.
                </span>

                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button 
                        @click="loadArticles(pagination.current_page - 1)" 
                        :disabled="pagination.current_page === 1"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 disabled:opacity-50"
                    >
                        Anterior
                    </button>

                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-indigo-500 text-sm font-medium text-white dark:bg-indigo-600 dark:border-indigo-600">
                        <span x-text="pagination.current_page"></span>
                    </span>
                    
                    <button 
                        @click="loadArticles(pagination.current_page + 1)" 
                        :disabled="pagination.current_page === pagination.last_page"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 disabled:opacity-50"
                    >
                        Siguiente
                    </button>
                </nav>
            </div>
            
        </div>
        
    </div>
@endsection

{{-- Código Javascript/Alpine.js (Sin cambios) --}}
<script>
    function inventoryTable() {
        return {
            articles: [],
            pagination: {},
            search: '',
            loading: true,

            async loadArticles(page = 1) {
                this.loading = true;
                
                const url = `/api/inventory?page=${page}&search=${this.search}`;

                try {
                    const response = await axios.get(url);
                    
                    this.articles = response.data.data; 

                    const { data, ...paginationData } = response.data;
                    this.pagination = paginationData;

                } catch (error) {
                    console.error("Error al cargar artículos:", error);
                    // Si el error es 401/403 (No autenticado), podría redirigir
                    this.articles = [];
                    this.pagination = {};
                } finally {
                    this.loading = false;
                }
            },
        }
    }
</script>