<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token CSRF (necesario para todas las peticiones POST/AJAX seguras en Laravel) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INN Inventario') }}</title>

    {{-- Carga de fuentes (opcional) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- 1. Directiva de Vite para cargar el CSS y JS principal (incluye Alpine/Axios) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        {{-- (Opcional) Aquí puedes incluir un componente de navegación para que aparezca en todas las páginas --}}
        {{-- <x-nav-bar /> --}}

        {{-- Contenido principal de la página --}}
        <main>
            {{-- 2. Directiva para inyectar el contenido de las vistas que extienden este layout --}}
            @yield('content')
        </main>
    </div>
</body>
</html>