<?php 

namespace App\Services\Production;

use App\Models\StationSession;

class StationSessionService
{
    public function openSession(array $data): StationSession
    {
        return StationSession::create($data);
    }

    public function closeSession(StationSession $session): void
    {
        $session->update([
            'is_active' => false,
            'closed_at' => now(),
        ]);
    }

    public function getActiveSession(int $stationId, int $runId): ?StationSession
    {
        return StationSession::where('station_id', $stationId)
            ->where('production_run_id', $runId)
            ->where('is_active', true)
            ->first();
    }
}