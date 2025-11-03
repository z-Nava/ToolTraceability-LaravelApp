@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Panel del Supervisor</h2>

{{-- Sección de estadísticas --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Líneas</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['lines'] }}</p>
    </div>
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Estaciones</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['stations'] }}</p>
    </div>
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Modelos FG</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['fg_models'] }}</p>
    </div>
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Componentes</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['components'] }}</p>
    </div>
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Tipos de Componente</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['component_types'] }}</p>
    </div>
    <div class="bg-white shadow rounded p-4 text-center">
        <h3 class="text-gray-600 text-sm uppercase">Planes de Trazabilidad</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['trace_plans'] }}</p>
    </div>
</div>

{{-- Sección de accesos rápidos --}}
<h3 class="text-xl font-semibold mb-3">Accesos Rápidos</h3>
<div class="grid md:grid-cols-3 gap-4">
    <a href="{{ route('supervisor.lines.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded text-center shadow">
        📋 Líneas de Producción
    </a>
    <a href="{{ route('supervisor.stations.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded text-center shadow">
        🏭 Estaciones
    </a>
    <a href="{{ route('supervisor.fg-models.index') }}" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded text-center shadow">
        🧰 Modelos FG
    </a>
    <a href="{{ route('supervisor.components.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white p-4 rounded text-center shadow">
        🔩 Componentes
    </a>
    <a href="{{ route('supervisor.component-types.index') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white p-4 rounded text-center shadow">
        ⚙️ Tipos de Componente
    </a>
    <a href="{{ route('supervisor.trace-plans.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded text-center shadow">
        📊 Planes de Trazabilidad
    </a>
</div>

{{-- Sección opcional de bienvenida --}}
<div class="mt-10 bg-white shadow p-6 rounded">
    <h3 class="text-lg font-semibold mb-2">Bienvenido, {{ auth()->user()->name }}</h3>
    <p class="text-gray-700 leading-relaxed">
        Desde este panel puedes administrar todos los elementos relacionados con la trazabilidad de herramientas:
        líneas, estaciones, modelos FG, componentes y planes de trazabilidad.  
        Usa los accesos rápidos o el menú superior para navegar entre los módulos.
    </p>
</div>
@endsection
