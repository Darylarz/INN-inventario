@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Crear artículo</h2>

    <form id="inventory-form" action="{{ route('inventory.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="font-semibold">Tipo de artículo</label>
            <select id="item_type" name="item_type" class="w-full px-3 py-2 border rounded">
                <option value="">-- seleccionar --</option>
                @php
                    $labels = ['PC'=>'PC','Hardware'=>'Hardware','Consumible'=>'Consumible','Herramienta'=>'Herramienta'];
                @endphp
                @foreach($tipoInventario as $type)
                    <option value="{{ $type->name }}" {{ old('item_type') == $type->name ? 'selected' : '' }}>
                        {{ $labels[$type->name] ?? $type->name }}
                    </option>
                @endforeach
            </select>
            @error('item_type') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

    <input type="hidden" id="hidden_type" name="type">


        {{-- Campos comunes (marca, modelo) --}}
        <div id="field-brand" class="mb-3" style="display: none;">
            <label>Marca (si aplica)</label>
            <input type="text" name="brand" class="w-full px-3 py-2 border rounded" value="{{ old('brand') }}">
            @error('brand') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div id="field-model" class="mb-3" style="display: none;">
            <label>Modelo (si aplica)</label>
            <input type="text" name="model" class="w-full px-3 py-2 border rounded" value="{{ old('model') }}">
            @error('model') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- PC only --}}
        <div id="pc-fields" style="display:none;">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="w-full px-3 py-2 border rounded" value="{{ old('name') }}">
                @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror

            <div class="mb-3 flex items-center gap-2">
                <input id="recycled" type="checkbox" name="recycled" value="1" {{ old('recycled') ? 'checked' : '' }}>
                <label for="recycled" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="entered_by" class="w-full px-3 py-2 border rounded" value="{{ old('entered_by') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="entry_date" class="w-full px-3 py-2 border rounded" value="{{ old('entry_date') }}">
            </div>

            </div>

            <div class="mb-3">
                <label>Capacidad (si aplica)</label>
                <input type="text" name="capacity" class="w-full px-3 py-2 border rounded" value="{{ old('capacity') }}">
            </div>

            <div class="mb-3">
                <label>Tipo (si aplica)</label>
                <input type="text" name="type" class="w-full px-3 py-2 border rounded" value="{{ old('type') }}">
            </div>

            <div class="mb-3">
                <label>Generación (si aplica)</label>
                <input type="text" name="generation" class="w-full px-3 py-2 border rounded" value="{{ old('generation') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ old('serial_number') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ old('national_asset_tag') }}">
            </div>
        </div>

        {{-- Consumible only --}}
        <div id="consumible-fields" style="display:none;">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="w-full px-3 py-2 border rounded" value="{{ old('name') }}">
                @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            <div class="mb-3 flex items-center gap-2">
                <input id="recycled" type="checkbox" name="recycled" value="1" {{ old('recycled') ? 'checked' : '' }}>
                <label for="recycled" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="entered_by" class="w-full px-3 py-2 border rounded" value="{{ old('entered_by') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="entry_date" class="w-full px-3 py-2 border rounded" value="{{ old('entry_date') }}">
            </div>
            </div>

            <div class="mb-3">
                <label>Color</label>
                <input type="text" name="color" class="w-full px-3 py-2 border rounded" value="{{ old('color') }}">
            </div>

            <div class="mb-3">
                <label>Modelo de impresora (si aplica)</label>
                <input type="text" name="printer_model" class="w-full px-3 py-2 border rounded" value="{{ old('printer_model') }}">
            </div>

            <div class="mb-3">
                <label>Material / Categoría (si aplica)</label>
                <input type="text" name="material_type" class="w-full px-3 py-2 border rounded" value="{{ old('material_type') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ old('serial_number') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ old('national_asset_tag') }}">
            </div>
        </div>

        {{-- Tool only --}}
        <div id="herramienta-fields" style="display:none;">

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="tool_name" class="w-full px-3 py-2 border rounded" value="{{ old('tool_name') }}">
            </div>
            <div class="mb-3 flex items-center gap-2">
                <input id="recycled" type="checkbox" name="recycled" value="1" {{ old('recycled') ? 'checked' : '' }}>
                <label for="recycled" class="select-none">Reciclado</label>
            </div>

            <div class="mb-3">
                <label>Artículo ingresado por</label>
                <input type="text" name="entered_by" class="w-full px-3 py-2 border rounded" value="{{ old('entered_by') }}">
            </div>

            <div class="mb-3">
                <label>Fecha de ingreso</label>
                <input type="date" name="entry_date" class="w-full px-3 py-2 border rounded" value="{{ old('entry_date') }}">
            </div>



            <div class="mb-3">
                <label>Tipo herramienta (si aplica)</label>
                <input type="text" name="tool_type" class="w-full px-3 py-2 border rounded" value="{{ old('tool_type') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie (si aplica)</label>
                <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ old('serial_number') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional (si aplica)</label>
                <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ old('national_asset_tag') }}">
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
    const sel = document.getElementById('item_type');
    const brand = document.getElementById('field-brand');
    const model = document.getElementById('field-model');
    const pcFields = document.getElementById('pc-fields');
    const consumibleFields = document.getElementById('consumible-fields');
    const herramientaFields = document.getElementById('herramienta-fields');

    function updateFields() {
        const v = (sel.value || '').toLowerCase();
        // hide all by default
        brand.style.display = 'none';
        model.style.display = 'none';
        pcFields.style.display = 'none';
        consumibleFields.style.display = 'none';
        herramientaFields.style.display = 'none';

        if (!v) return;

        // show common
        brand.style.display = '';
        model.style.display = '';

        if (v === 'pc' || v === 'hardware') {
            pcFields.style.display = '';
        } else if (v === 'consumible' || v === 'consumible') {
            consumibleFields.style.display = '';
        } else if (v === 'herramienta' || v === 'herramienta') {
            herramientaFields.style.display = '';
        }
    }

    sel.addEventListener('change', updateFields);

    // run on load in case old() exists
    updateFields();
});
</script>
@endsection
