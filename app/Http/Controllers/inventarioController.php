<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario;

class inventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('indexInventario');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createInventario');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $m = new inventario();

        $validated = $request->validate([
            'nombre' => 'string|max:255',
            'bien_nacional' => 'string|max:255',
            'descripcion' => 'string|max:255',
        ]);

        $m::create($validated);
        return redirect()->route(inventario.create)
        ->with('success', 'entrada agregada correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('inventario.show', [articulo => inventario::findOrFail($id)]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('inventario.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $m = inventario::findOrFail($id);
        $m->nombre = $request->input('nombre');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
