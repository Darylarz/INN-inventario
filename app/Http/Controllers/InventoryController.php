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
        // Parámetros de filtro
        $q = $request->input('q');
        $itemType = $request->input('item_type');
        $brand = $request->input('brand');
        $model = $request->input('model');
        $serial = $request->input('serial_number');
        $natAsset = $request->input('national_asset_tag');
        $from = $request->input('from');
        $to = $request->input('to');
        $sort = $request->input('sort', 'id_desc');

        $inventories = Inventory::query()
            // Excluir desincorporados
            ->where(function ($qv) {
                $qv->whereNull('is_disabled')->orWhere('is_disabled', false);
            })
            // Búsqueda de texto libre
            ->when($q, function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('brand', 'like', "%{$q}%")
                      ->orWhere('model', 'like', "%{$q}%")
                      ->orWhere('serial_number', 'like', "%{$q}%")
                      ->orWhere('national_asset_tag', 'like', "%{$q}%")
                      ->orWhere('item_type', 'like', "%{$q}%")
                      ->orWhere('printer_model', 'like', "%{$q}%");
                });
            })
            // Filtros dedicados
            ->when($itemType, fn($q2) => $q2->where('item_type', $itemType))
            ->when($brand, fn($q2) => $q2->where('brand', 'like', "%{$brand}%"))
            ->when($model, fn($q2) => $q2->where('model', 'like', "%{$model}%"))
            ->when($serial, fn($q2) => $q2->where('serial_number', 'like', "%{$serial}%"))
            ->when($natAsset, fn($q2) => $q2->where('national_asset_tag', 'like', "%{$natAsset}%"))
            // Rango de fechas (created_at)
            ->when($from, fn($q2) => $q2->whereDate('created_at', '>=', $from))
            ->when($to, fn($q2) => $q2->whereDate('created_at', '<=', $to));

        // Ordenamiento
        switch ($sort) {
            case 'brand_asc':
                $inventories->orderBy('brand', 'asc');
                break;
            case 'model_asc':
                $inventories->orderBy('model', 'asc');
                break;
            case 'created_at_desc':
                $inventories->orderBy('created_at', 'desc');
                break;
            case 'id_desc':
            default:
                $inventories->orderBy('id', 'desc');
                break;
        }

        $inventories = $inventories->paginate(15)->withQueryString();

        return view('inventory.index', compact('inventories'));
    }

    // Listado de artículos deshabilitados
    public function disabledIndex(Request $request)
    {
        
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->where('is_disabled', true)
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

        return view('inventory.disabled', compact('inventories', 'search'));
    }

    public function disable(Request $request, Inventory $inventory)
    {
        if (!auth()->check() || !auth()->user()->can('usuario crear')) {
            abort(403);
        }
        $request->validate([
            'disabled_reason' => 'nullable|string|max:500',
        ]);

        $inventory->update([
            'is_disabled' => true,
            'disabled_at' => now(),
            'disabled_reason' => $request->input('disabled_reason'),
        ]);

        return redirect()->back()->with('success', 'Artículo desincorporado.');
    }

    public function enable(Request $request, Inventory $inventory)
    {
        if (!auth()->check() || !auth()->user()->can('usuario crear')) {
            abort(403);
        }

        $inventory->update([
            'is_disabled' => false,
            'disabled_at' => null,
            'disabled_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Artículo reincorporado.');
    }

    private function authorizeAdmin(): void
    {
        if (!auth()->check() || (auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }
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

        $data = $request->all();

        // 🔥 Forzar "type" según item_type
        if ($data['item_type'] === 'Consumible' || $data['item_type'] === 'consumible') {
        $data['type'] = 'consumible';
        }

        if ($data['item_type'] === 'PC') {
        $data['type'] = $data['type'] ?? 'pc';
        }

        if ($data['item_type'] === 'Hardware') {
        $data['type'] = $data['type'] ?? 'hardware';
        }

        if ($data['item_type'] === 'Herramienta') {
        $data['type'] = $data['type'] ?? 'herramienta';
        }

        Inventory::create($data);

        return redirect()->route('inventory.index')
            ->with('success', 'Artículo creado correctamente.');
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
    $validated = $request->validate([
        'item_type' => 'required|string',
        'brand' => 'nullable|string',
        'model' => 'nullable|string',
        'capacity' => 'nullable|string',
        'type' => 'nullable|string',
        'generation' => 'nullable|string',
        'serial_number' => 'nullable|string',
        'national_asset_tag' => 'nullable|string',
        'printer_model' => 'nullable|string',
        'material_type' => 'nullable|string',
    ]);

    // 🔥 Ajustar campos según tipo
    if ($validated['item_type'] === 'computer') {
        $validated['type'] = $validated['type'] ?? 'N/A';
    }

    if ($validated['item_type'] === 'printer') {
        $validated['type'] = 'printer';
    }

    if ($validated['item_type'] === 'consumable') {
        $validated['type'] = 'consumable';
    }

    $inventory->update($validated);

    return redirect()->route('inventory.index')->with('success', 'Artículo actualizado correctamente.');
}


    // Eliminar artículo
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Artículo eliminado correctamente.');
    }
}
