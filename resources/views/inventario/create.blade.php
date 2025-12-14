@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Crear artículo</h2>

    <form id="inventory-form" action="{{ route('inventario.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="font-semibold">Tipo de artículo</label>
            <select id="tipo_item" name="tipo_item" class="w-full px-3 py-2 border rounded">
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


        {{-- Campos comunes (marca, modelo) --}}
        <div id="campo-marca" class="mb-3" style="display: none;">
            <label>Marca (si aplica)</label>
            <input type="text" name="marca" class="w-full px-3 py-2 border rounded" value="{{ old('marca') }}">
            @error('marca') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div id="campo-modelo" class="mb-3" style="display: none;">
            <label>Modelo (si aplica)</label>
            <input type="text" name="modelo" class="w-full px-3 py-2 border rounded" value="{{ old('modelo') }}">
            @error('modelo') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- PC only --}}
        <div id="campos_pc" style="display:none;">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="w-full px-3 py-2 border rounded" value="{{ old('nombre') }}">
                @error('nombre') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror

            <div class="mb-3 flex items-center gap-2">
                <input id="reciclado" type="checkbox" name="reciclado" value="1" {{ old('reciclado') ? 'checked' : '' }}>
                <label for="reciclado" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="ingresado_por" class="w-full px-3 py-2 border rounded" value="{{ old('ingresado_por') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border rounded" value="{{ old('fecha_ingreso') }}">
            </div>

            </div>

            <div class="mb-3">
                <label>Capacidad (si aplica)</label>
                <input type="text" name="capacidad" class="w-full px-3 py-2 border rounded" value="{{ old('capacidad') }}">
            </div>

            <div class="mb-3">
                <label>Tipo (si aplica)</label>
                <input type="text" name="tipo" class="w-full px-3 py-2 border rounded" value="{{ old('tipo') }}">
            </div>

            <div class="mb-3">
                <label>Generación (si aplica)</label>
                <input type="text" name="generacion" class="w-full px-3 py-2 border rounded" value="{{ old('generacion') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="numero_serial" class="w-full px-3 py-2 border rounded" value="{{ old('numero_serial') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="bien_nacional" class="w-full px-3 py-2 border rounded" value="{{ old('bien_nacional') }}">
            </div>
        </div>

        {{-- Consumible only --}}
        <div id="campos_consumibles" style="display:none;">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="w-full px-3 py-2 border rounded" value="{{ old('nombre') }}">
                @error('nombre') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            <div class="mb-3 flex items-center gap-2">
                <input id="reciclado" type="checkbox" name="reciclado" value="1" {{ old('reciclado') ? 'checked' : '' }}>
                <label for="reciclado" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="ingresado_por" class="w-full px-3 py-2 border rounded" value="{{ old('ingresado_por') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border rounded" value="{{ old('fecha_ingreso') }}">
            </div>
            </div>

            <div class="mb-3">
                <label>Color</label>
                <input type="text" name="color" class="w-full px-3 py-2 border rounded" value="{{ old('color') }}">
            </div>

            <div class="mb-3">
                <label>Modelo de impresora (si aplica)</label>
                <input type="text" name="modelo_impresora" class="w-full px-3 py-2 border rounded" value="{{ old('modelo_impresora') }}">
            </div>

            <div class="mb-3">
                <label>Material / Categoría (si aplica)</label>
                <input type="text" name="tipo_material" class="w-full px-3 py-2 border rounded" value="{{ old('tipo_material') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="numero_serial" class="w-full px-3 py-2 border rounded" value="{{ old('numero_serial') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="bien_nacional" class="w-full px-3 py-2 border rounded" value="{{ old('bien_nacional') }}">
            </div>
        </div>

        {{-- Tool only --}}
        <div id="campos_herramientas" style="display:none;">

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre_herramienta" class="w-full px-3 py-2 border rounded" value="{{ old('nombre_herramienta') }}">
            </div>
            <div class="mb-3 flex items-center gap-2">
                <input id="reciclado" type="checkbox" name="reciclado" value="1" {{ old('reciclado') ? 'checked' : '' }}>
                <label for="reciclado" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="ingresado_por" class="w-full px-3 py-2 border rounded" value="{{ old('ingresado_por') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border rounded" value="{{ old('fecha_ingreso') }}">
            </div>



            <div class="mb-3">
                <label>Tipo herramienta (si aplica)</label>
                <input type="text" name="tipo_herramienta" class="w-full px-3 py-2 border rounded" value="{{ old('tipo_herramienta') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="numero_serial" class="w-full px-3 py-2 border rounded" value="{{ old('numero_serial') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="bien_nacional" class="w-full px-3 py-2 border rounded" value="{{ old('bien_nacional') }}">
            </div>
        </div>

        <div class="mt-4">
            <button id="submit-btn" type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Crear</button>
        </div>
    </form>
</div>

{{-- JS ligero para mostrar/ocultar campos --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('tipo_item');
    const marca = document.getElementById('campo-marca');
    const modelo = document.getElementById('campo-modelo');
    const campos_pc = document.getElementById('campos_pc');
    const campos_consumibles = document.getElementById('campos_consumibles');
    const campos_herramientas = document.getElementById('campos_herramientas');

    function setVisible(sectionEl, visible) {
        sectionEl.style.display = visible ? '' : 'none';
        // Habilitar/deshabilitar campos internos para evitar que los ocultos se envíen
        const controls = sectionEl.querySelectorAll('input, select, textarea');
        controls.forEach(el => { el.disabled = !visible; });
    }

    function updateFields() {
        const v = (sel.value || '').toLowerCase();
        // Ocultar y deshabilitar todos por defecto
        setVisible(marca, false);
        setVisible(modelo, false);
        setVisible(campos_pc, false);
        setVisible(campos_consumibles, false);
        setVisible(campos_herramientas, false);

        if (!v) return;

        // Mostrar comunes
        setVisible(marca, true);
        setVisible(modelo, true);

        if (v === 'pc' || v === 'hardware') {
            setVisible(campos_pc, true);
        } else if (v === 'consumible' || v === 'consumible') {
            setVisible(campos_consumibles, true);
        } else if (v === 'herramienta' || v === 'herramienta') {
            setVisible(campos_herramientas, true);
        }
    }

    sel.addEventListener('change', updateFields);

    // run on load in case old() exists
    updateFields();
});
</script>
@endsection
