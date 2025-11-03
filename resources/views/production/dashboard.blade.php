@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Panel del Líder de Línea</h2>

@if($activeRun)
    {{-- Si ya hay una corrida activa --}}
    <div class="bg-green-100 border border-green-400 p-4 rounded mb-6">
        <h3 class="font-semibold text-green-700 mb-2">Corrida activa</h3>
        <p><strong>Línea:</strong> {{ $activeRun->line->name }}</p>
        <p><strong>Modelo FG:</strong> {{ $activeRun->fgModel->fg_code }} — {{ $activeRun->fgModel->description }}</p>
        <p><strong>Estado:</strong> {{ $activeRun->status }}</p>
        <div class="mt-3">
            <a href="{{ route('production.runs.show', $activeRun) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ir a corrida</a>
        </div>
    </div>
@else
    {{-- Crear nueva corrida --}}
    <div class="bg-white shadow p-6 rounded">
        <h3 class="text-lg font-semibold mb-4">Iniciar nueva corrida de producción</h3>

        <form method="POST" action="{{ route('production.runs.store') }}">
            @csrf

            <label class="block mb-2 font-medium">Línea</label>
            <select name="line_id" class="w-full border rounded p-2 mb-4" required>
                <option value="">Seleccione línea</option>
                @foreach($lines as $line)
                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-medium">Modelo FG</label>
            <select name="fg_model_id" class="w-full border rounded p-2 mb-4" required>
                <option value="">Seleccione modelo</option>
                @foreach($fgModels as $fg)
                    <option value="{{ $fg->id }}">{{ $fg->fg_code }} — {{ $fg->description }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Iniciar Corrida</button>
        </form>
    </div>
@endif
@endsection
