@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Abrir estación</h2>

<div class="bg-white p-6 rounded shadow">
    <h3 class="text-lg font-semibold mb-4">Corrida actual</h3>
    <p><strong>Línea:</strong> {{ $productionRun->line->name }}</p>
    <p><strong>Modelo FG:</strong> {{ $productionRun->fgModel->fg_code }} — {{ $productionRun->fgModel->description }}</p>

    <form method="POST" action="{{ route('production.stations.store', $productionRun) }}" class="mt-6">
        @csrf
        <label class="block mb-2 font-medium">Seleccionar estación</label>
        <select name="station_id" class="w-full border rounded p-2 mb-4" required>
            <option value="">Seleccione estación</option>
            @foreach($stations as $station)
                <option value="{{ $station->id }}">{{ $station->line->name }} — {{ $station->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Abrir Estación</button>
        <a href="{{ route('production.runs.show', $productionRun) }}" class="ml-2 text-gray-600 hover:underline">Volver</a>
    </form>
</div>
@endsection
