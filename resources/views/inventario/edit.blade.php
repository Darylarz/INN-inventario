@extends('layouts.app')



@section('content')


<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-8">
             Editar artículo
        </h2>


        {{-- Mensaje de éxito --}}
@if(session('success'))
<div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-800 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-100 flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

{{-- Mensaje de error general --}}
@if($errors->any())
<div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-800 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-100">
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


        <form action="{{ route('inventario.update', $inventario->uuid) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Tipo de artículo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tipo de artículo
                    </label>
                    <select name="tipo_item"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- seleccionar --</option>
                        @foreach($tipoInventario as $tipo)
                            <option value="{{ $tipo->nombre }}"
                                {{ $inventario->tipo_item == $tipo->nombre ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nombre
                    </label>
                    <input type="text" name="name"
                        value="{{ $inventario->name }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Marca --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Marca (si aplica)
                    </label>
                    <input type="text" name="marca"
                        value="{{ $inventario->marca }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Modelo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Modelo (si aplica)
                    </label>
                    <input type="text" name="modelo"
                        value="{{ $inventario->modelo }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Capacidad --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Capacidad (si aplica)
                    </label>
                    <input type="text" name="capacidad"
                        value="{{ $inventario->capacidad }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tipo (si aplica)
                    </label>
                    <input type="text" name="tipo"
                        value="{{ $inventario->tipo }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Generación --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Generación (si aplica)
                    </label>
                    <input type="text" name="generacion"
                        value="{{ $inventario->generacion }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Número de serie --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Número de serie (si aplica)
                    </label>
                    <input type="text" name="numero_serial"
                        value="{{ $inventario->numero_serial }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Bien nacional --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Bien nacional (si aplica)
                    </label>
                    <input type="text" name="bien_nacional"
                        value="{{ $inventario->bien_nacional }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Ingresado por --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Artículo ingresado por
                    </label>
                    <input type="text" name="ingresado_por"
                        value="{{ $inventario->ingresado_por }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100
                               focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Fecha --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de ingreso
                    </label>
                    <label for=""> {{ $inventario->created_at->format('Y-m-d') }}</label>
                </div>
            </div>

            {{-- Checkbox --}}
            <div class="flex items-center gap-3 mt-4">
                <input id="reciclado" type="checkbox" name="reciclado" value="1"
                    {{ $inventario->reciclado ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="reciclado" class="text-sm text-gray-700 dark:text-gray-300 select-none">
                    Artículo reciclado
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('inventario.index') }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    Cancelar
                </a>

                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-indigo-600 text-white font-semibold
                           hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
