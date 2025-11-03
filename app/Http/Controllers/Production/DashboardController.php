<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\Line;
use App\Models\FGModel;
use App\Models\ProductionRun;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $leader = auth()->user();
        $lines = Line::where('is_active', true)->get();
        $fgModels = FGModel::where('is_active', true)->get();

        $activeRun = ProductionRun::where('started_by', $leader->id)
            ->where('status', 'ACTIVE')
            ->with('fgModel', 'line')
            ->first();

        return view('production.dashboard', compact('leader', 'lines', 'fgModels', 'activeRun'));
    }
}
