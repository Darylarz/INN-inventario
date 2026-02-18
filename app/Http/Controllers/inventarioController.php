<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventario;
use App\Models\TipoInventario;
use App\Models\movimientoInventario;
use App\Models\User;

class inventarioController extends Controller
{
    // Listado / Dashboard
    public function index(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $inventario = Inventario::query()
            ->where(function ($q) {
                $q->whereNull('esta_desactivado')->orWhere('esta_desactivado', false);
            })
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('marca', 'like', "%{$busqueda}%")
                      ->orWhere('modelo', 'like', "%{$busqueda}%")
                      ->orWhere('nombre', 'like', "%{$busqueda}%")
                      ->orWhere('numero_serial', 'like', "%{$busqueda}%")
                      ->orWhere('bien_nacional', 'like', "%{$busqueda}%")
                      ->orWhere('tipo_item', 'like', "%{$busqueda}%")
                      ->orWhere('modelo_impresora', 'like', "%{$busqueda}%")
                      ->orWhere('capacidad', 'like', "%{$busqueda}%")
                      ->orWhere('generacion', 'like', "%{$busqueda}%")
                      ->orWhere('tipo', 'like', "%{$busqueda}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Resumen global: total de unidades y por categoría (sin filtrar), para coincidir con el sidebar
        $unidadesTotales = (int) Inventario::query()->sum('cantidad');
        $totalesPorTipo = Inventario::query()
            ->select('tipo_item', DB::raw('SUM(cantidad) as total'))
            ->groupBy('tipo_item')
            ->pluck('total', 'tipo_item');

        // Alerta de stock bajo (solo activos/no desincorporados)
        $stock = Inventario::query()
            ->where(function ($q) {
                $q->whereNull('esta_desactivado')->orWhere('esta_desactivado', false);
            });
        $stockBajo = (int) (env('LOW_STOCK_THRESHOLD', 5));
        $lowStockItems = (clone $stock)
            ->whereNotNull('cantidad')
            ->where('cantidad', '<=', $stockBajo)
            ->orderBy('cantidad')
            ->orderBy('id')
            ->limit(50)
            ->get(['id','tipo_item','marca','modelo','modelo_impresora','tipo_material','cantidad']);

        return view('inventario.index', compact('inventario', 'busqueda', 'unidadesTotales', 'totalesPorTipo', 'lowStockItems'));
    }

    // Listado de artículos deshabilitados
    public function disabledIndex(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $inventario = Inventario::query()
            ->where('esta_desactivado', true)
            ->when($busqueda, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('marca', 'like', "%{$search}%")
                      ->orWhere('modelo', 'like', "%{$search}%")
                      ->orWhere('numero_serial', 'like', "%{$search}%")
                      ->orWhere('bien_nacional', 'like', "%{$search}%")
                      ->orWhere('tipo_item', 'like', "%{$search}%")
                      ->orWhere('impresora_modelo', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('inventario.disabled', compact('inventario', 'busqueda'));
    }

    // Detalle de artículo
    public function show(Inventario $inventario)
    {
        $movimientos = movimientoInventario::where('inventario_id', $inventario->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('inventario.show', compact('inventario', 'movimientos'));
    }

    public function disable(Request $request, Inventario $inventario)
    {
        if (!auth()->check() || !auth()->user()->can('usuario crear')) {
            abort(403);
        }
        $request->validate([
            'razon_desactivado' => 'nullable|string|max:500',
        ]);

        $inventario->update([
            'esta_desactivado' => true,
            'fecha_desactivado' => now(),
            'razon_desactivado' => $request->input('razon_desactivado'),
        ]);

        return redirect()->back()->with('success', 'Artículo desincorporado.');
    }

    public function enable(Request $request, Inventario $inventario)
    {
        if (!auth()->check() || !auth()->user()->can('usuario crear')) {
            abort(403);
        }

        $inventario->update([
            'esta_desactivado' => false,
            'fecha_desactivado' => null,
            'razon_desactivado' => null,
        ]);

        return redirect()->back()->with('success', 'Artículo reincorporado.');
    }

    private function autorizarAdmin(): void
    {
        if (!auth()->check() || (auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }
    }

    // Mostrar formulario de creación
    public function create()
    {
        $tipoInventario = TipoInventario::all();

     $users = User::forInventario();

        return view('inventario.create', compact('tipoInventario', 'users'));
        
    }

    // Guardar nuevo artículo
    public function store(Request $request)
    {
        $request->validate([
            'tipo_item' => 'required|exists:tipo_inventario,nombre',
            'campo-marca' => 'nullable|string|max:20',
            'campo-modelo' => 'nullable|string|max:20',
            'nombre' => 'nullable|string|max:20',
            'capacidad' => 'nullable|string|max:20',
            'tipo' => 'nullable|string|max:20',
            'generacion' => 'nullable|string|max:20',
            'capacidad_watt' => 'nullable|integer|max:10000',
            'numero_serial' => 'nullable|string|max:32',
            'bien_nacional' => 'nullable|string|max:30',
            'nombre_herramienta' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:15',
            'modelo_impresora' => 'nullable|string|max:20',
            'tipo_material' => 'nullable|string|max:15',
            'reciclado' => 'nullable|boolean',
            'ingresado_por' => 'nullable|string|max:20',
        ]);

        $data = $request->all();
        \Log::info('inventario.store.request', $data);

        $created = Inventario::create($data);
        $created->fecha_ingreso = $request->input('fecha_ingreso');
        $created->save();
        \Log::info('inventario.store.created', $created->toArray());
    
        try {
    logcatModel::create([
        'user_id'     => Auth::id(),
        'accion'      => 'creado',
        'recurso'     => 'inventario',
        'sujeto_id'   => $created->id,
        'descripcion' => "Artículo creado: {$created->tipo} {$created->marca} {$created->modelo}",
        'ip'          => $request->ip(),
        'user_agent'  => substr($request->userAgent() ?? '', 0, 1000),
        'propiedades' => [
            'id' => $created->id,
            'tipo' => $created->tipo,
            'marca' => $created->marca,
            'modelo' => $created->modelo,
            'numero_serial' => $created->numero_serial,
            'bien_nacional' => $created->bien_nacional,
            'cantidad' => $created->cantidad,
        ],
    ]);
} catch (\Throwable $e) {
    // no romper la ejecución si falla el log
}

        return redirect()->route('inventario.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    // Formulario de edición
    public function edit(Inventario $inventario)
    {
        $tipoInventario = TipoInventario::all();
        return view('inventario.edit', compact('inventario', 'tipoInventario'));
    }

    // Actualizar artículo
    public function update(Request $request, Inventario $inventario)
    {
        $validated = $request->validate([
            'tipo_item' => 'required|string',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'nombre' => 'nullable|string|max:255',
            'capacidad' => 'nullable|string',
            'tipo' => 'nullable|string',
            'generacion' => 'nullable|string',
            'numero_serial' => 'nullable|string',
            'bien_nacional' => 'nullable|string',
            'impresora_modelo' => 'nullable|string',
            'tipo_material' => 'nullable|string',
            'nombre_herramienta' => 'nullable|string|max:255',
            'reciclado' => 'nullable|boolean',
            'ingresado_por' => 'nullable|string|max:255',
            'fecha_ingreso' => 'nullable|date',
        ]);

        \Log::info('inventario.update.request', $validated);
        $inventario->update($validated);
        \Log::info('inventario.update.saved', $inventario->fresh()->toArray());

        return redirect()->route('inventario.index')->with('success', 'Artículo actualizado correctamente.');
    }
    // Desactivar artículo (reemplazo de eliminar)
    public function destroy(Request $request, Inventario $inventario)
    {
        if (!auth()->check() || !auth()->user()->can('usuario crear')) {
            abort(403);
        }

        $request->validate([
            'razon_desactivado' => 'nullable|string|max:500',
        ]);

        $inventario->update([
            'esta_desactivado' => true,
            'fecha_desactivado' => now(),
            'razon_desactivado' => $request->input('razon_desactivado'),
        ]);

        return redirect()->route('inventario.index')->with('success', 'Artículo desactivado correctamente.');
    }
}
