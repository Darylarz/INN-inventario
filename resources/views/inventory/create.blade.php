@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.sidebar') 

        <div class="flex-grow p-10 overflow-y-auto" 
             x-data="{ itemType: 'activo' }"> {{-- <--- Inicializa Alpine para manejar el tipo --}}
            
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Crear Nuevo Ítem de Inventario</h2>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-2xl mx-auto">
                
                <form method="POST" action="{{ route('inventory.store') }}" class="space-y-6">
                    @csrf
                    
                    {{-- 1. Selector de Tipo de Ítem --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Inventario</label>
                        <select 
                            x-model="itemType" 
                            name="type" 
                            id="type" 
                            required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                            <option value="activo">Activo Fijo (PC, Hardware)</option>
                            <option value="herramienta">Herramienta</option>
                            <option value="consumible_toner">Consumible (Tóner)</option>
                            <option value="consumible_material">Consumible (Otros Materiales)</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <hr class="dark:border-gray-700">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- 2. CAMPOS COMUNES --}}
                        
                        {{-- Marca (Activo/Toner) --}}
                        <div x-show="itemType !== 'herramienta' && itemType !== 'consumible_material'">
                            <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('brand') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Modelo (Activo/Toner) --}}
                        <div x-show="itemType !== 'herramienta' && itemType !== 'consumible_material'">
                            <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modelo</label>
                            <input type="text" name="model" id="model" value="{{ old('model') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('model') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tipo de Ítem (Todos excepto Tóner) --}}
                        <div x-show="itemType !== 'consumible_toner'">
                            <label for="item_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300" x-text="itemType === 'herramienta' ? 'Nombre de Herramienta' : (itemType === 'activo' ? 'Tipo de Componente' : 'Tipo de Material')"></label>
                            <input type="text" name="item_type" id="item_type" value="{{ old('item_type') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('item_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- 3. CAMPOS ESPECÍFICOS DE ACTIVO --}}
                        
                        <div x-show="itemType === 'activo'">
                            <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacidad (ej: 500GB, 8GB)</label>
                            <input type="text" name="capacity" id="capacity" value="{{ old('capacity') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div x-show="itemType === 'activo'">
                            <label for="generation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Generación (ej: DDR4)</label>
                            <input type="text" name="generation" id="generation" value="{{ old('generation') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('generation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div x-show="itemType === 'activo'">
                            <label for="watt_capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacidad en Watts (Regulador)</label>
                            <input type="number" name="watt_capacity" id="watt_capacity" value="{{ old('watt_capacity') }}" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('watt_capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- 4. CAMPOS ESPECÍFICOS DE CONSUMIBLE (TÓNER) --}}
                        
                        <div x-show="itemType === 'consumible_toner'">
                            <label for="printer_model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modelo de Impresora Compatible</label>
                            <input type="text" name="printer_model" id="printer_model" value="{{ old('printer_model') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('printer_model') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div x-show="itemType === 'consumible_toner'">
                            <label for="toner_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color de Tóner</label>
                            <input type="text" name="toner_color" id="toner_color" value="{{ old('toner_color') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('toner_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- 5. CAMPOS ESPECÍFICOS DE CONSUMIBLE (MATERIAL) --}}

                        <div x-show="itemType === 'consumible_material'">
                            <label for="material_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Material</label>
                            <input type="text" name="material_type" id="material_type" value="{{ old('material_type') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('material_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- 6. CAMPOS DE IDENTIFICACIÓN (Activo/Herramienta) --}}
                        
                        <div x-show="itemType === 'activo' || itemType === 'herramienta'">
                            <label for="serial_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('serial_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div x-show="itemType === 'activo'">
                            <label for="national_asset_tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bien Nacional (BN)</label>
                            <input type="text" name="national_asset_tag" id="national_asset_tag" value="{{ old('national_asset_tag') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('national_asset_tag') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>
                    
                    {{-- Botones --}}
                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-gray-500">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                            Guardar Ítem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection