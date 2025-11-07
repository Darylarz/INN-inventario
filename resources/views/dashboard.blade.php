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

            {{-- Área de Búsqueda --}}
            <div class="mb-4 flex justify-between items-center">
                <input 
                    x-model.debounce.500ms="search" 
                    @input="loadArticles(1)" 
                    type="text" 
                    placeholder="Buscar por Nombre o SKU..." 
                    class="p-2 border border-gray-300 rounded-lg w-1/3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                
               
               {{-- Botón para agregar --}}
    @can('articulo agregar')
        <a 
            href="{{ route('inventory.create') }}" 
            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
        >
            + Agregar Nuevo Ítem
        </a>
    @endcan
    
    {{-- ... Tabla de Artículos ... --}}
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
            <template x-for="item in articles" :key="item.id">
                <tr>
                    <td x-text="item.brand || '-'" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"></td>
                    <td x-text="item.model || item.item_type" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                    <td x-text="item.type" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                    <td x-text="item.national_asset_tag || '-'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                    <td x-text="item.serial_number || '-'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"></td>
                    {{-- ... Acciones (Modificar/Eliminar) ... --}}
                </tr>
            </template>
            </tbody>
    </table>
                <tr x-show="!loading && articles.length === 0">
                        <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">
                            No se encontraron artículos.
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Paginación (Mostrada solo si hay más de una página) --}}
            <div x-show="pagination.last_page > 1" class="mt-4 flex justify-between items-center">
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

                    {{-- Este bucle simple maneja la paginación básica, podrías mejorarlo con un bucle x-for si necesitas más control visual --}}
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

{{-- 3. Código Javascript/Alpine.js para la interactividad --}}
<script>
    function inventoryTable() {
        return {
            articles: [],
            pagination: {},
            search: '',
            loading: true,

            async loadArticles(page = 1) {
                this.loading = true;
                
                // Construir la URL con parámetros de búsqueda y paginación
                // ... dentro de loadArticles(page)
                    const url = `/api/inventory?page=${page}&search=${this.search}`;
// ...

                try {
                    // Usamos Axios (cargado en app.js) para la petición
                    const response = await axios.get(url);
                    
                    // Laravel Paginate devuelve los datos en la propiedad 'data'
                    this.articles = response.data.data; 

                    // Copiar la información de paginación
                    // Excluimos 'data' para evitar un bucle
                    const { data, ...paginationData } = response.data;
                    this.pagination = paginationData;

                } catch (error) {
                    console.error("Error al cargar artículos:", error);
                    // Aquí podrías mostrar una notificación de error en la UI
                    this.articles = [];
                    this.pagination = {};
                } finally {
                    this.loading = false;
                }
            },
        }
    }
</script>