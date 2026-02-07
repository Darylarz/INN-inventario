<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;

class LoadtestInventarioController extends Controller
{
    public function store(Request $request)
    {
        $key = $request->header('X-API-KEY') ?? $request->query('api_key');
        if (!$key || $key !== env('LOADTEST_API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'tipo_item' => 'required|exists:tipo_inventario,nombre',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'nombre' => 'nullable|string|max:255',
            'capacidad' => 'nullable|string|max:50',
            'tipo' => 'nullable|string|max:50',
            'generacion' => 'nullable|string|max:50',
            'capacidad_watt' => 'nullable|integer|max:10000',
            'numero_serial' => 'nullable|string|max:64',
            'bien_nacional' => 'nullable|string|max:64',
            'modelo_impresora' => 'nullable|string|max:50',
            'tipo_material' => 'nullable|string|max:50',
            'reciclado' => 'nullable|boolean',
            'ingresado_por' => 'nullable|string|max:100',
            'fecha_ingreso' => 'nullable|date',
            'cantidad' => 'nullable|integer',
        ]);

        $created = Inventario::create($validated);
        return response()->json($created, 201);
    }
}
