<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionRun;
use App\Models\Station;
use App\Models\StationSession;
use Illuminate\Http\Request;

class StationSessionController extends Controller
{
    public function create(ProductionRun $productionRun)
    {
        $stations = Station::where('is_active', true)->get();
        return view('production.stations.session', compact('productionRun', 'stations'));
    }

    public function store(Request $request, ProductionRun $productionRun)
    {
        $data = $request->validate([
            'station_id' => 'required|exists:stations,id',
        ]);

        // Cierra sesiones previas activas del mismo usuario
        StationSession::where('leader_user_id', auth()->id())
            ->where('is_active', true)
            ->update(['is_active' => false, 'closed_at' => now()]);

        // Crea nueva sesión
        $session = StationSession::create([
            'production_run_id' => $productionRun->id,
            'station_id' => $data['station_id'],
            'leader_user_id' => auth()->id(),
            'opened_at' => now(),
            'is_active' => true,
        ]);

        return redirect()
            ->route('production.stations.scan', $session)
            ->with('success', 'Sesión de estación iniciada correctamente.');
    }

    public function close(StationSession $stationSession)
    {
        $stationSession->update([
            'is_active' => false,
            'closed_at' => now(),
        ]);

        return redirect()->route('production.runs.show', $stationSession->production_run_id)
            ->with('success', 'Estación cerrada correctamente.');
    }
}
