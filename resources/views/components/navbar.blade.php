<nav class="bg-white shadow dark:bg-gray-800">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-gray-100">
            INN Inventario
        </a>

        {{-- Menú desplegable --}}
        <div class="relative" x-data="{ open: false }">

            {{-- Botón del menú --}}
            <button @click="open = !open"
                class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-blue-500 transition">
                <span>{{ Auth::user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg rounded-md z-50 py-2">

                {{-- Inventario (siempre para usuarios con permiso) --}}
                @can('usuario crear')
                <a href="{{ route('inventory.index') }}"
                   class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    Inventario
                </a>
                @endcan

                {{-- Usuarios (solo admins o quienes tengan permiso "usuario crear") --}}
                @can('usuario crear')
                <a href="{{ route('admin.users') }}"
                   class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    Usuarios
                </a>
                @endcan

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


