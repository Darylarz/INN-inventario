<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logcatModel;

class logcatController extends Controller
{
    public function index(Request $request)
    {
        $query = logcatModel::with('user')->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->filled('$recurso')) {
            $query->where('$recurso', $request->$recurso);
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('logcat.index', compact('logs'));
    }

    public function show(logcatModel $logcat)
    {
        return view('logcat.show', compact('logcat'));
    }

    public function deactivate(logcatModel $logcat)
    {
        $logcat->update(['is_active' => false]);
        return redirect()->route('logcat.index')->with('success', 'Registro desactivado.');
    }
}