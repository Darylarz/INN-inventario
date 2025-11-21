<?php

namespace App\Http\Controllers;

use App\Models\Consumible;
use Illuminate\Http\Request;

class ConsumibleController extends Controller
{
    public function index()
    {
        $consumibles = Consumible::orderBy('created_at', 'desc')->paginate(15);
        return view('consumibles.index', compact('consumibles'));
    }

    public function crear()
    {
        return view('consumibles.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'categoria'         => 'required|string|max:255',
            'marca'             => 'required|string|max:255',
            'modelo'            => 'nullable|string|max:255',
            'modelo_impresora'  => 'nullable|string|max:255',
            'color'             => 'nullable|string|max:255',
            'tipo_material'     => 'nullable|string|max:255',
            'impresora_destino' => 'nullable|string|max:255',
        ]);

        Consumible::create($request->all());

        return redirect()->route('consumibles.index')
            ->with('status', 'Consumible registrado exitosamente.');
    }

    public function editar(Consumible $consumible)
    {
        return view('consumibles.editar', compact('consumible'));
    }

    public function actualizar(Request $request, Consumible $consumible)
    {
        $request->validate([
            'categoria'         => 'required|string|max:255',
            'marca'             => 'required|string|max:255',
            'modelo'            => 'nullable|string|max:255',
            'modelo_impresora'  => 'nullable|string|max:255',
            'color'             => 'nullable|string|max:255',
            'tipo_material'     => 'nullable|string|max:255',
            'impresora_destino' => 'nullable|string|max:255',
        ]);

        $consumible->update($request->all());

        return redirect()->route('consumibles.index')
            ->with('status', 'Consumible actualizado correctamente.');
    }

    public function eliminar(Consumible $consumible)
    {
        $consumible->delete();

        return redirect()->route('consumibles.index')
            ->with('status', 'Consumible eliminado correctamente.');
    }
}
