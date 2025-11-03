@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Modelos FG</h2>
    <a href="{{ route('supervisor.fg-models.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Modelo</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">Código FG</th>
            <th class="py-2 px-4 text-left">Descripción</th>
            <th class="py-2 px-4 text-center">Activo</th>
            <th class="py-2 px-4 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $model)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $model->fg_code }}</td>
            <td class="py-2 px-4">{{ $model->description }}</td>
            <td class="py-2 px-4 text-center">{{ $model->is_active ? 'Sí' : 'No' }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.fg-models.edit', $model) }}" class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('supervisor.fg-models.destroy', $model) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar este modelo FG?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $models->links() }}</div>
@endsection
