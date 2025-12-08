<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>INN Inventario</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
  <div class="min-h-screen flex flex-col">
    @auth
      @include('components.navbar')
      <div class="flex flex-1 pt-20">
        @include('components.sidebar')
        <main class="flex-1 p-4 overflow-auto">
          @yield('content')
        </main>
      </div>
    @else
      <main class="flex-1">
        @yield('content')
      </main>
      
    @endauth
  </div>

  @livewireScripts
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebar-toggle');
      const mainContent = document.querySelector('main');
      const sidebarMobile = window.matchMedia('(max-width: 768px)');

      // Función para alternar la barra lateral
      function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        mainContent.classList.toggle('md:ml-64');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('-translate-x-full'));
      }

      // Manejar el clic en el botón de alternar
      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
      }

      // Manejar el cambio de tamaño de la ventana
      function handleSidebarOnResize() {
        if (sidebarMobile.matches) {
          sidebar.classList.add('-translate-x-full');
          mainContent.classList.remove('md:ml-64');
        } else {
          const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
          if (!isCollapsed) {
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('md:ml-64');
          }
        }
      }

      // Inicializar
      handleSidebarOnResize();
      window.addEventListener('resize', handleSidebarOnResize);

      // Inicializar estado desde localStorage
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        sidebar.classList.add('-translate-x-full');
        mainContent.classList.remove('md:ml-64');
      } else {
        sidebar.classList.remove('-translate-x-full');
        mainContent.classList.add('md:ml-64');
      }

      // Toggle del menú de usuario (admin) sin librerías
      const userMenuBtn = document.getElementById('user-menu-button');
      const userDropdown = document.getElementById('user-dropdown');
      if (userMenuBtn && userDropdown) {
        // Asegurar estado inicial oculto
        if (!userDropdown.classList.contains('hidden')) {
          userDropdown.classList.add('hidden');
        }

        const toggleUserMenu = (e) => {
          e.stopPropagation();
          const isHidden = userDropdown.classList.contains('hidden');
          userDropdown.classList.toggle('hidden');
          userMenuBtn.setAttribute('aria-expanded', String(isHidden));
        };

        userMenuBtn.addEventListener('click', toggleUserMenu);

        // Cerrar al hacer clic fuera
        document.addEventListener('click', (e) => {
          if (!userDropdown.classList.contains('hidden')) {
            const clickedInsideMenu = userDropdown.contains(e.target);
            const clickedButton = userMenuBtn.contains(e.target);
            if (!clickedInsideMenu && !clickedButton) {
              userDropdown.classList.add('hidden');
              userMenuBtn.setAttribute('aria-expanded', 'false');
            }
          }
        });

        // Cerrar con Escape
        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && !userDropdown.classList.contains('hidden')) {
            userDropdown.classList.add('hidden');
            userMenuBtn.setAttribute('aria-expanded', 'false');
          }
        });
      }
    });
  </script>
</body>
</html>
