<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;

class InventoryDashboard extends Component
{
    use WithPagination;

    public $search = '';
    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $inventories = Inventory::query()
            ->when($this->search, function ($q) {
                $q->where('brand', 'like', "%{$this->search}%")
                  ->orWhere('model', 'like', "%{$this->search}%")
                  ->orWhere('serial_number', 'like', "%{$this->search}%")
                  ->orWhere('national_asset_tag', 'like', "%{$this->search}%")
                  ->orWhere('item_type', 'like', "%{$this->search}%")
                  ->orWhere('printer_model', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.inventory-dashboard', [
            'inventories' => $inventories,
        ]);
    }
}