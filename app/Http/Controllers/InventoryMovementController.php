<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryMovementController extends Controller
{
    public function createIn(Inventory $inventory)
    {
        return view('inventory.entrada', compact('inventory'));
    }

    public function storeIn(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($inventory, $data) {
            $inventory->increment('quantity', $data['quantity']);
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'type' => 'in',
                'quantity' => $data['quantity'],
                'user_id' => auth()->id(),
                'note' => $data['note'] ?? null,
            ]);
        });

        return redirect()->route('inventory.show', $inventory)->with('status', 'Entrada registrada');
    }

    public function createOut(Inventory $inventory)
    {
        $locations = Location::orderBy('name')->get();
        return view('inventory.salida', compact('inventory', 'locations'));
    }

    public function storeOut(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($inventory, $data) {
            // Validación de stock suficiente
            $inventory->refresh();
            if ($inventory->quantity < $data['quantity']) {
                abort(422, 'Stock insuficiente.');
            }
            $inventory->decrement('quantity', $data['quantity']);
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'type' => 'out',
                'quantity' => $data['quantity'],
                'user_id' => auth()->id(),
                'note' => $data['note'] ?? null,
                'location_id' => $data['location_id'],
            ]);
        });

        return redirect()->route('inventory.show', $inventory)->with('status', 'Salida registrada');
    }
}
