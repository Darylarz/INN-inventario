<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->when($search, function ($query, $search) {
                // Filtra por BRAND, MODEL, SERIAL o BIEN NACIONAL
                $query->where('brand', 'like', '%' . $search . '%')
                      ->orWhere('model', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      ->orWhere('national_asset_tag', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc') 
            ->paginate(10); 

        return response()->json($inventories);
    }
}