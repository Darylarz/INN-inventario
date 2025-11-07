@extends('layout/Ilayout')
desde indice de inventario

@section('content')

<div 
    x-data="inventoryTable()" 
    x-init="loadArticles(1)" 
    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl"
>

    {{-- 1. EL BUSCADOR --}}
    <div class="mb-4 flex justify-between items-center">
        <input 
            x-model.debounce.500ms="search" 
            @input="loadArticles(1)" 
            type="text" 
            placeholder="Buscar por Nombre o SKU..." 
            class="p-2 border border-gray-300 rounded-lg w-1/3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        >
        
        {{-- 2. EL BOTÓN AGREGAR ARTÍCULO --}}
        @can('articulo agregar')
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                + Agregar Artículo
            </button> 
        @endcan
    </div>
    
    {{-- 3. LA TABLA DE ARTÍCULOS --}}
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        {{-- ... Encabezados de la tabla y contenido dinámico ... --}}
    </table>

    {{-- Paginación... --}}
</div>

        @endsection
