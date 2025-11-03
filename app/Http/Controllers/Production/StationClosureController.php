<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\StationClosure;
use App\Models\StationSession;
use Illuminate\Http\Request;

class StationClosureController extends Controller
{
    public function close(StationSession $stationSession)
    {
        StationClosure::create([
            'production_run_id' => $stationSession->production_run_id,
            'station_id' => $stationSession->station_id,
            'dummy_tag_id' => null, // puede agregarse al cierre real
            'closed_by' => auth()->id(),
            'closed_at' => now(),
            'is_complete' => true,
            'validation_summary' => json_encode(['status' => 'OK']),
        ]);

        $stationSession->update(['is_active' => false, 'closed_at' => now()]);

        return redirect()->route('production.runs.show', $stationSession->production_run_id)
            ->with('success', 'Estación cerrada correctamente.');
    }
}
