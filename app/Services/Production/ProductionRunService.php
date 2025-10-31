<?php

namespace App\Services\Production;

use App\Models\ProductionRun;
use Illuminate\Support\Facades\DB;

class ProductionRunService
{
    /**
     * Iniciar una nueva corrida de producción.
     */
    public function startRun(array $data): ProductionRun
    {
        return DB::transaction(function () use ($data) {
            return ProductionRun::create($data);
        });
    }

    /**
     * Finalizar una corrida.
     */
    public function closeRun(ProductionRun $run): bool
    {
        $run->update([
            'status' => 'ENDED',
            'ended_at' => now(),
        ]);

        return true;
    }

    /**
     * Obtener corridas activas por línea.
     */
    public function getActiveRunsByLine(int $lineId)
    {
        return ProductionRun::where('line_id', $lineId)
            ->where('status', 'ACTIVE')
            ->with('fgModel', 'line')
            ->get();
    }
}
