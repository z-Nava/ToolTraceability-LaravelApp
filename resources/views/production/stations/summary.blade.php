@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Resumen de Trazabilidad</h2>

<div class="bg-white p-6 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Estación: {{ $stationSession->station->name }}</h3>
    <p><strong>Corrida:</strong> #{{ $stationSession->production_run_id }}</p>
    <p><strong>FG Model:</strong> {{ $stationSession->productionRun->fgModel->fg_code }}</p>
</div>

<table class="min-w-full bg-white border rounded shadow text-sm mb-6">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-3 text-left">Modo</th>
            <th class="py-2 px-3 text-left">Tipo</th>
            <th class="py-2 px-3 text-left">Parte</th>
            <th class="py-2 px-3 text-center">Requerido</th>
            <th class="py-2 px-3 text-center">Escaneado</th>
            <th class="py-2 px-3 text-center">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($summary as $item)
        <tr class="border-b">
            <td class="py-2 px-3">{{ $item['mode'] }}</td>
            <td class="py-2 px-3">{{ $item['component_type'] }}</td>
            <td class="py-2 px-3">{{ $item['part_number'] }}</td>
            <td class="py-2 px-3 text-center">{{ $item['min_qty'] }}</td>
            <td class="py-2 px-3 text-center">{{ $item['fulfilled'] }}</td>
            <td class="py-2 px-3 text-center font-bold {{ $item['is_complete'] ? 'text-green-600' : 'text-red-600' }}">
                {{ $item['is_complete'] ? 'Cumplido' : 'Faltante' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($canClose)
    <form method="POST" action="{{ route('production.stations.close', $stationSession) }}" class="mt-4">
        @csrf
        <input type="hidden" name="confirm_close" value="1">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Cerrar estación</button>
    </form>
@else
    <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded">
        ⚠️ No puedes cerrar la estación todavía. Hay componentes faltantes por escanear.
    </div>
@endif

<a href="{{ route('production.stations.scan', $stationSession) }}" class="inline-block mt-4 text-blue-600 hover:underline">
    ← Volver a escanear
</a>
@endsection
