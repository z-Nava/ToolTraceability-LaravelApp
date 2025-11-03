@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Crear nueva estación</h2>

<form method="POST" action="{{ route('supervisor.stations.store') }}" class="bg-white p-4 shadow rounded">
    @csrf

    <label class="block mb-2 font-medium">Línea</label>
    <select name="line_id" class="w-full border rounded p-2 mb-4" required>
        <option value="">Seleccione una línea</option>
        @foreach($lines as $line)
            <option value="{{ $line->id }}">{{ $line->name }}</option>
        @endforeach
    </select>

    <label class="block mb-2 font-medium">Código</label>
    <input type="number" name="code" class="w-full border rounded p-2 mb-4" required>

    <label class="block mb-2 font-medium">Nombre</label>
    <input type="text" name="name" class="w-full border rounded p-2 mb-4" required>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    <a href="{{ route('supervisor.stations.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
</form>
@endsection
