@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Reportes de Inventario</h2>
        <a href="{{ route('inventario.index') }}" 
           class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 dark:text-gray-100 border rounded hover:bg-gray-200 dark:hover:bg-gray-600">
            Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <form action="{{ route('reportes.pdf') }}" method="POST" target="_blank" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Estado</label>
                <select name="status" 
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="todo">Todos</option>
                    <option value="activo">Activos</option>
                    <option value="desactivado">Desincorporados</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Tipo</label>
                <select name="tipo_item" 
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    @foreach($tiposItems as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Desde</label>
                <input type="date" name="from" 
                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Hasta</label>
                <input type="date" name="to" 
                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button class="px-5 py-2 bg-green-100 text-green-800 rounded-md hover:bg-green-200">
                    Generar PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
