<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->paginate(15);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:60', 'unique:locations,code'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        Location::create($data);
        return redirect()->route('locations.index')->with('success', 'Ubicación creada.');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:60', 'unique:locations,code,' . $location->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $location->update($data);
        return redirect()->route('locations.index')->with('success', 'Ubicación actualizada.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Ubicación eliminada.');
    }
}
