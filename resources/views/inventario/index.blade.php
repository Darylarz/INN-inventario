@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Inventario</h2>

        {{-- Botón de agregar artículo --}}
        @can('articulo modificar')
        <a href="{{ route('inventario.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            + Nuevo artículo
        </a>
        @endcan
    </div>

    {{-- Botón de agregar artículo --}}
        @can('articulo agregar')
        <a href="{{ route('inventario.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            + Nuevo artículo
        </a>
        @endcan
    </div>

    {{-- Resumen --}}
    @isset($totalUnits)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-sm text-gray-500 dark:text-gray-300">Unidades totales</div>
            <div class="text-4xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                {{ number_format((int) $totalUnits) }}
            </div>
        </div>

        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3">Unidades por categoría</div>
            <div class="flex flex-wrap gap-2">
                @forelse($totalsByType as $type => $sum)
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full
                        bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-200 text-sm">
                        {{ $type ?: 'Sin categoría' }}
                        <span class="px-2 py-0.5 rounded bg-indigo-100 dark:bg-indigo-800 text-xs font-semibold">
                            {{ (int) $sum }}
                        </span>
                    </span>
                @empty
                    <span class="text-sm text-gray-500 dark:text-gray-400">Sin datos</span>
                @endforelse
            </div>
        </div>
    </div>
    @endisset

    {{-- Alerta stock bajo --}}
    @if(($lowStockItems ?? collect())->count())
    <div class="rounded-xl border border-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-600 p-5 text-yellow-900 dark:text-yellow-100">
        <div class="font-semibold mb-2">
            Stock bajo en {{ $lowStockItems->count() }} artículo(s)
        </div>
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach($lowStockItems as $i)
                <li>
                    {{ $i->tipo_item ?? 'Artículo' }} —
                    {{ trim(($i->marca ?? '').' '.($i->modelo ?? '')) }}
                    ({{ (int)($i->cantidad ?? 0) }})
                    <a href="{{ route('inventario.show', $i->id) }}"
                       class="text-indigo-600 dark:text-indigo-300 underline ml-1">ver</a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Buscador --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <form action="{{ route('inventario.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <input type="hidden" name="page" value="1">

            <input type="text"
                   name="busqueda"
                   value="{{ $busqueda ?? request('busqueda') }}"
                   placeholder="Buscar artículos…"
                   class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100
                          focus:ring-indigo-500 focus:border-indigo-500">

            <button class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                Buscar
            </button>

            @if(filled(request('busqueda')))
            <a href="{{ route('inventario.index') }}"
               class="px-4 py-2 rounded-lg border text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                Limpiar
            </a>
            @endif
        </form>
    </div>

    @php
        $pageItems = $inventario->getCollection();
        $pcItems = $pageItems->filter(fn($i) => in_array($i->tipo_item, ['PC','Hardware']));
        $consumibleItems = $pageItems->filter(fn($i) => $i->tipo_item === 'Consumible');
        $herramientaItems = $pageItems->filter(fn($i) => $i->tipo_item === 'Herramienta');
    @endphp

    {{-- Tablas --}}
    @foreach([
        'PC / Hardware' => $pcItems,
        'Consumibles' => $consumibleItems,
        'Herramientas' => $herramientaItems
    ] as $title => $items)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Marca</th>
                        <th class="px-4 py-3 text-left">Modelo</th>
                        <th class="px-4 py-3 text-left">Reciclado</th>
                        <th class="px-4 py-3 text-left">Ingreso</th>
                        @can('usuario crear')
                        <th class="px-4 py-3 text-right">Acciones</th>
                        @endcan
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($items as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $item->nombre ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $item->marca ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $item->modelo ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $item->reciclado ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' 
                                : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                                {{ $item->reciclado ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        @can('usuario crear')
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('inventario.show', $item->uuid) }}"
                               class="text-indigo-600 dark:text-indigo-300 hover:underline">Detalle</a>
                            <a href="{{ route('inventario.edit', $item->uuid) }}"
                               class="text-blue-600 dark:text-blue-300 hover:underline">Editar</a>
                            <form action="{{ route('inventario.destroy', $item->uuid) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-300 hover:underline"
                                        onclick="return confirm('¿Estás seguro de que deseas desactivar este artículo?');">
                                    Desactivar
                                </button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500 dark:text-gray-400">Sin resultados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $inventario->links() }}
    </div>

</div>
@endsection
