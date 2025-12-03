<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !auth()->user()->can('articulo agregar')) {
            abort(403);
        }

        $itemTypes = Inventory::query()
            ->select('item_type')
            ->whereNotNull('item_type')
            ->distinct()
            ->orderBy('item_type')
            ->pluck('item_type');

        return view('reports.index', compact('itemTypes'));
    }

    public function pdf(Request $request)
    {
        if (!auth()->check() || !auth()->user()->can('articulo agregar')) {
            abort(403);
        }

        $request->validate([
            'status' => 'nullable|in:all,enabled,disabled',
            'item_type' => 'nullable|string',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $status = $request->input('status', 'all');
        // Normalizar item_type a canónico
        $rawType = $request->input('item_type');
        $itemType = $rawType ? trim($rawType) : null;

        $from = $request->input('from');
        $to = $request->input('to');

        $query = Inventory::query();

        if ($status === 'enabled') {
            $query->where(function ($q) {
                $q->whereNull('is_disabled')->orWhere('is_disabled', false);
            });
        } elseif ($status === 'disabled') {
            $query->where('is_disabled', true);
        }

        if ($itemType) {
            $query->where('item_type', $itemType);
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $items = $query->orderBy('id', 'desc')->get();

        // Obtener última ubicación (última salida) por inventario
        $locByInv = collect();
        if ($items->isNotEmpty()) {
            $latestOuts = InventoryMovement::with('location')
                ->whereIn('inventory_id', $items->pluck('id'))
                ->where('type', 'out')
                ->orderByDesc('created_at')
                ->get()
                ->unique('inventory_id');
            $locByInv = $latestOuts->mapWithKeys(function ($mov) {
                return [$mov->inventory_id => optional($mov->location)->name];
            });
        }

        $pdf = Pdf::loadView('reports.pdf', [
            'items' => $items,
            'status' => $status,
            'itemType' => $itemType,
            'from' => $from,
            'to' => $to,
            'generatedAt' => now(),
            'locByInv' => $locByInv,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('reporte-inventario.pdf');
    }
}
