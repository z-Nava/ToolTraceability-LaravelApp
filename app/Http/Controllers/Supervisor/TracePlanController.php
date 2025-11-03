<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\TracePlan;
use App\Models\FGModel;
use App\Models\Station;
use App\Models\ComponentType;
use App\Services\Trace\TracePlanService;
use Illuminate\Http\Request;

class TracePlanController extends Controller
{
    protected TracePlanService $tracePlanService;

    public function __construct(TracePlanService $tracePlanService)
    {
        $this->tracePlanService = $tracePlanService;
    }

    public function index()
    {
        $plans = TracePlan::with('fgModel')->orderBy('id', 'desc')->paginate(10);
        return view('supervisor.trace-plans.index', compact('plans'));
    }

    public function create()
    {
        $fgModels = FGModel::where('is_active', true)->get();
        $stations = Station::where('is_active', true)->get();
        $types = ComponentType::all();

        return view('supervisor.trace-plans.create', compact('fgModels', 'stations', 'types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fg_model_id' => 'required|exists:fg_models,id',
            'version' => 'required|integer|min:1',
            'created_by' => 'required|exists:users,id',
            'requirements' => 'required|array|min:1',
            'requirements.*.station_id' => 'required|exists:stations,id',
            'requirements.*.requirement_mode' => 'required|in:BY_TYPE,BY_PART',
            'requirements.*.component_type_id' => 'nullable|exists:component_types,id',
            'requirements.*.part_number' => 'nullable|string|max:64',
            'requirements.*.min_qty' => 'required|integer|min:1',
        ]);

        $requirements = $data['requirements'];
        unset($data['requirements']);

        $plan = $this->tracePlanService->createPlan($data, $requirements);

        return redirect()->route('supervisor.trace-plans.index')
            ->with('success', 'Plan de trazabilidad creado correctamente.');
    }

    public function show(TracePlan $tracePlan)
    {
        $tracePlan->load('fgModel', 'requirements.station', 'requirements.componentType');
        return view('supervisor.trace-plans.show', compact('tracePlan'));
    }

    public function destroy(TracePlan $tracePlan)
    {
        $tracePlan->delete();
        return redirect()->route('supervisor.trace-plans.index')
            ->with('success', 'Plan eliminado correctamente.');
    }
}
