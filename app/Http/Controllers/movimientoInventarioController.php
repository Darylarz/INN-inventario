<?php
namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\movimientoInventario;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class movimientoInventarioController extends Controller
{
    public function crearEntrada(Inventario $inventario)
    {
        return view('inventario.entrada', compact('inventario'));
    }

    public function guardarEntrada(Request $request, Inventario $inventario)
    {
        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
            'nota' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($inventario, $data) {
            $inventario->increment('cantidad', $data['cantidad']);
            movimientoInventario::create([
                'inventario_id' => $inventario->id,
                'tipo' => 'entrada',
                'cantidad' => $data['cantidad'],
                'user_id' => auth()->id(),
                'nota' => $data['nota'] ?? null,
            ]);
        });

        return redirect()->route('inventario.show', $inventario)->with('status', 'Entrada registrada');
    }

    public function crearSalida(Inventario $inventario) //create
    {
        $ubicaciones = Ubicacion::orderBy('nombre')->get();
        return view('inventario.salida', compact('inventario', 'ubicaciones'));
    }

    public function guardarSalida(Request $request, inventario $inventario) //store
    {
        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
            'nota' => ['nullable', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($inventario, $data) {
            // Validación de stock suficiente
            $inventario->refresh();
            if ($inventario->cantidad < $data['cantidad']) {
                abort(422, 'Stock insuficiente.');
            }
            $inventario->decrement('cantidad', $data['cantidad']);
            movimientoInventario::create([
                'inventario_id' => $inventario->id,
                'tipo' => 'salida',
                'cantidad' => $data['cantidad'],
                'user_id' => auth()->id(),
                'nota' => $data['nota'] ?? null,
                'ubicacion_id' => $data['ubicacion_id'],
            ]);
        });

        return redirect()->route('inventario.show', $inventario)->with('status', 'Salida registrada');
    }
}
