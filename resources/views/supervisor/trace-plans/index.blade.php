@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Planes de Trazabilidad</h2>
    <a href="{{ route('supervisor.trace-plans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Plan</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">ID</th>
            <th class="py-2 px-4 text-left">Modelo FG</th>
            <th class="py-2 px-4 text-left">Versión</th>
            <th class="py-2 px-4 text-center">Activo</th>
            <th class="py-2 px-4 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($plans as $plan)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $plan->id }}</td>
            <td class="py-2 px-4">{{ $plan->fgModel->fg_code }}</td>
            <td class="py-2 px-4 text-center">{{ $plan->version }}</td>
            <td class="py-2 px-4 text-center">{{ $plan->is_active ? 'Sí' : 'No' }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.trace-plans.show', $plan) }}" class="text-blue-600 hover:underline">Ver</a>
                <form action="{{ route('supervisor.trace-plans.destroy', $plan) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar este plan?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $plans->links() }}</div>
@endsection
