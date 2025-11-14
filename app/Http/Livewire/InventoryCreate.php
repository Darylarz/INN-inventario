<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\InventoryType;

class InventoryCreate extends Component
{
    public $brand = '';
    public $model = '';
    public $serial_number = '';
    public $national_asset_tag = '';
    public $item_type = '';
    public $printer_model = '';
    public $inventoryTypes = [];

    public function mount()
    {
        $this->inventoryTypes = InventoryType::all();
    }

    protected function rules()
    {
        return [
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'national_asset_tag' => 'nullable|string|max:255',
            'item_type' => 'nullable|string|max:255',
            'printer_model' => 'nullable|string|max:255',
        ];
    }

    public function submit()
    {
        if (!auth()->user()->can('articulo agregar')) {
            session()->flash('error', 'No tienes permiso para agregar artículos.');
            return;
        }

        $data = $this->validate();

        // Mapear item_type -> type (columna en la BD)
        if (isset($data['item_type'])) {
            $data['type'] = $data['item_type'];
            // unset($data['item_type']); // opcional
        }

        Inventory::create($data);

        session()->flash('success', 'Artículo creado correctamente.');
        return redirect()->route('inventario-index');
    }

    public function render()
    {
        return view('livewire.inventory-create');
    }
}