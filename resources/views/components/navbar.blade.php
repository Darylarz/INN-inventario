<nav class="fixed top-0 left-0 z-50 w-full bg-white border-b border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-700">
  <div class="px-4 py-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <!-- Mobile menu button -->
        <button id="sidebar-toggle" type="button" 
                class="inline-flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
          <span class="sr-only">Abrir menú</span>
         <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
           <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
         </svg>
        </button>

<a href="{{ route('dashboard') }}" class="flex items-center ml-3">
    <img src="{{ asset('images/inn-logo.png') }}" alt="Logo" 
         class="h-12 w-12 object-contain mr-3 rounded-full"> 


        <a href="{{ route('dashboard') }}" class="flex items-center ml-3">
          <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Inventario de Tecnología - INN</span>
        </a>
      </div>
      
      <!-- Right side menu items -->
      <div class="flex items-center">
        <div class="flex items-center ml-3">
          <div class="relative">
            <button type="button" class="flex items-center text-sm bg-green-800 rounded-full focus:ring-4 focus:ring-green-300 dark:focus:ring-green-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
              <span class="sr-only">Abrir menú de usuario</span>
              <span class="mr-2 text-white">{{ auth()->user()->name }}</span>
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div class="hidden absolute right-0 mt-2 w-56 z-50 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
              <div class="py-3 px-4">
                <span class="block text-sm text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
              </div>
              <ul class="py-1" aria-labelledby="user-menu-button">
                <li>
                  <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 px-4 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-400 dark:hover:text-white">Cerrar sesión</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>