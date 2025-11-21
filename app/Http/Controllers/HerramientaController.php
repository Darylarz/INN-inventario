<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = Herramienta::orderBy('created_at', 'desc')->paginate(15);
        return view('herramientas.index', compact('herramientas'));
    }

    public function crear()
    {
        return view('herramientas.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|string|max:255',
        ]);

        Herramienta::create($request->all());

        return redirect()->route('herramientas.index')
            ->with('status', 'Herramienta registrada exitosamente.');
    }

    public function editar(Herramienta $herramienta)
    {
        return view('herramientas.editar', compact('herramienta'));
    }

    public function actualizar(Request $request, Herramienta $herramienta)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|string|max:255',
        ]);

        $herramienta->update($request->all());

        return redirect()->route('herramientas.index')
            ->with('status', 'Herramienta actualizada correctamente.');
    }

    public function eliminar(Herramienta $herramienta)
    {
        $herramienta->delete();

        return redirect()->route('herramientas.index')
            ->with('status', 'Herramienta eliminada correctamente.');
    }
}
