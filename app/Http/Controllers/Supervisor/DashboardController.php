<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Line;
use App\Models\Station;
use App\Models\FGModel;
use App\Models\Component;
use App\Models\TracePlan;
use App\Models\ComponentType;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'lines'          => Line::count(),
            'stations'       => Station::count(),
            'fg_models'      => FGModel::count(),
            'components'     => Component::count(),
            'component_types'=> ComponentType::count(),
            'trace_plans'    => TracePlan::count(),
        ];

        return view('supervisor.dashboard', compact('stats'));
    }
}
