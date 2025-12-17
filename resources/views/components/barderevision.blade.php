<aside class="w-64" aria-label="Sidebar">
    <div class="px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2">

            <!-- Inicio --> 
            <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleMenu('inicioMenu')">
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Inicio</span>
                    <svg class="w-5 h-5" fill="currentColor"><path d="M5 8l5 5 5-5H5z"/></svg>
                </button>
                <ul id="inicioMenu" class="hidden pl-6 space-y-2">
                    <li><a href="{{ route('productos.index') }}" class="block p-2 hover:bg-gray-200 rounded">Productos</a></li>
                </ul>
            </li> 
            
            
            <!-- Ubicaciones (solo admin) -->
            @can('usuario crear')
            <li>
                <a href="{{ route('ubicaciones.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Ubicaciones</span>
                </a>  
            </li>
            @endcan

            <!-- Inventario -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleMenu('inventarioMenu')">
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Inventario</span>
                    <svg class="w-5 h-5" fill="currentColor"><path d="M5 8l5 5 5-5H5z"/></svg>
                </button>
                <ul id="inventarioMenu" class="hidden pl-6 space-y-2">
                    <li><a href="{{ route('inventario.create') }}" class="block p-2 hover:bg-gray-200 rounded">Añadir artículo</a></li>
                    <li><a href="{{ route('inventario.index') }}" class="block p-2 hover:bg-gray-200 rounded">Consultar artículo</a></li>
                    @can('usuario crear')
                        <li><a href="{{ route('inventario.edit') }}" class="block p-2 hover:bg-gray-200 rounded">Modificar artículo</a></li>
                        <li><a href="{{ route('inventario.disabled') }}" class="block p-2 hover:bg-gray-200 rounded">Desincorporar artículo</a></li>
                    @endcan
                </ul>
            </li>

            <!-- Categorías -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleMenu('categoriasMenu')">
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Categorías</span>
                    <svg class="w-5 h-5" fill="currentColor"><path d="M5 8l5 5 5-5H5z"/></svg>
                </button>
                <ul id="categoriasMenu" class="hidden pl-6 space-y-2">
                    <li><a href="{{ route('categorias.pc') }}" class="block p-2 hover:bg-gray-200 rounded">PC</a></li>
                    <li><a href="{{ route('categorias.consumibles') }}" class="block p-2 hover:bg-gray-200 rounded">Consumibles</a></li>
                    <li><a href="{{ route('categorias.herramientas') }}" class="block p-2 hover:bg-gray-200 rounded">Herramientas</a></li>
                </ul>
            </li>

            <!-- Reportes -->
            @can('articulo agregar')
            <li>
                <button type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleMenu('reportesMenu')">
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Reportes</span>
                    <svg class="w-5 h-5" fill="currentColor"><path d="M5 8l5 5 5-5H5z"/></svg>
                </button>
                <ul id="reportesMenu" class="hidden pl-6 space-y-2">
                    <li><a href="{{ route('reportes.activos') }}" class="block p-2 hover:bg-gray-200 rounded">Reportes de Activos</a></li>
                    <li><a href="{{ route('reportes.desincorporados') }}" class="block p-2 hover:bg-gray-200 rounded">Reportes de Desincorporados</a></li>
                </ul>
            </li>
            @endcan

            <!-- Usuarios (solo admin) -->
            @can('usuario crear')
            <li>
                <a href="{{ route('admin.users') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
                </a>
            </li>
            @endcan

            

        </ul>
    </div>
</aside>

<!-- Script para desplegar -->
<script>
    function toggleMenu(menuId) {
        const menu = document.getElementById(menuId);
        menu.classList.toggle('hidden');
    }
</script>
