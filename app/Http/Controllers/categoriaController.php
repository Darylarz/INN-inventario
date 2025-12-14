<?php
namespace App\Http\Controllers;

use App\Models\TipoInventario;
use Illuminate\Http\Request;

class categoriaController extends Controller
{
    public function index()
    {
        $categorias = TipoInventario::orderBy('nombre')->paginate(15);
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:tipo_inventario,nombre'],
        ]);

        TipoInventario::create($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría creada.');
    }

    public function edit(TipoInventario $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, TipoInventario $categoria)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:tipos_inventario,nombre,' . $categoria->id],
        ]);

        $categoria->update($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(TipoInventario $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
