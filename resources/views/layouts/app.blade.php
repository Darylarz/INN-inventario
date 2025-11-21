<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>INN Inventario</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="antialiased">
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @auth
      @include('components.navbar')
    @endauth

    <main class="container mx-auto py-6 px-4">
      @yield('content')
    </main>
  </div>

  @livewireScripts
</body>
</html>