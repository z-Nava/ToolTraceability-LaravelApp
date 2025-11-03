@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Registrar nuevo tipo de componente</h2>

<form method="POST" action="{{ route('supervisor.component-types.store') }}" class="bg-white p-6 rounded shadow-md">
    @csrf

    <label class="block mb-2 font-medium">Código</label>
    <input type="text" name="code" class="w-full border rounded p-2 mb-4" placeholder="Ej: SENSOR, SUBASSY, BUTTON" required>

    <label class="block mb-2 font-medium">Nombre</label>
    <input type="text" name="name" class="w-full border rounded p-2 mb-4" placeholder="Ej: Sensor de Torque" required>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('supervisor.component-types.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
