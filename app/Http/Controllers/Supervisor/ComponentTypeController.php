<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ComponentType;
use Illuminate\Http\Request;

class ComponentTypeController extends Controller
{
    public function index()
    {
        $types = ComponentType::orderBy('id', 'desc')->paginate(10);
        return view('supervisor.component-types.index', compact('types'));
    }

    public function create()
    {
        return view('supervisor.component-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:32|unique:component_types,code',
            'name' => 'required|string|max:255',
        ]);

        ComponentType::create($data);

        return redirect()->route('supervisor.component-types.index')
            ->with('success', 'Tipo de componente creado correctamente.');
    }

    public function edit(ComponentType $componentType)
    {
        return view('supervisor.component-types.edit', compact('componentType'));
    }

    public function update(Request $request, ComponentType $componentType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $componentType->update($data);

        return redirect()->route('supervisor.component-types.index')
            ->with('success', 'Tipo de componente actualizado correctamente.');
    }

    public function destroy(ComponentType $componentType)
    {
        $componentType->delete();

        return redirect()->route('supervisor.component-types.index')
            ->with('success', 'Tipo de componente eliminado correctamente.');
    }
}
