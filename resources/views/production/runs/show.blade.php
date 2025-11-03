@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Corrida Activa</h2>

<div class="bg-white shadow p-6 rounded mb-6">
    <p><strong>Línea:</strong> {{ $productionRun->line->name }}</p>
    <p><strong>Modelo FG:</strong> {{ $productionRun->fgModel->fg_code }} — {{ $productionRun->fgModel->description }}</p>
    <p><strong>Estado:</strong> {{ $productionRun->status }}</p>
    <p><strong>Inicio:</strong> {{ $productionRun->started_at->format('d/m/Y H:i') }}</p>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('production.stations.session', $productionRun) }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
            Abrir Estaciones
        </a>
        <form method="POST" action="{{ route('production.runs.end', $productionRun) }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded"
                onclick="return confirm('¿Finalizar corrida?')">Finalizar Corrida</button>
        </form>
    </div>
</div>
@endsection
