<?php

namespace App\Http\Controllers;

use App\Models\ArticuloHardware;
use Illuminate\Http\Request;

class ArticuloHardwareController extends Controller
{
    /**
     * Mostrar listado
     */
    public function index()
    {
        $articulos = ArticuloHardware::orderBy('created_at', 'desc')->paginate(15);
        return view('hardware.index', compact('articulos'));
    }

    /**
     * Formulario crear
     */
    public function crear()
    {
        return view('hardware.crear');
    }

    /**
     * Guardar
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'marca'          => 'required|string|max:255',
            'modelo'         => 'required|string|max:255',
            'capacidad'      => 'nullable|string|max:255',
            'tipo'           => 'required|string|max:255',
            'generacion'     => 'nullable|string|max:255',
            'capacidad_watt' => 'nullable|numeric',
            'serial'         => 'required|string|max:255',
            'bien_nacional'  => 'required|string|max:255',
        ]);

        ArticuloHardware::create($request->all());

        return redirect()->route('hardware.index')
            ->with('status', 'Artículo creado correctamente.');
    }

    /**
     * Formulario editar
     */
    public function editar(ArticuloHardware $articulo)
    {
        return view('hardware.editar', compact('articulo'));
    }

    /**
     * Actualizar
     */
    public function actualizar(Request $request, ArticuloHardware $articulo)
    {
        $request->validate([
            'marca'          => 'required|string|max:255',
            'modelo'         => 'required|string|max:255',
            'capacidad'      => 'nullable|string|max:255',
            'tipo'           => 'required|string|max:255',
            'generacion'     => 'nullable|string|max:255',
            'capacidad_watt' => 'nullable|numeric',
            'serial'         => 'required|string|max:255',
            'bien_nacional'  => 'required|string|max:255',
        ]);

        $articulo->update($request->all());

        return redirect()->route('hardware.index')
            ->with('status', 'Artículo actualizado correctamente.');
    }

    /**
     * Eliminar
     */
    public function eliminar(ArticuloHardware $articulo)
    {
        $articulo->delete();

        return redirect()->route('hardware.index')
            ->with('status', 'Artículo eliminado correctamente.');
    }
}
