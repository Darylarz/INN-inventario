<?php

namespace App\Http\Controllers;

// ...

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Inventario;
use Illuminate\Validation\Rule;
use App\Models\TipoInventario;
use Illuminate\Http\RedirectResponse;


class manejoInventarioController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $inventarios = Inventario::query()
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('marca', 'like', '%' . $busqueda . '%')
                      ->orWhere('modelo', 'like', '%' . $busqueda . '%')
                      ->orWhere('numero_serial', 'like', '%' . $busqueda . '%')
                      ->orWhere('bien_nacional', 'like', '%' . $busqueda . '%')
                      ->orWhere('tipo_item', 'like', '%' . $busqueda . '%')
                      ->orWhere('modelo_impresora', 'like', '%' . $busqueda . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Dashboard', [
            'inventarios' => $inventarios,
            'busqueda' => $busqueda,
        ]);
    }
    
    public function create()
    {
        $tipoInventarios = tipoInventario::all();

        return Inertia::render('Inventario/Create', [
            'tipoInventarios' => $tipoInventarios,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Verificar permiso
        if (!auth()->user()->can('articulo agregar')) { 
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para agregar inventario.');
        }
        // VALIDACIÓN DINÁMICA BASADA EN EL CAMPO 'type' ENVIADO POR EL FORMULARIO
        $request->validate(['tipo' => 'required|in:activo,herramienta,consumible_toner,consumible_material']);
        $tipo = $request->input('tipo');

        $reglas = [
            'marca' => ['nullable', 'string', 'max:255'],
            'modelo' => ['nullable', 'string', 'max:255'],
            'numero_serial' => ['nullable', 'string', 'max:255', Rule::unique('inventario', 'numero_serial')],
            'bien_nacional' => ['nullable', 'string', 'max:255', Rule::unique('inventario', 'bien_nacional')],
        ];
        
        if ($tipo === 'activo') {
            $rules = array_merge($reglas, [
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'tipo_item' => 'required|string',
                'capacidad' => 'nullable|string',
                'generacion' => 'nullable|string',
                'capacidad_watt' => 'nullable|numeric|min:0',
            ]);
        } elseif ($type === 'herramienta') {
            $rules = array_merge($reglas, [
                'tipo_item' => 'required|string', // Nombre de la herramienta
            ]);
        } elseif ($type === 'consumible_toner') {
            $rules = array_merge($reglas, [
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'modelo_impresora' => 'required|string',
                'toner_color' => 'required|string',
            ]);
        } elseif ($type === 'consumible_material') {
            $rules = array_merge($reglas, [
                'tipo_item' => 'required|string', // Nombre del material
                'tipo_material' => 'required|string', // Tipo de material (ej: papel, tinta)
            ]);
        } else {
            // Manejar caso no válido (aunque la validación 'in' debería prevenir esto)
            return redirect()->back()->withInput()->withErrors(['tipo' => 'Tipo de inventario no válido.']);
        }
        
        $validatedData = $request->validate($rules); 
        $validatedData['tipo'] = $type; // Asegurar que el campo type se guarde

        Inventario::create($validatedData); // <--- RENOMBRADO

        return redirect()->route('dashboard')->with('status', 'Ítem de inventario creado exitosamente.');
    }

    
    public function edit(Inventario $inventario)
    {
        if (!auth()->user()->can('articulo modificar')) {
            // Asumiendo que 'articulo modificar' es el permiso para editar
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para modificar inventario.');
        }

        $tipoInventarios = \App\Models\tipoInventario::all();

        return Inertia::render('Inventario/Edit', [
            'inventario' => $inventario,
            'tiposInventarios' => $tiposInventarios,
        ]);
    }


    public function update(Request $request, Inventario $inventario): RedirectResponse
    {
        // 1. Verificar Permiso de Modificación
        if (!auth()->user()->can('articulo modificar')) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para modificar inventario.');
        }
        
        // 2. Definir la Validación Dinámica
        $request->validate(['tipo' => 'required|in:activo,herramienta,consumible_toner,consumible_material']);
        $type = $request->input('tipo');

        // Reglas base, ajustando la unicidad para IGNORAR el ítem actual ($inventario->id)
        $reglas = [
            'marca' => ['nullable', 'string', 'max:255'],
            'modelo' => ['nullable', 'string', 'max:255'],
            'numero_serial' => ['nullable', 'string', 'max:255', 
                                Rule::unique('inventario', 'numero_serial')->ignore($inventario->id)],
            'bien_nacional' => ['nullable', 'string', 'max:255', 
                                     Rule::unique('inventario', 'bien_nacional')->ignore($inventario->id)],
            // La excepción ignore($inventario->id) es CRUCIAL para evitar errores
        ];
        
        // 3. Aplicar Reglas Condicionales (Mismo patrón que store())
        if ($tipo === 'activo') {
            $rules = array_merge($reglas, [
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'tipo_item' => 'required|string',
                'capacidad' => 'nullable|string',
                'generacion' => 'nullable|string',
                'capacidad_watt' => 'nullable|numeric|min:0',
            ]);
        } elseif ($type === 'herramienta') {
            $rules = array_merge($reglas, [
                'tipo_item' => 'required|string', // Nombre de la herramienta
            ]);
        } elseif ($tipo === 'consumible_toner') {
            $rules = array_merge($reglas, [
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'modelo_impresora' => 'required|string',
                'toner_color' => 'required|string',
            ]);
        } elseif ($tipo === 'consumible_material') {
            $rules = array_merge($reglas, [
                'tipo_item' => 'required|string', // Nombre del material
                'tipo_material' => 'required|string', // Tipo de material
            ]);
        } else {
            return redirect()->back()->withInput()->withErrors(['tipo' => 'Tipo de inventario no válido.']);
        }
        
        $validatedData = $request->validate($rules);
        $validatedData['tipo'] = $tipo; // Asegurar que el campo type se guarde
        
        // 4. Actualizar el Modelo y Redirigir
        $inventario->update($validatedData);

        return redirect()->route('dashboard')->with('status', 'Ítem de inventario actualizado exitosamente.');
    }



    public function destroy(Inventario $inventario): RedirectResponse
    {
        
        // 1. Verificar Permiso de Eliminación
        if (!auth()->user()->can('articulo eliminar')) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para eliminar articulos.');
        }


        // 2. Eliminar el registro
        $inventario->delete();
        
        // 3. Redirigir al Dashboard
        return redirect()->route('dashboard')->with('status', 'Ítem de inventario eliminado exitosamente.');
    }


}