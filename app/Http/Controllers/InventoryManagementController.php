<?php

namespace App\Http\Controllers;

// ...

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Inventory;
use Illuminate\Validation\Rule;
use App\Models\InventoryType;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class InventoryManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', '%' . $search . '%')
                      ->orWhere('model', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      ->orWhere('national_asset_tag', 'like', '%' . $search . '%')
                      ->orWhere('item_type', 'like', '%' . $search . '%')
                      ->orWhere('printer_model', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Dashboard', [
            'inventories' => $inventories,
            'search' => $search,
        ]);
    }
    
    public function create()
    {
        $inventoryTypes = InventoryType::all();

        return Inertia::render('Inventory/Create', [
            'inventoryTypes' => $inventoryTypes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Verificar permiso
        if (!auth()->user()->can('articulo agregar')) { 
            // NOTA: MANTENEMOS EL PERMISO GENÉRICO 'articulo agregar'
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para agregar inventario.');
        }
        
        // VALIDACIÓN DINÁMICA BASADA EN EL CAMPO 'type' ENVIADO POR EL FORMULARIO
        $request->validate(['type' => 'required|in:activo,herramienta,consumible_toner,consumible_material']);
        $type = $request->input('type');

        $baseRules = [
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255', Rule::unique('inventario', 'serial_number')],
            'national_asset_tag' => ['nullable', 'string', 'max:255', Rule::unique('inventario', 'national_asset_tag')],
        ];
        
        if ($type === 'activo') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'item_type' => 'required|string',
                'capacity' => 'nullable|string',
                'generation' => 'nullable|string',
                'watt_capacity' => 'nullable|numeric|min:0',
            ]);
        } elseif ($type === 'herramienta') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre de la herramienta
            ]);
        } elseif ($type === 'consumible_toner') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'printer_model' => 'required|string',
                'toner_color' => 'required|string',
            ]);
        } elseif ($type === 'consumible_material') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre del material
                'material_type' => 'required|string', // Tipo de material (ej: papel, tinta)
            ]);
        } else {
            // Manejar caso no válido (aunque la validación 'in' debería prevenir esto)
            return redirect()->back()->withInput()->withErrors(['type' => 'Tipo de inventario no válido.']);
        }
        
        $validatedData = $request->validate($rules); 
        $validatedData['type'] = $type; // Asegurar que el campo type se guarde

        Inventory::create($validatedData); // <--- RENOMBRADO

        return redirect()->route('dashboard')->with('status', 'Ítem de inventario creado exitosamente.');
    }

    
    public function edit(Inventory $inventory)
    {
        if (!auth()->user()->can('articulo modificar')) {
            // Asumiendo que 'articulo modificar' es el permiso para editar
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para modificar inventario.');
        }

        $inventoryTypes = \App\Models\InventoryType::all();

        return Inertia::render('Inventory/Edit', [
            'inventory' => $inventory,
            'inventoryTypes' => $inventoryTypes,
        ]);
    }


    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        // 1. Verificar Permiso de Modificación
        if (!auth()->user()->can('articulo modificar')) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para modificar inventario.');
        }
        
        // 2. Definir la Validación Dinámica
        $request->validate(['type' => 'required|in:activo,herramienta,consumible_toner,consumible_material']);
        $type = $request->input('type');

        // Reglas base, ajustando la unicidad para IGNORAR el ítem actual ($inventory->id)
        $baseRules = [
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255', 
                                Rule::unique('inventories', 'serial_number')->ignore($inventory->id)],
            'national_asset_tag' => ['nullable', 'string', 'max:255', 
                                     Rule::unique('inventories', 'national_asset_tag')->ignore($inventory->id)],
            // La excepción ignore($inventory->id) es CRUCIAL para evitar errores
        ];
        
        // 3. Aplicar Reglas Condicionales (Mismo patrón que store())
        if ($type === 'activo') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'item_type' => 'required|string',
                'capacity' => 'nullable|string',
                'generation' => 'nullable|string',
                'watt_capacity' => 'nullable|numeric|min:0',
            ]);
        } elseif ($type === 'herramienta') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre de la herramienta
            ]);
        } elseif ($type === 'consumible_toner') {
            $rules = array_merge($baseRules, [
                'brand' => 'required|string',
                'model' => 'required|string',
                'printer_model' => 'required|string',
                'toner_color' => 'required|string',
            ]);
        } elseif ($type === 'consumible_material') {
            $rules = array_merge($baseRules, [
                'item_type' => 'required|string', // Nombre del material
                'material_type' => 'required|string', // Tipo de material
            ]);
        } else {
            return redirect()->back()->withInput()->withErrors(['type' => 'Tipo de inventario no válido.']);
        }
        
        $validatedData = $request->validate($rules);
        $validatedData['type'] = $type; // Asegurar que el campo type se guarde
        
        // 4. Actualizar el Modelo y Redirigir
        $inventory->update($validatedData);

        return redirect()->route('dashboard')->with('status', 'Ítem de inventario actualizado exitosamente.');
    }



    public function destroy(Inventory $inventory): RedirectResponse
    {
        // 1. Verificar Permiso de Eliminación
        if (!auth()->user()->can('articulo eliminar')) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para eliminar inventario.');
        }

        // 2. Eliminar el registro
        $inventory->delete();

        // 3. Redirigir al Dashboard
        return redirect()->route('dashboard')->with('status', 'Ítem de inventario eliminado exitosamente.');
    }


}