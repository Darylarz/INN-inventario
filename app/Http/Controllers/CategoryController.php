<?php
namespace App\Http\Controllers;

use App\Models\TipoInventario;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = TipoInventario::orderBy('name')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tipos_inventario,name'],
        ]);

        TipoInventario::create($data);
        return redirect()->route('categories.index')->with('success', 'Categoría creada.');
    }

    public function edit(TipoInventario $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, TipoInventario $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tipos_inventario,name,' . $category->id],
        ]);

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(TipoInventario $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada.');
    }
}
