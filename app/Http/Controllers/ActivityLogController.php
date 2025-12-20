<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class activitylogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

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

        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return redirect()->route('activity-logs.index')->with('success', 'Registro eliminado.');
    }
}