@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-semibold mb-6">Crear artículo</h2>

    <form id="inventory-form" action="{{ route('inventario.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="tipo_item" class="block text-sm font-medium text-gray-700 mb-2">Tipo de artículo</label>
            <select id="tipo_item" name="tipo_item" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3">
                <option value="">-- seleccionar --</option>
                @php
                    $labels = ['PC','Hardware','Consumible','Herramienta'];
                @endphp
                @foreach($tipoInventario as $tipo)
                    <option value="{{ $tipo->nombre }}" {{ old('tipo_item') == $tipo->nombre ? 'selected' : '' }}>
                        {{ $labels[$tipo->nombre] ?? $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo_item') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <input type="hidden" id="hidden_tipo" name="tipo">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div id="campo-marca" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca (si aplica)</label>
                <input type="text" name="marca" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('marca') }}">
                @error('marca') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div id="campo-modelo" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo (si aplica)</label>
                <input type="text" name="modelo" class="block w-full rounded-md border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('modelo') }}">
                @error('modelo') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PC fields --}}
        <div id="campos_pc" class="hidden bg-gray-50 rounded p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('nombre') }}">
                    @error('nombre') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input id="reciclado" type="checkbox" name="reciclado" value="1" class="h-4 w-4 text-indigo-600" {{ old('reciclado') ? 'checked' : '' }}>
                    <label for="reciclado" class="text-sm text-gray-700">Reciclado</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Artículo ingresado por</label>
                    <input type="text" name="ingresado_por" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('ingresado_por') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('fecha_ingreso') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacidad</label>
                    <input type="text" name="capacidad" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('capacidad') }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <input type="text" name="tipo" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('tipo') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Generación</label>
                    <input type="text" name="generacion" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('generacion') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de serie</label>
                    <input type="text" name="numero_serial" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('numero_serial') }}">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bien nacional</label>
                <input type="text" name="bien_nacional" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('bien_nacional') }}">
            </div>
        </div>

        {{-- Consumible fields --}}
        <div id="campos_consumibles" class="hidden bg-gray-50 rounded p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('nombre') }}">
                    @error('nombre') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="flex items-center gap-3">
                    <input id="reciclado_consumible" type="checkbox" name="reciclado" value="1" class="h-4 w-4 text-indigo-600" {{ old('reciclado') ? 'checked' : '' }}>
                    <label for="reciclado_consumible" class="text-sm text-gray-700">Reciclado</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Artículo ingresado por</label>
                    <input type="text" name="ingresado_por" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('ingresado_por') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('fecha_ingreso') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" name="color" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('color') }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modelo de impresora</label>
                    <input type="text" name="modelo_impresora" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('modelo_impresora') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Material / Categoría</label>
                    <input type="text" name="tipo_material" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('tipo_material') }}">
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de serie</label>
                    <input type="text" name="numero_serial" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('numero_serial') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bien nacional</label>
                    <input type="text" name="bien_nacional" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('bien_nacional') }}">
                </div>
            </div>
        </div>

        {{-- Herramientas fields --}}
        <div id="campos_herramientas" class="hidden bg-gray-50 rounded p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre_herramienta" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('nombre_herramienta') }}">
                </div>
                <div class="flex items-center gap-3">
                    <input id="reciclado_herr" type="checkbox" name="reciclado" value="1" class="h-4 w-4 text-indigo-600" {{ old('reciclado') ? 'checked' : '' }}>
                    <label for="reciclado_herr" class="text-sm text-gray-700">Reciclado</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Artículo ingresado por</label>
                    <input type="text" name="ingresado_por" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('ingresado_por') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('fecha_ingreso') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo herramienta</label>
                    <input type="text" name="tipo_herramienta" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('tipo_herramienta') }}">
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de serie</label>
                    <input type="text" name="numero_serial" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('numero_serial') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bien nacional</label>
                    <input type="text" name="bien_nacional" class="block w-full rounded-md border-gray-300 py-2 px-3" value="{{ old('bien_nacional') }}">
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <button id="submit-btn" type="submit" class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear</button>
        </div>
    </form>
</div>

{{-- JS ligero para mostrar/ocultar campos --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('tipo_item');
    const hiddenTipo = document.getElementById('hidden_tipo');
    const marca = document.getElementById('campo-marca');
    const modelo = document.getElementById('campo-modelo');
    const campos_pc = document.getElementById('campos_pc');
    const campos_consumibles = document.getElementById('campos_consumibles');
    const campos_herramientas = document.getElementById('campos_herramientas');

    function setVisible(sectionEl, visible) {
        if (!sectionEl) return;
        if (visible) {
            sectionEl.classList.remove('hidden');
        } else {
            sectionEl.classList.add('hidden');
        }
        // Enable/disable inputs inside to avoid submitting hidden fields
        const controls = sectionEl.querySelectorAll('input, select, textarea');
        controls.forEach(el => { el.disabled = !visible; });
    }

    function updateFields() {
        const v = (sel.value || '').toLowerCase();
        // store selected type in hidden input for legacy usage
        if (hiddenTipo) hiddenTipo.value = sel.value || '';

        // hide everything first
        setVisible(marca, false);
        setVisible(modelo, false);
        setVisible(campos_pc, false);
        setVisible(campos_consumibles, false);
        setVisible(campos_herramientas, false);

        if (!v) return;

        // Show common fields
        setVisible(marca, true);
        setVisible(modelo, true);

        if (v === 'pc' || v === 'hardware') {
            setVisible(campos_pc, true);
        } else if (v === 'consumible') {
            setVisible(campos_consumibles, true);
        } else if (v === 'herramienta') {
            setVisible(campos_herramientas, true);
        }
    }

    sel.addEventListener('change', updateFields);

    // run on load in case old() exists
    updateFields();
});
</script>
@endsection
