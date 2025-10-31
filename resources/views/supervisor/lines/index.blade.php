@extends('supervisor.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Líneas de Producción</h2>
    <a href="{{ route('supervisor.lines.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nueva Línea</a>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 text-left">Código</th>
            <th class="py-2 px-4 text-left">Nombre</th>
            <th class="py-2 px-4">Activa</th>
            <th class="py-2 px-4">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lines as $line)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $line->code }}</td>
            <td class="py-2 px-4">{{ $line->name }}</td>
            <td class="py-2 px-4 text-center">{{ $line->is_active ? 'Sí' : 'No' }}</td>
            <td class="py-2 px-4 text-center">
                <a href="{{ route('supervisor.lines.edit', $line) }}" class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('supervisor.lines.destroy', $line) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                        onclick="return confirm('¿Eliminar esta línea?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $lines->links() }}</div>
@endsection
