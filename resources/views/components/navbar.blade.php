<nav class="bg-white shadow dark:bg-gray-800">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-gray-100">
      Inventario de Tecnología - INN
    </a>

    {{-- Menú (usando <details> para no depender de Alpine) --}}
    <details class="relative">
      <summary class="cursor-pointer flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
        <span class="text-gray-800 dark:text-gray-200 text-sm">{{ auth()->user()->name }}</span>
        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </summary>

      <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50">
        {{-- Inventario (muestra si tiene permiso 'usuario crear' o puedes cambiarlo) --}}
        @can('usuario crear')
          <a href="{{ route('inventory.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Inventario</a>
          <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Reportes</a>
        @endcan

        @can('usuario crear')  
          <a href="{{ route('inventory.disabled') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Desincorporados</a>
      @endcan

        {{-- Usuarios (solo quienes tengan permiso 'usuario crear') --}}
        @can('usuario crear')
          <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Usuarios</a>
        @endcan

        {{-- Crear artículo (si tiene permiso 'articulo crear') --}}
        @can('articulo crear')
          <a href="{{ route('inventory.create') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Crear artículo</a>
        @endcan

        <div class="border-t border-gray-200 dark:border-gray-700 mt-2"></div>

        <form method="POST" action="{{ url('/logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">Cerrar sesión</button>
        </form>
      </div>
    </details>

  </div>
</nav>


