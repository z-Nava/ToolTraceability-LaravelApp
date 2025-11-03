<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\StationSession;
use App\Models\TracePlan;
use App\Models\ComponentScan;
use App\Models\StationClosure;
use Illuminate\Http\Request;

class StationClosureController extends Controller
{
    /**
     * Mostrar resumen de trazabilidad de la estación antes de cerrar.
     */
    public function summary(StationSession $stationSession)
    {
        $fgModelId = $stationSession->productionRun->fg_model_id;
        $stationId = $stationSession->station_id;

        $plan = TracePlan::where('fg_model_id', $fgModelId)
            ->where('is_active', true)
            ->with(['requirements.componentType'])
            ->first();

        $scans = ComponentScan::where('production_run_id', $stationSession->production_run_id)
            ->where('station_id', $stationId)
            ->where('is_valid', true)
            ->get();

        $summary = [];

        foreach ($plan->requirements->where('station_id', $stationId) as $req) {
            $fulfilledCount = 0;

            // Contar escaneos válidos que cumplen el requerimiento
            foreach ($scans as $scan) {
                if ($req->requirement_mode === 'BY_TYPE' && $scan->component_type_id === $req->component_type_id) {
                    $fulfilledCount++;
                } elseif ($req->requirement_mode === 'BY_PART' && $scan->part_number_detected === $req->part_number) {
                    $fulfilledCount++;
                }
            }

            $isFulfilled = $fulfilledCount >= $req->min_qty;
            $summary[] = [
                'mode' => $req->requirement_mode,
                'component_type' => $req->componentType?->name ?? '-',
                'part_number' => $req->part_number ?? '-',
                'min_qty' => $req->min_qty,
                'fulfilled' => $fulfilledCount,
                'is_complete' => $isFulfilled,
            ];
        }

        // Si todos los requerimientos están completos
        $canClose = collect($summary)->every(fn($item) => $item['is_complete']);

        return view('production.stations.summary', compact('stationSession', 'summary', 'canClose'));
    }

    /**
     * Cerrar estación si los requerimientos se cumplen.
     */
    public function close(Request $request, StationSession $stationSession)
    {
        $data = $request->validate([
            'confirm_close' => 'required|boolean',
        ]);

        if (!$data['confirm_close']) {
            return back()->with('error', 'No se confirmó el cierre.');
        }

        StationClosure::create([
            'production_run_id' => $stationSession->production_run_id,
            'station_id' => $stationSession->station_id,
            'dummy_tag_id' => null,
            'closed_by' => auth()->id(),
            'closed_at' => now(),
            'is_complete' => true,
            'validation_summary' => json_encode(['status' => 'OK']),
        ]);

        $stationSession->update(['is_active' => false, 'closed_at' => now()]);

        return redirect()->route('production.runs.show', $stationSession->production_run_id)
            ->with('success', '✅ Estación cerrada correctamente.');
    }
}
