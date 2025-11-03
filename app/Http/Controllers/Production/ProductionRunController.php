<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\ProductionRun;
use Illuminate\Http\Request;

class ProductionRunController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'fg_model_id' => 'required|exists:fg_models,id',
        ]);

        $data['started_by'] = auth()->id();
        $data['started_at'] = now();
        $data['status'] = 'ACTIVE';

        $run = ProductionRun::create($data);

        return redirect()->route('production.runs.show', $run)
            ->with('success', 'Corrida iniciada correctamente.');
    }

    public function show(ProductionRun $productionRun)
    {
        $productionRun->load('fgModel', 'line');
        return view('production.runs.show', compact('productionRun'));
    }

    public function end(ProductionRun $productionRun)
    {
        $productionRun->update([
            'status' => 'ENDED',
            'ended_at' => now(),
        ]);

        return redirect()->route('production.dashboard')
            ->with('success', 'Corrida finalizada correctamente.');
    }
}
