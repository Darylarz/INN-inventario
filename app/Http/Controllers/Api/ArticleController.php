<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->query('search');

        $articles = Article::query()
            ->when($search, function ($query, $search) {
                // Filtrar por nombre o SKU si hay término de búsqueda
                $query->where('name', 'like', '%' . $search . '%');
            })
            // Ordenar por ID descendente y paginar con 10 resultados por página
            ->orderBy('id', 'desc') 
            ->paginate(10); 

        // Retorna la respuesta en formato JSON (Laravel lo hace automáticamente)
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
        ]);

        // Verificación de permiso antes de la acción (Guardrail de seguridad)
        if (!auth()->user()->can('articulo agregar')) {
             return response()->json([
                 'message' => 'No tienes permiso para agregar artículos.'
             ], 403); // Código de error de prohibido
        }

        $article = Article::create($validatedData);

        // Retorna el nuevo artículo y un mensaje de éxito
        return response()->json([
            'message' => 'Artículo creado con éxito.',
            'article' => $article
        ], 201); // Código de éxito de creación
    }
}