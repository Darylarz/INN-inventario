<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryType;

class InventoryController extends Controller
{
    // Listado / Dashboard
    public function index(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('serial_number', 'like', "%{$search}%")
                      ->orWhere('national_asset_tag', 'like', "%{$search}%")
                      ->orWhere('item_type', 'like', "%{$search}%")
                      ->orWhere('printer_model', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.index', compact('inventories', 'search'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $inventoryTypes = InventoryType::all();
        return view('inventory.create', compact('inventoryTypes'));
    }

    // Guardar nuevo artículo
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|exists:inventory_types,name',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'generation' => 'nullable|string|max:255',
            'watt_capacity' => 'nullable|integer',
            'serial_number' => 'nullable|string|max:255',
            'national_asset_tag' => 'nullable|string|max:255',
            'tool_name' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'printer_model' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:255',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Artículo creado correctamente.');
    }

    // Formulario de edición
    public function edit(Inventory $inventory)
    {
        $inventoryTypes = InventoryType::all();
        return view('inventory.edit', compact('inventory', 'inventoryTypes'));
    }

    // Actualizar artículo
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_type' => 'required|exists:inventory_types,name',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'generation' => 'nullable|string|max:255',
            'watt_capacity' => 'nullable|integer',
            'serial_number' => 'nullable|string|max:255',
            'national_asset_tag' => 'nullable|string|max:255',
            'tool_name' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'printer_model' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:255',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Artículo actualizado correctamente.');
    }

    // Eliminar artículo
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Artículo eliminado correctamente.');
    }
}
