@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Estaciones</h2>
    <a href="{{ route('supervisor.stations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nueva Estación</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">Línea</th>
            <th class="py-2 px-4 text-left">Código</th>
            <th class="py-2 px-4 text-left">Nombre</th>
            <th class="py-2 px-4 text-center">Activa</th>
            <th class="py-2 px-4 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stations as $st)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $st->line->name }}</td>
            <td class="py-2 px-4">{{ $st->code }}</td>
            <td class="py-2 px-4">{{ $st->name }}</td>
            <td class="py-2 px-4 text-center">{{ $st->is_active ? 'Sí' : 'No' }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.stations.edit', $st) }}" class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('supervisor.stations.destroy', $st) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar esta estación?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $stations->links() }}</div>
@endsection
