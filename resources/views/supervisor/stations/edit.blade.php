@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Editar estación</h2>

<form method="POST" action="{{ route('supervisor.stations.update', $station) }}" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    {{-- Línea --}}
    <label class="block mb-2 font-medium">Línea asignada</label>
    <select name="line_id" class="w-full border rounded p-2 mb-4" required>
        @foreach($lines as $line)
            <option value="{{ $line->id }}" {{ $line->id == $station->line_id ? 'selected' : '' }}>
                {{ $line->name }}
            </option>
        @endforeach
    </select>

    {{-- Código --}}
    <label class="block mb-2 font-medium">Código</label>
    <input type="number" value="{{ $station->code }}" class="w-full border rounded p-2 mb-4 bg-gray-100" disabled>

    {{-- Nombre --}}
    <label class="block mb-2 font-medium">Nombre</label>
    <input type="text" name="name" value="{{ old('name', $station->name) }}" class="w-full border rounded p-2 mb-4" required>

    {{-- Activa --}}
    <label class="inline-flex items-center mb-4">
        <input type="checkbox" name="is_active" value="1" {{ $station->is_active ? 'checked' : '' }}class="mr-2">
        <span>Estación activa</span>
    </label>

    {{-- Botones --}}
    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.stations.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
