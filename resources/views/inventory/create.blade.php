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
                @foreach($inventoryTypes as $type)
                    {{-- valor en lowercase para comparación consistente --}}
                    <option value="{{ strtolower($type->name) }}" {{ old('item_type') == strtolower($type->name) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('item_type') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

    <input type="hidden" id="hidden_type" name="type">


        {{-- Campos comunes (marca, modelo) --}}
        <div id="field-brand" class="mb-3" style="display: none;">
            <label>Marca</label>
            <input type="text" name="brand" class="w-full px-3 py-2 border rounded" value="{{ old('brand') }}">
            @error('brand') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div id="field-model" class="mb-3" style="display: none;">
            <label>Modelo</label>
            <input type="text" name="model" class="w-full px-3 py-2 border rounded" value="{{ old('model') }}">
            @error('model') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- PC only --}}
        <div id="pc-fields" style="display:none;">
            <div class="mb-3">
                <label>Capacidad</label>
                <input type="text" name="capacity" class="w-full px-3 py-2 border rounded" value="{{ old('capacity') }}">
            </div>

            <div class="mb-3">
                <label>Tipo</label>
                <input type="text" name="type" class="w-full px-3 py-2 border rounded" value="{{ old('type') }}">
            </div>

            <div class="mb-3">
                <label>Generación</label>
                <input type="text" name="generation" class="w-full px-3 py-2 border rounded" value="{{ old('generation') }}">
            </div>

            <div class="mb-3">
                <label>Número de serie</label>
                <input type="text" name="serial_number" class="w-full px-3 py-2 border rounded" value="{{ old('serial_number') }}">
            </div>

            <div class="mb-3">
                <label>Bien nacional</label>
                <input type="text" name="national_asset_tag" class="w-full px-3 py-2 border rounded" value="{{ old('national_asset_tag') }}">
            </div>
        </div>

        {{-- Consumable only --}}
        <div id="consumable-fields" style="display:none;">
            <div class="mb-3">
                <label>Color</label>
                <input type="text" name="color" class="w-full px-3 py-2 border rounded" value="{{ old('color') }}">
            </div>

            <div class="mb-3">
                <label>Modelo impresora</label>
                <input type="text" name="printer_model" class="w-full px-3 py-2 border rounded" value="{{ old('printer_model') }}">
            </div>

            <div class="mb-3">
                <label>Material / Categoría</label>
                <input type="text" name="material_type" class="w-full px-3 py-2 border rounded" value="{{ old('material_type') }}">
            </div>
        </div>

        {{-- Tool only --}}
        <div id="tool-fields" style="display:none;">
            <div class="mb-3">
                <label>Nombre herramienta</label>
                <input type="text" name="tool_name" class="w-full px-3 py-2 border rounded" value="{{ old('tool_name') }}">
            </div>

            <div class="mb-3">
                <label>Tipo herramienta</label>
                <input type="text" name="tool_type" class="w-full px-3 py-2 border rounded" value="{{ old('tool_type') }}">
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
    const consumableFields = document.getElementById('consumable-fields');
    const toolFields = document.getElementById('tool-fields');

    function updateFields() {
        const v = (sel.value || '').toLowerCase();
        // hide all by default
        brand.style.display = 'none';
        model.style.display = 'none';
        pcFields.style.display = 'none';
        consumableFields.style.display = 'none';
        toolFields.style.display = 'none';

        if (!v) return;

        // show common
        brand.style.display = '';
        model.style.display = '';

        if (v === 'pc' || v === 'hardware') {
            pcFields.style.display = '';
        } else if (v === 'consumable' || v === 'consumible') {
            consumableFields.style.display = '';
        } else if (v === 'tool' || v === 'herramienta') {
            toolFields.style.display = '';
        }
    }

    sel.addEventListener('change', updateFields);

    // run on load in case old() exists
    updateFields();
});
</script>
@endsection
