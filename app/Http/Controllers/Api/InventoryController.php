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
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', '%' . $search . '%')
                      ->orWhere('model', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      ->orWhere('national_asset_tag', 'like', '%' . $search . '%')
                      ->orWhere('item_type', 'like', '%' . $search . '%')
                      ->orWhere('printer_model', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Add debug info
        $response = $inventories->toArray();
        $response['debug'] = [
            'total_records' => Inventory::count(),
            'search_term' => $search,
            'sql' => $inventories->toSql()
        ];

        return response()->json($response);
    }
}