<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\TipoInventario;
use App\Models\InventoryMovement;

class InventoryController extends Controller
{
    // Listado / Dashboard
    public function index(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->where(function ($q) {
                $q->whereNull('is_disabled')->orWhere('is_disabled', false);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('serial_number', 'like', "%{$search}%")
                      ->orWhere('national_asset_tag', 'like', "%{$search}%")
                      ->orWhere('item_type', 'like', "%{$search}%")
                      ->orWhere('printer_model', 'like', "%{$search}%")
                      ->orWhere('capacity', 'like', "%{$search}%")
                      ->orWhere('generation', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Resumen global: total de unidades y por categoría (sin filtrar), para coincidir con el sidebar
        $totalUnits = (int) Inventory::query()->sum('quantity');
        $totalsByType = Inventory::query()
            ->select('item_type', DB::raw('SUM(quantity) as total'))
            ->groupBy('item_type')
            ->pluck('total', 'item_type');

        // Alerta de stock bajo (solo activos/no desincorporados)
        $baseQuery = Inventory::query()
            ->where(function ($q) {
                $q->whereNull('is_disabled')->orWhere('is_disabled', false);
            });
        $threshold = (int) (env('LOW_STOCK_THRESHOLD', 5));
        $lowStockItems = (clone $baseQuery)
            ->whereNotNull('quantity')
            ->where('quantity', '<=', $threshold)
            ->orderBy('quantity')
            ->orderBy('id')
            ->limit(50)
            ->get(['id','item_type','brand','model','printer_model','material_type','quantity']);

        return view('inventory.index', compact('inventories', 'search', 'totalUnits', 'totalsByType', 'lowStockItems'));
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

    // Detalle de artículo
    public function show(Inventory $inventory)
    {
        $movements = InventoryMovement::where('inventory_id', $inventory->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('inventory.show', compact('inventory', 'movements'));
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
        $tipoInventario = TipoInventario::all();
        return view('inventory.create', compact('tipoInventario'));
    }

    // Guardar nuevo artículo
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|exists:tipos_inventario,name',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
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
            'recycled' => 'nullable|boolean',
            'entered_by' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
        ]);

        $data = $request->all();
        \Log::info('inventory.store.request', $data);

        // Normalizar campos comunes
        if (($data['item_type'] ?? null) === 'Herramienta' && !empty($data['tool_name'])) {
            $data['name'] = $data['tool_name'];
        }
        // Checkbox no marcado no viene en request
        $data['recycled'] = (bool)($data['recycled'] ?? false);

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

        $created = Inventory::create($data);
        \Log::info('inventory.store.created', $created->toArray());

        return redirect()->route('inventory.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    // Formulario de edición
    public function edit(Inventory $inventory)
    {
        $tipoInventario = TipoInventario::all();
        return view('inventory.edit', compact('inventory', 'tipoInventario'));
    }

    // Actualizar artículo
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'item_type' => 'required|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'generation' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'national_asset_tag' => 'nullable|string',
            'printer_model' => 'nullable|string',
            'material_type' => 'nullable|string',
            'tool_name' => 'nullable|string|max:255',
            'recycled' => 'nullable|boolean',
            'entered_by' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
        ]);

        // Normalizar campos comunes
        if (($validated['item_type'] ?? null) === 'Herramienta' && !empty($validated['tool_name'])) {
            $validated['name'] = $validated['tool_name'];
        }
        $validated['recycled'] = (bool)($validated['recycled'] ?? false);

        // 🔥 Ajustar campos según tipo (mantener compatibilidad)
        if (($validated['item_type'] ?? '') === 'computer') {
            $validated['type'] = $validated['type'] ?? 'N/A';
        }
        if (($validated['item_type'] ?? '') === 'printer') {
            $validated['type'] = 'printer';
        }
        if (($validated['item_type'] ?? '') === 'consumable') {
            $validated['type'] = 'consumable';
        }

        \Log::info('inventory.update.request', $validated);
        $inventory->update($validated);
        \Log::info('inventory.update.saved', $inventory->fresh()->toArray());

        return redirect()->route('inventory.index')->with('success', 'Artículo actualizado correctamente.');
    }
    // Eliminar artículo
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.disabled')->with('success', 'Artículo eliminado correctamente.');
    }
}
