@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Registrar nuevo componente</h2>

<form method="POST" action="{{ route('supervisor.components.store') }}" class="bg-white p-6 rounded shadow-md">
    @csrf

    <label class="block mb-2 font-medium">Número de parte</label>
    <input type="text" name="part_number" class="w-full border rounded p-2 mb-4" placeholder="Ej: 281161165" required>

    <label class="block mb-2 font-medium">Descripción</label>
    <input type="text" name="description" class="w-full border rounded p-2 mb-4" placeholder="Ej: Sensor de torque">

    <label class="block mb-2 font-medium">Tipo de componente</label>
    <select name="component_type_id" class="w-full border rounded p-2 mb-4" required>
        <option value="">Seleccione un tipo</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('supervisor.components.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
