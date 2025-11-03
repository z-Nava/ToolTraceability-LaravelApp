@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Componentes</h2>
    <a href="{{ route('supervisor.components.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Componente</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">N° Parte</th>
            <th class="py-2 px-4 text-left">Descripción</th>
            <th class="py-2 px-4 text-left">Tipo</th>
            <th class="py-2 px-4 text-center">Activo</th>
            <th class="py-2 px-4 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($components as $component)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $component->part_number }}</td>
            <td class="py-2 px-4">{{ $component->description ?? '-' }}</td>
            <td class="py-2 px-4">{{ $component->componentType->name }}</td>
            <td class="py-2 px-4 text-center">{{ $component->is_active ? 'Sí' : 'No' }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.components.edit', $component) }}" class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('supervisor.components.destroy', $component) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar este componente?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $components->links() }}</div>
@endsection
