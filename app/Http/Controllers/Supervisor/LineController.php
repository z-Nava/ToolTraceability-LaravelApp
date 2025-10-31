<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index()
    {
        $lines = Line::orderBy('id', 'desc')->paginate(10);
        return view('supervisor.lines.index', compact('lines'));
    }

    public function create()
    {
        return view('supervisor.lines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:lines,code',
            'name' => 'required|string|max:255',
        ]);

        Line::create($data);
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea creada correctamente.');
    }

    public function edit(Line $line)
    {
        return view('supervisor.lines.edit', compact('line'));
    }

    public function update(Request $request, Line $line)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $line->update($data);
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea actualizada.');
    }

    public function destroy(Line $line)
    {
        $line->delete();
        return redirect()->route('supervisor.lines.index')->with('success', 'Línea eliminada.');
    }
}
