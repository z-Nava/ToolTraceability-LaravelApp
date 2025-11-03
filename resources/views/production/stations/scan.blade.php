@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Escaneo de Componentes</h2>

<div class="bg-white p-6 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Estación Activa</h3>
    <p><strong>Estación:</strong> {{ $stationSession->station->name }}</p>
    <p><strong>Corrida:</strong> #{{ $stationSession->production_run_id }}</p>
</div>

<form method="POST" action="{{ route('production.dummy.scan.process', $stationSession) }}" class="bg-white p-6 rounded shadow mb-6">
    @csrf
    <label class="block mb-2 font-medium">Escanear código QR</label>
    <input type="text" name="qr_input" autofocus class="w-full border rounded p-2 mb-4" placeholder="Escanee el QR aquí..." required>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Registrar escaneo</button>
</form>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">{{ session('error') }}</div>
@endif

@if($recentScans->count())
    <h3 class="text-lg font-semibold mb-2">Escaneos recientes</h3>
    <table class="min-w-full bg-white border rounded shadow text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-3 text-left">Componente</th>
                <th class="py-2 px-3 text-left">Tipo</th>
                <th class="py-2 px-3 text-left">Estado</th>
                <th class="py-2 px-3 text-left">Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentScans as $scan)
            <tr class="border-b">
                <td class="py-2 px-3">{{ $scan->part_number_detected }}</td>
                <td class="py-2 px-3">{{ $scan->componentType->name ?? '-' }}</td>
                <td class="py-2 px-3 {{ $scan->is_valid ? 'text-green-600' : 'text-red-600' }}">
                    {{ $scan->is_valid ? 'Válido' : 'Inválido' }}
                </td>
                <td class="py-2 px-3">{{ $scan->scanned_at->format('H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
