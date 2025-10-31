<?php

namespace App\Services\Execution;

use App\Models\StationClosure;
use App\Models\DummyTag;
use App\Models\ComponentScan;

class StationClosureService
{
    public function closeStation(array $data): StationClosure
    {
        $dummyId = $data['dummy_tag_id'];

        // Validar componentes escaneados
        $scans = ComponentScan::where('dummy_tag_id', $dummyId)
            ->where('station_id', $data['station_id'])
            ->get();

        $allValid = $scans->every(fn($scan) => $scan->is_valid);
        $summary = [
            'scans_total' => $scans->count(),
            'valid' => $scans->where('is_valid', true)->count(),
            'invalid' => $scans->where('is_valid', false)->count(),
        ];

        $closure = StationClosure::create([
            ...$data,
            'is_complete' => $allValid,
            'validation_summary' => $summary,
            'closed_at' => now(),
        ]);

        // Actualizar estado del Dummy
        $dummy = DummyTag::find($dummyId);
        $dummy->update(['current_station_id' => null]);

        return $closure;
    }
}
