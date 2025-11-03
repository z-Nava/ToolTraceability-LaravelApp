@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Escaneo de Componentes</h2>

<div class="bg-white p-6 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Estación Activa</h3>
    <p><strong>Estación:</strong> {{ $stationSession->station->name }}</p>
    <p><strong>Corrida:</strong> #{{ $stationSession->production_run_id }}</p>
</div>

<form method="POST" action="{{ route('production.dummy.scan.process', $stationSession) }}" class="bg-white p-6 rounded shadow">
    @csrf

    <label class="block mb-2 font-medium">Escanear QR (componente o dummy)</label>
    <input type="text" name="qr_input" autofocus class="w-full border rounded p-2 mb-4" placeholder="Escanee el código..." required>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Registrar</button>
    <a href="{{ route('production.stations.close', $stationSession) }}" class="ml-2 text-gray-600 hover:underline">Cerrar estación</a>
</form>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 mt-4 rounded">
        {{ session('success') }}
    </div>
@endif
@endsection
