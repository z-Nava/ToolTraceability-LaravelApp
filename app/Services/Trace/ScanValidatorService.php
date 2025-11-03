<?php

namespace App\Services\Trace;

use App\Models\TracePlan;
use App\Models\Component;
use App\Models\ComponentType;
use App\Models\TracePlanRequirement;

class ScanValidatorService
{
    /**
     * Valida si un componente escaneado pertenece al plan activo.
     */
    public function validateComponent(int $fgModelId, int $stationId, ?Component $component, ?string $partNumberRaw): array
    {
        $plan = TracePlan::where('fg_model_id', $fgModelId)
            ->where('is_active', true)
            ->with('requirements')
            ->first();

        if (!$plan) {
            return [
                'is_valid' => false,
                'error' => 'No existe un plan activo para este modelo FG.',
            ];
        }

        // Filtrar requerimientos por estación
        $requirements = $plan->requirements->where('station_id', $stationId);

        if ($requirements->isEmpty()) {
            return [
                'is_valid' => false,
                'error' => 'Esta estación no tiene requerimientos configurados en el plan.',
            ];
        }

        // Verificar coincidencia por tipo o por número de parte
        foreach ($requirements as $req) {
            if ($req->requirement_mode === 'BY_TYPE' && $component && $component->component_type_id == $req->component_type_id) {
                return ['is_valid' => true, 'error' => null];
            }

            if ($req->requirement_mode === 'BY_PART' && $req->part_number === $component?->part_number) {
                return ['is_valid' => true, 'error' => null];
            }

            if ($req->requirement_mode === 'BY_PART' && str_contains($partNumberRaw, $req->part_number)) {
                return ['is_valid' => true, 'error' => null];
            }
        }

        return [
            'is_valid' => false,
            'error' => 'Componente no requerido por el plan de trazabilidad para esta estación.',
        ];
    }
}
