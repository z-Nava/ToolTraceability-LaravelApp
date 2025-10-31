<?php

namespace App\Services\Production;

use App\Models\DummyTag;

class DummyTagService
{
    public function createDummy(array $data): DummyTag
    {
        return DummyTag::create($data);
    }

    public function updateStation(DummyTag $dummy, int $stationId): void
    {
        $dummy->update(['current_station_id' => $stationId]);
    }

    public function markCompleted(DummyTag $dummy): void
    {
        $dummy->update([
            'status' => 'COMPLETED',
            'closed_at' => now(),
        ]);
    }
}
