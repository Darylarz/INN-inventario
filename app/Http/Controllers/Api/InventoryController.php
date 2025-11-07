<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory; // <--- RENOMBRADO
use Illuminate\Http\Request;

class InventoryController extends Controller // <--- RENOMBRADO
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->when($search, function ($query, $search) {
                // Filtra por BRAND, MODEL o SERIAL
                $query->where('brand', 'like', '%' . $search . '%')
                      ->orWhere('model', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      ->orWhere('national_asset_tag', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc') 
            ->paginate(10); 

        return response()->json($inventories);
    }
    
    // ... el método store() debe eliminarse de aquí, ahora va en ArticleManagementController
}