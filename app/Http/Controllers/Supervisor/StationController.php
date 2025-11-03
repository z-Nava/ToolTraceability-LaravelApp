<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Line;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::with('line')->orderBy('line_id')->paginate(10);
        return view('supervisor.stations.index', compact('stations'));
    }

    public function create()
    {
        $lines = Line::where('is_active', true)->get();
        return view('supervisor.stations.create', compact('lines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'code' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        Station::create($data);

        return redirect()->route('supervisor.stations.index')
            ->with('success', 'Estación creada correctamente.');
    }

    public function edit(Station $station)
    {
        $lines = Line::where('is_active', true)->get();
        return view('supervisor.stations.edit', compact('station', 'lines'));
    }

    public function update(Request $request, Station $station)
    {
        $data = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $station->update($data);

        return redirect()->route('supervisor.stations.index')
            ->with('success', 'Estación actualizada.');
    }

    public function destroy(Station $station)
    {
        $station->delete();
        return redirect()->route('supervisor.stations.index')
            ->with('success', 'Estación eliminada.');
    }
}
