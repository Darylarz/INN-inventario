<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\movimientoInventario;
use Barryvdh\DomPDF\Facade\Pdf;

class reportesController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check() || !auth()->user()->can('articulo agregar')) {
            abort(403);
        }

        $tiposItems = Inventario::query()
            ->select('tipo_item')
            ->whereNotNull('tipo_item')
            ->distinct()
            ->orderBy('tipo_item')
            ->pluck('tipo_item');

        return view('reportes.index', compact('tiposItems'));
    }

    public function pdf(Request $request)
    {
        if (!auth()->check() || !auth()->user()->can('articulo agregar')) {
            abort(403);
        }

        $request->validate([
            'status' => 'nullable|in:todo,activado,desactivado',
            'tipo_item' => 'nullable|string',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $status = $request->input('status', 'todo');
        // Normalizar item_type a canónico
        $rawType = $request->input('tipo_item');
        $tipoItem = $rawType ? trim($rawType) : null;

        $from = $request->input('from');
        $to = $request->input('to');

        $query = Inventario::query();

        if ($status === 'activado') {
            $query->where(function ($q) {
                $q->whereNull('esta_desactivado')->orWhere('esta_desactivado', false);
            });
        } elseif ($status === 'desactivado') {
            $query->where('esta_desactivado', true);
        }

        if ($tipoItem) {
            $query->where('tipo_item', $tipoItem);
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
            $latestOuts = movimientoInventario::with('ubicacion')
                ->whereIn('inventario_id', $items->pluck('id'))
                ->where('tipo', 'salida')
                ->orderByDesc('created_at')
                ->get()
                ->unique('inventario_id');
            $locByInv = $latestOuts->mapWithKeys(function ($mov) {
                return [$mov->inventario_id => optional($mov->ubicacion)->nombre];
            });
        }

        $pdf = Pdf::loadView('reportes.pdf', [
            'items' => $items,
            'status' => $status,
            'tipoItem' => $tipoItem,
            'from' => $from,
            'to' => $to,
            'generatedAt' => now(),
            'locByInv' => $locByInv,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('reporte-inventario.pdf');
    }
}
