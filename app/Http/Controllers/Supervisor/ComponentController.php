<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\ComponentType;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::with('componentType')->orderBy('id', 'desc')->paginate(10);
        return view('supervisor.components.index', compact('components'));
    }

    public function create()
    {
        $types = ComponentType::all();
        return view('supervisor.components.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'part_number' => 'required|string|max:64|unique:components,part_number',
            'description' => 'nullable|string|max:255',
            'component_type_id' => 'required|exists:component_types,id',
        ]);

        Component::create($data);
        return redirect()->route('supervisor.components.index')
            ->with('success', 'Componente creado correctamente.');
    }

    public function edit(Component $component)
    {
        $types = ComponentType::all();
        return view('supervisor.components.edit', compact('component', 'types'));
    }

    public function update(Request $request, Component $component)
    {
        $data = $request->validate([
            'description' => 'nullable|string|max:255',
            'component_type_id' => 'required|exists:component_types,id',
            'is_active' => 'boolean',
        ]);

        $component->update($data);
        return redirect()->route('supervisor.components.index')
            ->with('success', 'Componente actualizado correctamente.');
    }

    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('supervisor.components.index')
            ->with('success', 'Componente eliminado correctamente.');
    }
}
