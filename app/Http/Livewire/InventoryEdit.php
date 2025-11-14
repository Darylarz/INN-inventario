<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\InventoryType;

class InventoryEdit extends Component
{
    public Inventory $inventory;

    public $brand;
    public $model;
    public $serial_number;
    public $national_asset_tag;
    public $item_type;
    public $printer_model;
    public $inventoryTypes = [];

    public function mount(Inventory $inventory)
    {
        $this->inventory = $inventory;

        $this->brand = $inventory->brand;
        $this->model = $inventory->model;
        $this->serial_number = $inventory->serial_number;
        $this->national_asset_tag = $inventory->national_asset_tag;
        $this->item_type = $inventory->type ?? $inventory->item_type;
        $this->printer_model = $inventory->printer_model;

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
        if (!auth()->user()->can('articulo modificar')) {
            session()->flash('error', 'No tienes permiso para modificar artículos.');
            return;
        }

        $data = $this->validate();

        if (isset($data['item_type'])) {
            $data['type'] = $data['item_type'];
            // unset($data['item_type']);
        }

        $this->inventory->update($data);

        session()->flash('success', 'Artículo actualizado correctamente.');
        return redirect()->route('inventario-index');
    }

    public function render()
    {
        return view('livewire.inventory-edit');
    }
}