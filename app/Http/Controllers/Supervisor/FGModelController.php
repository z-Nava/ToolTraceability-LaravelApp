<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\FGModel;
use Illuminate\Http\Request;

class FGModelController extends Controller
{
    public function index()
    {
        $models = FGModel::orderBy('id', 'desc')->paginate(10);
        return view('supervisor.fg-models.index', compact('models'));
    }

    public function create()
    {
        return view('supervisor.fg-models.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fg_code' => 'required|string|max:16|unique:fg_models,fg_code',
            'description' => 'required|string|max:255',
        ]);

        FGModel::create($data);

        return redirect()->route('supervisor.fg-models.index')
            ->with('success', 'Modelo FG creado correctamente.');
    }

    public function edit(FGModel $fgModel)
    {
        return view('supervisor.fg-models.edit', compact('fgModel'));
    }

    public function update(Request $request, FGModel $fgModel)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $fgModel->update($data);

        return redirect()->route('supervisor.fg-models.index')
            ->with('success', 'Modelo FG actualizado correctamente.');
    }

    public function destroy(FGModel $fgModel)
    {
        $fgModel->delete();
        return redirect()->route('supervisor.fg-models.index')
            ->with('success', 'Modelo FG eliminado correctamente.');
    }
}
