@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Tipos de Componentes</h2>
    <a href="{{ route('supervisor.component-types.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Tipo</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">Código</th>
            <th class="py-2 px-4 text-left">Nombre</th>
            <th class="py-2 px-4 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $type->code }}</td>
            <td class="py-2 px-4">{{ $type->name }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.component-types.edit', $type) }}" class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('supervisor.component-types.destroy', $type) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar este tipo de componente?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $types->links() }}</div>
@endsection
