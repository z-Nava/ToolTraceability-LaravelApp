<?php

namespace App\Services\Trace;

use App\Models\TracePlan;
use App\Models\TracePlanRequirement;
use Illuminate\Support\Facades\DB;

class TracePlanService
{
    public function createPlan(array $data, array $requirements): TracePlan
    {
        return DB::transaction(function () use ($data, $requirements){
           $plan = TracePlan::create($data);
           
           foreach ($requirements as $req)
            {
                $req['trace_plan_id'] = $plan->id;
                TracePlanRequirement::create($req);
            }
              return $plan->load('requirements');
        });
    }

    public function getActivePlanByFG(int $fgModelId): ?TracePlan
    {
        return TracePlan::where('fg_model_id', $fgModelId)
            ->where('is_active', true)
            ->with('requirements.station', 'requirements.componentType')
            ->latest('version')
            ->first();
    }

    public function deactivateOldPlan(TracePlan $plan): void
    {
       TracePlan::where('fg_model_id', $plan->fg_model_id)
            ->where('id', '!=', $plan->id)
            ->update(['is_active' => false]);
    }
}