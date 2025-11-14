<nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <div class="flex items-center space-x-4">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900 dark:text-white">INN Inventario</a>
        
        <!-- Botón rápido Crear (visible cuando hay sesión) -->
        @can('articulo crear')<a href="{{ route('inventario-create') }}"
           class="hidden sm:inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700">
          Crear
        </a>@endcan
      </div>

      <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-700 dark:text-gray-300 hidden sm:inline">{{ auth()->user()->name ?? '' }}</span>

        <form method="POST" action="{{ url('/logout') }}">
          @csrf
          <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
            Cerrar sesión
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>