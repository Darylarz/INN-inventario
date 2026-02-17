<?php
namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class ubicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::where('is_active', true) // Filtrar solo ubicaciones activas
            ->orderBy('nombre')
            ->paginate(15);
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function create()
    {
        return view('ubicaciones.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:20'],
            'codigo' => ['nullable', 'string', 'max:60', 'unique:ubicaciones,codigo'],
            'descripcion' => ['nullable', 'string', 'max:50'],
        ]);
        Ubicacion::create($data);
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación creada.');
    }

    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit', compact('ubicacion'));
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:20'],
            'codigo' => ['nullable', 'string', 'max:60', 'unique:ubicacion,codigo,' . $ubicacion->id],
            'descripcion' => ['nullable', 'string', 'max:50'],
        ]);
        $ubicacion->update($data);
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación actualizada.');
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación eliminada.');
    }

    public function deactivate(Ubicacion $ubicacion)
    {
        $ubicacion->update(['is_active' => false]); // Desactivar ubicación
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación desactivada.');
    }
}
